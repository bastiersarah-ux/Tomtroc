(function () {
	async function getUnreadMessage() {
		try {
			const response = await fetch("?action=unread", {
				method: "GET",
			});

			if (!response.ok) {
				return null;
			}
			return await response.json();
		} catch (e) {
			console.log(e);
			return null;
		}
	}

	getUnreadMessage().then((count) => {
		if (!count) {
			return;
		}

		let menuItems = Array.from(
			document.querySelectorAll(".thread-menu a") ?? [],
		);

		for (let menu of menuItems) {
			const badge = document.createElement("div");
			badge.classList.add("badge", "badge-xs", "badge-message");
			badge.innerText = count < 100 ? count : "+99";
			menu.appendChild(badge);
		}
	});
})();
