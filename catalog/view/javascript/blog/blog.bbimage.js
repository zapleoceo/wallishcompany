$(window).on("load", function(e) {
		var $img = $('.bbimage');

		// ���������� �������� ��� ����
		$img.each(function() {
		    var src = $(this).attr('src');
		    $(this).attr('src', '');
		    $(this).attr('src', src);
		});

		// ���� �������� �������� ���������
		$img.on("load", function() {
		//$img.load(function(){
		    // ������� �������� width � height

		   var attrwidth_parent = $(this).closest('div').width();

           if (typeof ($(this).attr("width")) == "undefined") {
     		   	attrwidth = attrwidth_parent;
		    } else {
        		attrwidth = $(this).attr("width");
        		if (attrwidth > attrwidth_parent) {        			attrwidth = attrwidth_parent;
        		}
		    }

		    $(this).removeAttr("width").removeAttr("height").css({ width: "", height: "" });

		    // �������� �������� �����
		    var width  = $(this).width();
		    var height = $(this).height();

		 if ((width > attrwidth) || (width > attrwidth_parent)) {
			$(this).attr('width', attrwidth+'px');
		 } else {
		    $(this).attr('width', width+'px');
		}
		});
});