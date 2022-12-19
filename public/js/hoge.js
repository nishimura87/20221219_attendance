// 完了後ポップアップ表示
const is_after_complete = "{{ Session::get('status') }}";
if (is_after_complete) {
	// sessionStorageはブラウザバックで完了ポップアップが出てしまうのを防ぐために利用している
	if (sessionStorage.getItem('status') != "1") {
		alert(is_after_complete);
		sessionStorage.setItem('status', "1");
	}
}

// ブラウザバックで完了ポップアップが出てしまうのを防ぐための処理
$('form').submit(function() {
	sessionStorage.setItem('status', "0");
})