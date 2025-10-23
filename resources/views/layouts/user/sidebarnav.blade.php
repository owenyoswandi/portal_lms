<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
        <!-- Dynamic Menu will be added here -->
    </ul>
</aside>

<script>
	const storedUserData = JSON.parse(localStorage.getItem('userData'));
	const userRole = storedUserData.role
		
	var get_segmen_url = '<?php echo request()->segment(1); ?>';
	if (get_segmen_url == 'profiling' || get_segmen_url == 'profiling-edit')
	{
		const li = document.createElement("li");
		li.innerHTML = `<li class="menu-item nav-item"><a href="<?= url('/profiling-edit') ?>" class="nav-link collapsed "><i class="bx bx-user-circle" style="transform: scaleX(-1);"></i><div>Change Personal Data</div></a></li>`;
		document.getElementById("sidebar-nav").appendChild(li);
	} else {
		var menuData = <?php echo json_encode($menuData[0]->menu); ?>;
		
		var sidebarNav = document.getElementById('sidebar-nav');
		var currentRouteName = window.location.href;

		function createMenu(menu) {



			var activeClass = '';

			// if (currentRouteName.includes(slug)) {
			if (Array.isArray(menu.slug)) {
				menu.slug.forEach(function(slug) {
					if (currentRouteName.includes(slug)) {
						activeClass = 'active';
					}
				});
			} else if (currentRouteName == menu.slug) {
				activeClass = 'active';
			}
			// }

			if (menu.submenu) {
				var submenuTargetId = menu.slug ? 'submenu-' + menu.slug.split('/').pop() : null;
				if (Array.isArray(menu.slug)) {
					menu.slug.forEach(function(slug) {
						if (currentRouteName.includes(slug) && currentRouteName.indexOf(slug) === 0) {
							activeClass = 'active open';
						}
					});
				} else {
					if (currentRouteName.includes(menu.slug) && currentRouteName.indexOf(menu.slug) === 0) {
						activeClass = 'active open';
					}
				}
			}


			

			var li = document.createElement('li');
			li.className = 'menu-item nav-item';

			var a = document.createElement('a');
			a.href = menu.url ? `{{ url('${menu.url}') }}` : 'javascript:void(0);';
			a.className = 'nav-link collapsed ' + activeClass;

			if (menu.submenu) {
				a.setAttribute('data-bs-target', '#' + submenuTargetId);
				a.setAttribute('data-bs-toggle', 'collapse');
				a.setAttribute('aria-expanded', 'false'); // Change 'true' to 'false' initially
			}

			if (menu.target && menu.target.trim() !== '') {
				a.setAttribute('target', '_blank');
			}

			var icon = document.createElement('i');
			icon.className = menu.icon ? menu.icon : '';

			var nameDiv = document.createElement('div');
			nameDiv.textContent = menu.name ? menu.name : '';

			if (menu.badge) {
				var badgeDiv = document.createElement('div');
				badgeDiv.className = 'badge bg-' + menu.badge[0] + ' rounded-pill ms-auto';
				badgeDiv.textContent = menu.badge[1];
				a.appendChild(badgeDiv);
			}

			var chevronIcon = document.createElement('i');
			chevronIcon.className = 'bi bi-chevron-down ms-auto';

			a.appendChild(icon);
			a.appendChild(nameDiv);
			li.appendChild(a);
			if (menu.submenu) {
				a.appendChild(chevronIcon);

				var submenuContainerDiv = document.createElement('ul');
				submenuContainerDiv.id = submenuTargetId;
				submenuContainerDiv.className = 'nav-content collapse'; // Adjusted class here

				menu.submenu.forEach(function(submenu) {
					submenuContainerDiv.appendChild(createMenu(submenu));
				});
				li.appendChild(submenuContainerDiv);
			}
			return li;

		}

		menuData.forEach(function(menu) {
			if (!menu.allowed_roles || !menu.allowed_roles.includes(userRole)) {
				return 'null';
			}
			console.log(userRole)
			sidebarNav.appendChild(createMenu(menu));
		});
		
		// Membuat elemen li baru
		const li = document.createElement("li");
		li.innerHTML = `<li class="menu-item nav-item"><a href="<?= url('/profiling') ?>" class="nav-link collapsed "><i class="bx bx-link-external" style="transform: scaleX(-1);"></i><div>Profiling</div></a></li>`;

		// Menambahkan li ke dalam ul dengan id 'sidebar-nav'
		document.getElementById("sidebar-nav").appendChild(li);
	}
</script>
