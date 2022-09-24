var modal = document.getElementById("modal-dialog");
document.getElementById("btn-modal-close").addEventListener('click', () => {
	modal.close()
})

function showAuth(wrongPassword = 0) {
	modal.showModal()
	document.getElementById('modal-title').innerHTML = "Авторизация";

	var wrong = wrongPassword ? '<span id="modal-error">Неверный пароль</span>' : '';
	document.getElementById('modal-content').innerHTML = 
		'<form action="/engine/login.php" id="dialog-auth" method="POST"> ' + 
			'<input type="password" name="password" placeholder="Пароль" required> ' +
			'<button type="submit">Войти</button> ' + wrong +
		'</form>';
}

function showYesNoDialog(title, question, url) {
	modal.showModal();
	document.getElementById('modal-title').innerHTML = title;
	document.getElementById('modal-content').innerHTML = `<p>${question}</p><div class="btns-confirmation"><a class="btn" href="${url}">Да</a><a class="btn" onclick="document.getElementById('btn-modal-close').click()">Нет</a></div>`;
}

function showError(errorCode) {
	modal.showModal()
	var message = ""
	switch (errorCode) {
		case 1: message = "Не удалось подключиться к серверу, проверьте правильность введенных данных."; break;
		case 2: message = "Не удалось создать базу данных."; break;
		case 3: message = "Не удалось очистить ранее созданные таблицы."; break;
		case 4: message = "Не удалось создать таблицы."; break;
		case 5: message = "Не удалось добавить начальные значения в таблицы."; break;
		case 6: message = "Не удалось изменить файл логотипа."; break;
		case 7: message = "Не удалось обновить параметры."; break;
		case 8: message = "Не удалось изменить статью."; break;
		case 9: message = "Не удалось создать статью."; break;
		case 10: message = "Не удалось удалить статью."; break;
		case 11: message = "Не удалось добавить комментарий."; break;
		case 12: message = "Не удалось загрузить файлы."; break;
		default: message = "Неизвестная ошибка."; break;
	}

	document.getElementById('modal-title').innerHTML = "Ошибка " + errorCode;
	document.getElementById('modal-content').innerHTML = message;
}