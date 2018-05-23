var ctf; 

function insert_ubb(into, textpre, textpost) {
	if(!into) {
		return false;
	}
    //into = document.getElementById(into);
    // IE support
    //   note that cursor is placed AFTER modified sel.text (bad)
    //    AND disappears if range selected (bad) AND selection 
    //    remains active (very bad)
    if (document.selection) {
        into.focus();
        var sel = document.selection.createRange();
        sel.text = textpre + sel.text + textpost;
    } else if (into.selectionStart || into.selectionStart == '0') {
        var startPos = into.selectionStart;
        var endPos = into.selectionEnd;
        // glue together portion before cursor/selection +
        // textpre + any selected area + textpost + portion 
        // after cursor/selection
        into.value = into.value.substring(0, startPos) + 
            textpre +
            into.value.substring(into.selectionStart, into.selectionEnd) + 
            textpost + 
        into.value.substring(endPos, into.value.length);
        // after insertion, cursor = start/end selection area
        // after inserted textpre
        into.selectionStart = into.selectionEnd = startPos + textpre.length;
    } else {
        var endPos = into.value.length;
        into.value += textpre+textpost;
        into.selectionStart = into.selectionEnd = endPos + textpre.length + textpost.length;
    }
    into.focus();
}

document.addEventListener('DOMContentLoaded', function() {
	$('.switch').change(function() {
		if(!this.checked) {
			if(!window.confirm("Are you sure you want to unpublish this article?")) {
				this.checked = true;
				
				return false;
			}
		}
		$.ajax({
			type: "POST",
			url: '',
			data: 'publish=&id=' + this.id.replace('switch', '') + '&state=' + this.checked
		});
	});
}, false);