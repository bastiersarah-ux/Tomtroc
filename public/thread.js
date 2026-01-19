function addTimestamp(dateCreate) {
	// 	<span class="send-info">
	// 	18.01 18:43
	// </span>
	const span = document.createElement("span");
	span.innerText = dateCreate;
	span.classList.add("send-info");
	return span;
}

function addErrorMessage() {
	//<span class="text-error">
	// Message non envoyé.
	// <button class="link btn-resend">Reessayer</button>
	// </span>
	const div = document.createElement("div");
	div.classList.add("send-error");
	div.innerText = "Message non envoyé";
	const button = document.createElement("button");
	button.classList.add("link", "btn-resend");
	button.innerText = "Réessayer";

	div.appendChild(button);

	return { el: div, button };
}

function createMessageEl(input) {
	// Crée les éléments DOM explicitement et utilise textContent
	// pour éviter toute injection HTML / XSS.
	const container = document.createElement("div");
	container.className = "message owner";

	const info = document.createElement("div");
	info.className = "message-info";
	const loading = document.createElement("span");
	loading.innerHTML = `envoi en cours 
		<span class="loading loading-dots loading-xs ml-1">
		</span>`;
	info.appendChild(loading);

	const card = document.createElement("div");
	card.className = "card";
	const cardContent = document.createElement("div");
	cardContent.className = "card-content";
	// Affecter le texte via textContent empêche l'interprétation HTML
	cardContent.textContent = input;

	card.appendChild(cardContent);
	container.appendChild(info);
	container.appendChild(card);

	return {
		messageEl: container,
		message: cardContent.innerText,
		loadingEl: loading,
		infoEl: info,
	};
}

(function () {
	const list = document.querySelector(".messages-list");
	const input = document.querySelector("#message-input");
	const btn = document.querySelector("button#submit-message");

	const params = new URLSearchParams(window.location.search);
	const idThread = Number(params.get("id"));

	async function sendMessage(input) {
		const { messageEl, message, loadingEl, infoEl } =
			createMessageEl(input);
		list.prepend(messageEl);

		const response = await fetch("?action=sendmessage", {
			method: "POST",
			headers: { "Content-Type": "application/x-www-form-urlencoded" },
			body: new URLSearchParams({ idThread, message }).toString(),
		});

		try {
			if (!response.ok) {
				if (response.status == 401) {
					window.location.replace("?action=connectuser");
					return;
				}
				throw "";
			}
			const timestamp = await response.json();
			infoEl.appendChild(addTimestamp(timestamp));
		} catch {
			const { el, button } = addErrorMessage();
			button.addEventListener("click", function () {
				messageEl.remove();
				sendMessage(message);
			});
			infoEl.appendChild(el);
		} finally {
			loadingEl.remove();
		}
	}

	// On scroll la liste vers la fin pour voir les derniers messages
	list.scrollTo({ top: list.scrollHeight, behavior: "smooth" });

	// Si l'utilisateur appuie sur Entrée (sans Shift), on déclenche l'envoi
	if (input && btn) {
		input.addEventListener("keydown", function (e) {
			if (e.key === "Enter" && !e.shiftKey) {
				e.preventDefault();

				if (input.value?.trim() == "") {
					return;
				}

				btn.click();
			}
		});

		btn.addEventListener("click", function (e) {
			const message = input.value;
			input.value = "";
			sendMessage(message);
		});
	}
})();
