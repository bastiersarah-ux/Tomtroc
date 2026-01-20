(function () {
	const input = document.querySelector("#image-input-field");
	const btn = document.querySelector("#btn-image-input");
	const img = document.querySelector("#image-preview");

	btn.addEventListener("click", function (e) {
		e.preventDefault();
		input?.click();
	});

	input.addEventListener("change", function (e) {
		const file = input.files[0];
		if (!file) return;

		const reader = new FileReader();

		reader.onload = (e) => {
			img.src = e.target.result;
		};

		reader.readAsDataURL(file);
	});
})();
