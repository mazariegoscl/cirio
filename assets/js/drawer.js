
let Drawer = {
	init ( bundle ) {
		this.cacheDOM();
		this.bindListener();
		this.draggAvalible = false;
		if ( bundle ) {
			let type = typeof bundle
			if ( type === 'object' ) {
				this.renderPrepare( bundle.main );
				this.renderHeader( bundle.main );
				this.renderOptions( bundle.menu );
			} else {
				console.log('%c Unexpected type of parameter, it was expected a JSON bundle', 'background: orange; color: white; font-size: 15px; font-family: Roboto Mono;');
			}
		}
	},
	setTriggerStatus () {
		try {
			this.$trigger.classList.toggle('drawer_actived');
		} catch (err) {}
	},
	draggingMenu (e) {
		this.posX = e.touches[0].clientX
		if ( this.draggAvalible && this.posX < 300 ) {
			this.$drawer.style.transform = `translateX(${(-300 + this.posX) + 'px'})`;
			this.$modal.style.opacity = (this.posX / 200);
		}
	},
	startDraggingMenu (e) {
		if ( e.touches[0].clientX < 20 && !this.$drawer.classList.contains('actived') ) {
			this.draggAvalible = true;
			this.$modal.style.display = 'block';
		} else if ( e.touches[0].clientX > 280 && this.$drawer.classList.contains('actived') ) {
			this.draggAvalible = true;
		}
	},
	disableDraggingMenu () {

		this.$drawer.style.transition = '0.2s ease';
		this.$modal.style.transition = '0.2s ease';

		if ( this.posX > 100 && this.draggAvalible && !this.$drawer.classList.contains('actived') ) {
			this.$drawer.classList.add('actived');
			this.$drawer.style.transform = 'translateX(0px)';
			this.draggAvalible = false;
			this.$modal.style.opacity = '1';
			setTimeout(() => {
				this.$modal.style.transition = 'none';
			}, 200);
		} else if ( this.posX <= 100 && this.draggAvalible && !this.$drawer.classList.contains('actived') ) {
			this.$drawer.classList.remove('actived');
			this.$drawer.style.transform = 'translateX(-300px)';
			this.$modal.style.opacity = '0';
			this.draggAvalible = false;
			setTimeout(() => {
				this.$modal.style.display = 'none';
			}, 200);
		} else if ( this.posX < 290 && this.draggAvalible && this.$drawer.classList.contains('actived')) {
			this.$drawer.classList.remove('actived');
			this.$drawer.style.transform = 'translateX(-300px)';
			this.$modal.style.opacity = '0';
			this.draggAvalible = false;
			setTimeout(() => {
				this.$modal.style.display = 'none';
			}, 200);
		} else if ( this.posX >= 290 && this.draggAvalible && this.$drawer.classList.contains('actived')) {
			this.$drawer.classList.add('actived');
			this.$drawer.style.transform = 'translateX(0px)';
			this.draggAvalible = false;
		}

		this.setTriggerStatus();

		setTimeout(() => {
			this.$drawer.style.transition = 'none';
			this.$modal.style.transition = 'none';
		}, 200);
	},
	controlDrawer () {
		this.$drawer.style.transition = '0.2s ease';
		this.$modal.style.transition = '0.2s ease';

		this.$drawer.classList.toggle('actived')

		if ( !this.$drawer.classList.contains('actived') ) {
			this.$drawer.style.transform = 'translateX(-300px)';
			this.$modal.style.opacity = '0';
			setTimeout(() => {
				this.$modal.style.display = 'none';
			}, 200);
		} else {
			this.$drawer.style.transform = 'translateX(0px)';
			this.$modal.style.display = 'block';
			this.$modal.style.opacity = '1';
		}

		this.setTriggerStatus();

		setTimeout(() => {
			this.$drawer.style.transition = 'none';
			this.$modal.style.transition = 'none';
		}, 200);
	},
	renderPrepare () {
		this.$drawer.innerHTML = `
		<div class="__header"></div>
		<div class="__menu"></div>
		`;
		this.$_header = this.$drawer.querySelector('.__header');
		this.$_menu = this.$drawer.querySelector('.__menu');
	},
	renderHeader ( bundle ) {
		this.$_header.setAttribute('style', `background-image: url('${ bundle.background }')`)
		this.$_header.innerHTML = `
		<span class="__user_photo" style="background-image: url('${ bundle.photo }')"></span>
		<span class="__main_title">${ bundle.title }</span>
		<span class="__sub_title">${ bundle.subtitle }</span>
		`;
	},
	renderOptions ( bundle ) {
		let itemTemporal = '';
		bundle.forEach( ( item, index ) => {

			if ( item.separator ) {
				itemTemporal += `<li class="__menu_separator"><hr> <p>${ item.separator }</p></li>`;
			} else {
				itemTemporal += '<li>';
				if ( item.icon && item.label && item.action ) {

					if ( item.action ) {
						if ( typeof item.action === 'string' ) {
							itemTemporal += `<a class="__menu_action" href="${item.action}">`
						} else if ( typeof item.action === 'function' ) {
							itemTemporal += `<a class="__menu_action" onclick="${ item.action.name }()">`
						}
					} else {
						console.warn( `"${ item.label }" can´t be binded to ${ item.action }... we expected a function or string as a parameter` )
					}

					if ( item.icon ) {
						itemTemporal += `<i class="material-icons __menu_icon">${item.icon.replace(/ /g, '_')}</i>`;
					} else {
						itemTemporal += `<i class="material-icons __menu_icon"></i>`;
					}

					if ( item.label ) {
						itemTemporal += `<span class="__menu_item_label">${item.label}</span>`;
					} else {
						console.warn(`missing label on this item: ${item.route}`)
						itemTemporal += `<span class="__menu_item_label" style="color: red;">label n/a</span>`;
					}
				} else {
					console.error(`[MENÚ OPTIONS]: index ${ index + 1 } can't be created correctly`);
				}
				itemTemporal += '</a></li>';
			}

		});

		this.$_menu.innerHTML = '<ul class="__menu_items">' + itemTemporal + '</ul>';
	},
	bindListener () {
		window.addEventListener('touchstart', this.startDraggingMenu.bind(this));
		window.addEventListener('touchend', this.disableDraggingMenu.bind(this));
		window.addEventListener('touchmove', this.draggingMenu.bind(this));
		this.$modal.addEventListener('click', () => {
			console.log(this.posX)
			this.posX = 101;
			this.controlDrawer()
		});
		try {
			this.$trigger.addEventListener('click', this.controlDrawer.bind(this));
		} catch ( err ) {}
	},
	cacheDOM () {
		this.$drawer = document.getElementById('drawer_js');
		this.$modal = document.querySelector('.__modal_drawer');
		try {
			this.$trigger = document.getElementById('mdrawer_trgger');
		} catch ( err ) {}
	}
};
