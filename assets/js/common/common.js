$(function(){
	/* page to top */
	$(document).load(function(){
		$("body,html,document").scrollTop(0);
	});

	/* bootstrap */
	$('[data-toggle="tooltip"]').tooltip();
	$('[data-toggle="popover"]').popover();
	$('[data-toggle="dropdown"]').dropdown();

	/* bootstrap choosen */
	$('.select-choosen').chosen({
		theme : "bootstrap",
		width : "100%",
		placeholder : "Choose",
	});

	/* wow.js */
	// wow = new WOW({
	//     offset: 50,
	// })
	// wow.init();

	/* WYSIWYG */
	function initToolbarBootstrapBindings() {
		var fonts = ['Serif', 'Sans', 'Arial', 'Arial Black', 'Courier', 'Courier New', 'Comic Sans MS', 'Helvetica', 'Impact', 'Lucida Grande', 'Lucida Sans', 'Tahoma', 'Times', 'Times New Roman', 'Verdana'],
		fontTarget = $('[title=Font]').siblings('.dropdown-menu');
		$.each(fonts, function(idx, fontName) {
			fontTarget.append($('<li><a data-edit="fontName ' + fontName + '" style="font-family:\'' + fontName + '\'">' + fontName + '</a></li>'));
		});
		$('a[title]').tooltip({
			container: 'body'
		});
		$('.dropdown-menu input').click(function() {
			return false;
		}).change(function() {
			$(this).parent('.dropdown-menu').siblings('.dropdown-toggle').dropdown('toggle');
		})
		.keydown('esc', function() {
			this.value = '';
			$(this).change();
		});

		$('[data-role=magic-overlay]').each(function() {
			var overlay = $(this),
			target = $(overlay.data('target'));
			overlay.css('opacity', 0).css('position', 'absolute').offset(target.offset()).width(target.outerWidth()).height(target.outerHeight());
		});
	};

	function showErrorAlert(reason, detail) {
		var msg = '';
		if (reason === 'unsupported-file-type') {
			msg = "Unsupported format " + detail;
		} else {
			console.log("error uploading file", reason, detail);
		}
		$('<div class="alert"> <button type="button" class="close" data-dismiss="alert">&times;</button>' + '<strong>File upload error</strong> ' + msg + ' </div>').prependTo('#alerts');
	};

	initToolbarBootstrapBindings();
	$('.editor').wysiwyg();
	window.prettyPrint && prettyPrint();
	/* END WYSIWYG */

	/* datetimepicker */
	$('.datetimepicker').datetimepicker();

	/* EMOJI */
	window.emojiPicker = new EmojiPicker({
		emojiable_selector: '[data-emojiable=true]',
		assetsPath: './assets/plugin/emoji-picker/lib/img',
		popupButtonClasses: 'fa fa-smile-o'
	});
	window.emojiPicker.discover();
});