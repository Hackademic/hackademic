function goToPage(page) {
	urlInfo = document.location.href.split('/challenge-router/');
	document.location.href = urlInfo[0] + '/challenge-router/' + page;
}