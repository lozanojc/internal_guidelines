(function($)
{
	/**
	 *  Vytvoří thickbox galerii
	 *  @class Skbox
	 *  @param {Object} options Instance settings
	 *  @author <a href="mailto: michal.matuska@superkoderi.cz">Michal Matuška</a>
	 *  @version 2 beta
	 *
	 *  Minor todo
	 *  - modal
	 *  - trigrovat více událostí
     *  - sjednotit load pro inline, html a ajax
     *  - zrevidovat load
     *  - okmentovat jsDoc
	 */
	sk.widgets.Skbox = function (options)
	{
		this.options = $.extend(true, {
			'margin': [20, 20], // sum margin on x and y axis
			'padding': [16, 16], // sum padding on x and y axis
			'width': 800,
			'height': 600,
			'tpl': {
				'overlay': '<div class="skbox-overlay"></div>',
				'box': '\
					<div class="skbox-window"> \
						<div class="skbox-inner"> \
							<div class="skbox-slides"></div> \
							<span class="skbox-loader"></span> \
						</div> \
						<a href="#" class="skbox-prev">prev</a> \
						<a href="#" class="skbox-next">next</a> \
						<div class="skbox-pages"></div> \
						<a href="#" class="skbox-close"></a> \
					</div>',
				'slide': ' \
					<div class="skbox-slide"> \
						<div class="skbox-content"> \
							<div class="skbox-spc"></div> \
							<div class="skbox-loader"></div> \
						</div> \
						<div class="skbox-title"></div> \
					</div>',
				'page': function(current, index)
				{
					return '<a href="#" class="skbox-page">'+ ( current.thumb ? '<img src="'+ current.thumb +'" />' : index )+'</a>'
				}
			},
			'fixed': true,
			'modal': false,
			'delegate': true,
			'selector': '.thickbox',
			'groupAttr': 'data-rel',
			'event': 'click',
			'errors': {
				'html': 'nelze načíst html',
				'ajax': 'url pro ajax požadavek nelze načíst',
				'img': 'ulr obrázku nejde načíst'
			},
			'ajax': {
				'dataType': 'html',
				'type': 'GET'
			}
		}, options);

		this.handlers = [];
		this.group = [];
		this.eventName = this.options.event + '.skbox';

		this.isCreated = false;
		this.isOpen = false;

		this.index = 0;

		this.current = {};
		this.$currentSlide = $([]);
	};

	var _class = sk.widgets.Skbox;
	var _fn = _class.prototype;


	_fn.trigger = function(eventName)
	{
		sk.mediator.trigger(eventName + '.widgets.Skbox', [{
			'target': this
		}]);

		$(this).trigger(eventName + '.skbox');
	}

	// Prototype mehtods
	_fn.init = function()
	{
		var o = this.options;

		this.control(o.selector, o.delegate);

		return this;
	}

	_fn.destroy = function()
	{
		this.controlOff();

		this.$w
			.off('resize.skbox');

		// handle close
		this.$overlay
			.off('click.skbox');

		this.$box
			.off('click.skbox');

		this.$overlay.remove();
		this.$box.remove();

		$(this)
			.off('changeslide.skbox', this.handleChange );

		this.isCreated = false;

		return this;
	}

	/**
	 * Open thickbox
	 * @param  {String|String[]|Object[]|NodeList} group
	 * @param  {Number} index
	 * @return {sk.widgets.Thickbox}
	 */
	_fn.open = function(group, index)
	{
		// group is not defined
		if(!group)
		{
			return this;
		}

		// group is not array
		if(!$.isArray(group))
		{
			// is jquery, string or object
			var group = group.jquery ? group.get() : [group]
		}

		// iterate array
		$.each(group, $.proxy(function(i, element)
		{
			var obj = { };

			if ( this.isObject(element) )
			{
				// element is html node
				if (element.nodeType)
				{
					element = $(element);
				}
				// element is jquery
				if( element.jquery )
				{
					obj = {
						'href': element.data('skbox-href') || element.attr('href'),
						'title': element.data('skbox-title') || element.attr('title'),
						'type': element.data('skbox-type'),
						'thumb': element.data('skbox-thumb'),
						'$element': element
					};
				}
				else
				{
					obj = element;
				}
			}

			var href = obj.href || ( this.isString(element) ? element : null );
			var title = obj.title || '';
			var content = obj.content || '';
			var type = content ? 'html' : (obj.type || '');
			var selector;

			if( this.isString(href) )
			{
				if( !type )
				{
					// Href is image
					if( this.isImage(href) )
					{
						type = 'image';
					}
					// Href is inline content
					else if( this.isHash(href) )
					{
						type = 'inline';
					}
					// fallback, href is ajax
					else
					{
						type = 'ajax';
					}
				}

				if( type === 'ajax' )
				{
					hrefParts = href.split(/\s+/, 2);
					href = hrefParts.shift();
					selector = hrefParts.shift();
				}
			}

			// create object from data
			$.extend(obj, {
				href     : href,
				type     : type,
				content  : content,
				title    : title,
				selector : selector
			});

			// replace group
			group[ i ] = obj;

		}, this))

		this.group = group;
		this.isGroup = this.group.length > 1;
		this.index = index;

		this.run();

		return this;
	}

	_fn.run = function()
	{
		!this.isCreated && this.create();
		!this.isOpen && this.show();

		// Current item from group
		var current = this.current = this.group[this.index];

		var o = this.options;
		var $slide = $( o.tpl.slide );
		var $title = $slide.find('> .skbox-title');
		var $content = $slide.find('> .skbox-content');
		var $spc = $content.find('> .skbox-spc').addClass('has-loading');

		// Remove old slide
		this.$currentSlide
			.stop()
			.fadeOut(400, function()
			{
				$(this).remove();
			});

		$title
			.text(current.title);

		$slide
			.css( 'opacity', 0 )
			.appendTo( this.$slides )
			.toggleClass( 'no-title', !$title.height() )
			.addClass( 'type-'+current.type )
			.on('afterload', function(event)
			{
				$(this).fadeTo(400, 1)
			});

		$content
			.height( this.dims.height - ( $slide.is('.no-title') ? 0 : $title.outerHeight(true) ) )

		// Preload type
		this.load( $spc )

		// Set current slide
		this.$currentSlide = $slide;

		this.trigger('changeslide');
	}

	_fn.load = function( $content )
	{
		this.trigger('beforeload');

		var o = this.options,
			current = this.current,
			scrollble = this.isScrollable,
            that = this;

		// Image
		if(current.type === 'image')
		{
			$('<img/>')
				.on('load error', function(e)
				{
					$content
						// span is for vertical-align
						.append( e.type === 'load' ? '<span></span><img src="'+ current.href +'">' : o.errors.img )
						.removeClass('has-loading')
						.trigger('afterload');

                    that.trigger('afterload');
				})
				.attr('src', current.href);
		}

		// Html
		if(current.type === 'html')
		{
			$content
				.append( current.content ? current.content : o.errors.html )
				.toggleClass( 'has-scroll', scrollble( $content ) )
				.removeClass('has-loading')
				.trigger('afterload');

            that.trigger('afterload');
		}

		// Inline
		if(current.type === 'inline')
		{
			var content = (current.href && current.href.length > 1) ? $(current.href).html() : '';

			$content
				.append( content ? content : o.errors.html )
				.toggleClass( 'has-scroll', scrollble( $content ) )
				.removeClass('has-loading')
				.trigger('afterload');

            that.trigger('afterload');
		}

		// Ajax
		if(current.type === 'ajax')
		{
			var load = function(content, status)
			{
				$content
					.append( status === "success" ? content : o.errors.html )
					.toggleClass( 'has-scroll', scrollble( $content ) )
					.removeClass('has-loading')
					.trigger('afterload');

               that.trigger('afterload');
			}

			$.ajax( $.extend( o.ajax, {
				'url': current.href,
				'error': load,
				'success': load
			}))
		}
	}

	_fn.create = function()
	{
		this.$w = $(window);
		this.$d = $(document);
		this.$b = $('body');

		// insert box html to DOM
		this.$overlay = $( this.options.tpl.overlay ).hide().appendTo( this.$b );
		this.$box = $( this.options.tpl.box ).hide().appendTo( this.$b );
		this.$slides = this.$box.find('.skbox-slides');
		this.$pages = this.$box.find('.skbox-pages');

		$(this)
			.on('changeslide.skbox', $.proxy(this.handleChange, this));

		this.isCreated = true;
	}

	_fn.show = function()
	{
		this.dims = this.getDimensions();

		// handle window resize
		this.$w
			.on('resize.skbox', $.proxy(this.handleResize, this));

		// handle close
		this.$overlay
			.on('click.skbox', $.proxy(this.handleClose, this));

		this.$box
			.on('click.skbox', '.skbox-close', $.proxy(this.handleClose, this))
			.on('click.skbox', '.skbox-prev', $.proxy(this.handlePrev, this))
			.on('click.skbox', '.skbox-next', $.proxy(this.handleNext, this))
			.on('click.skbox', '.skbox-page', $.proxy(this.handlePage, this))
			// handle keys
			.on('keydown.skbox', $.proxy(this.handleKeys, this))
			// state class
			.toggleClass('skbox-window-fixed', this.options.fixed)
			.toggleClass('skbox-window-group', this.isGroup)
			// set dimensions
			.css( this.dims )
			// element with tabindex is focusable
			.attr('tabindex', '-1')

		// pager
		var pages = '';
		for (var i = 0, l = this.group.length; i < l;)
		{
			pages += this.options.tpl.page(this.group[i], ++i);
		}

		this.$pages
			.html(pages)


		// callback
		this.trigger('beforeshow');

		// box and overlay show
		this.$box
			.add( this.$overlay )
				.stop()
				.fadeIn();

		// focus window for better accesibility
		this.$box
			.focus();

		this.isOpen = true;
	}

	_fn.hide = function()
	{
		this.$w
			.off('.skbox');

		this.$overlay
			.off('.skbox');

		this.$box
			.off('.skbox');

		// box and overlay hide
		this.$box
			.add( this.$overlay )
				.stop()
				.fadeOut($.proxy(function()
				{
					this.$slides.empty();
					// callback
					this.trigger('afterhide');

				}, this));
	}

	_fn.close = function()
	{
		this.hide();

		this.isOpen = false;

		return this;
	}

	_fn.resize = function()
	{
		this.dims = this.getDimensions();

		this.$box
			.css( this.dims );

		var $slide = this.$currentSlide;
		var $title = $slide.find('> .skbox-title');
		var $content = $slide.find('> .skbox-content');
		var $spc = $content.find('> .skbox-spc');

		$content
			.height( this.dims.height - ( $slide.is('.no-title') ? 0 : $title.outerHeight(true) ) )

		$spc
			.toggleClass( 'has-scroll', this.isScrollable( $spc ) );

		return this;
	}

	_fn.next = function()
	{
		if(this.isGroup)
		{
			this.index = (this.index + 1) % this.group.length;
			this.run();
		}

		return this;
	}

	_fn.prev = function()
	{
		if(this.isGroup)
		{
			this.index = (this.index - 1 + this.group.length) % this.group.length;
			this.run();
		}

		return this;
	}

	_fn.goTo = function(index)
	{
		if(this.isGroup)
		{
			this.index = index;
			this.run();
		}

		return this;
	}

	_fn.getDimensions = function()
	{
		var o = this.options,
			width = o.width,
			height = o.height,
			viewport = this.getViewport(),
			maxWidth = viewport.width - o.margin[0],
			maxHeight = viewport.height - o.margin[1];

		if(o.fixed)
		{
			viewport.x = viewport.y = 0;
		}

		width = Math.min(width, maxWidth);
		height = Math.min(height, maxHeight);

		return {
			'top': viewport.y + (viewport.height - height) / 2,
			'left': viewport.x + (viewport.width - width) / 2,
			'width': width - o.padding[0],
			'height': height - o.padding[1]
		}
	}

	_fn.getViewport = function()
	{
		var $w = this.$w;

		return {
			width: $w.width(),
			height: $w.height(),
			x: $w.scrollLeft(),
			y: $w.scrollTop()
		}
	}

	_fn.control = function(selector, delegate)
	{
		var $element = $(document),
			items = selector;

		if(selector.jquery || !delegate)
		{
			$element = $(selector);
			items = null;
		}

		// Handle function
		var handle = function(e)
		{
			e.preventDefault();

			var $target = $(e.currentTarget),
				$all = $(selector),
				$group = $target,
				attr = this.options.groupAttr,
				rel = $target.attr( attr ),
				index = 0;

			if( rel && rel !== 'nofollow')
			{
				$group = $all.filter('[' + attr + '="' + rel + '"]');
				index  = $group.index( $target );
			}

			this.open( $group, index )
		};

		$element
			.off( this.eventName, items )
			.on( this.eventName, items, $.proxy(handle, this) );

		// save controled elements
		this.handlers.push({
			'$element': $element,
			'items': items
		})
	}

	_fn.controlOff = function()
	{
		var arr = this.handlers,
			obj;

		while( obj = arr.shift() )
		{
			obj.$element
				.off( this.eventName, obj.items )
		}
	}

	// Handlers
	// on resize
	_fn.handleResize = function()
	{
		this.resize();
	}

	// on keydown
	_fn.handleKeys = function(e)
	{
		if( !$(e.target).is('select, input, textarea') && e.keyCode === 37 || e.keyCode === 39 || e.keyCode === 27  )
		{
			e.stopPropagation();
			e.preventDefault();

			(e.keyCode === 37) && this.prev();
			(e.keyCode === 39) && this.next();
			(e.keyCode === 27) && this.close();
		}
	}

	// on close
	_fn.handleClose = function(e)
	{
		e.preventDefault();

		this.close()
	}
	// on prev
	_fn.handlePrev = function(e)
	{
		e.preventDefault();

		this.prev();
	}
	// on next
	_fn.handleNext = function(e)
	{
		e.preventDefault();

		this.next();
	}
	// on page
	_fn.handlePage = function(e)
	{
		e.preventDefault();

		this.goTo( $(e.currentTarget).index() );
	}

	// on page
	_fn.handleChange = function(e)
	{
		this.$box.find('.skbox-page')
			.removeClass('active')
			.filter(':nth-child('+ (this.index + 1) +')')
			.addClass('active');
	}

	// Test methods
	_fn.isString = function(str)
	{
		return $.type( str ) === "string";
	}

	_fn.isObject = function(obj)
	{
		return $.type(obj) === "object";
	}

	_fn.isImage = function(str)
	{
		return this.isString(str) && str.match(/(^data:image\/.*,)|(\.(jp(e|g|eg)|gif|png|bmp|webp)((\?|#).*)?$)/i);
	}

	_fn.isHash = function(str)
	{
		return this.isString(str) && str.charAt(0) === '#';
	}

	_fn.isScrollable = function( $element )
	{
		return ( $element.prop('scrollHeight') - $element.height() ) > 0
	}

})(jQuery);
