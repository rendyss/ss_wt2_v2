jQuery(function () {
    var file_frame;
    jQuery('.imgselect').on('click', function (e) {
        e.preventDefault();
        var origin = jQuery(this),
            originparent = origin.closest('.pimg'),
            divprev = originparent.find('.imgprev'),
            imgprev = divprev.find('img'),
            imgid = originparent.find("input[name=ssteammember_image_id]");

        if (file_frame) file_frame.close();

        file_frame = wp.media.frames.file_frame = wp.media({
            // title: jQuery(this).data('uploader-title'),
            button: {
                // text: jQuery(this).data('uploader-button-text'),
            },
            library: {
                type: 'image'
            },
            multiple: false
        });

        file_frame.on('select', function () {
            var selection = file_frame.state().get('selection');
            var resjson = selection.toJSON();
            // console.log(resjson[0]);
            divprev.removeClass("hidden");
            imgprev.attr("src", resjson[0].sizes.thumbnail.url);
            imgid.val(resjson[0].id);

            origin.html("Change Image")
        });

        file_frame.open();
    });

    jQuery(".rimage").on("click", function (e) {
        e.preventDefault();
        var prevparent = jQuery(this).parents(".imgprev"),
            superparet = prevparent.parents(".pimg"),
            btnadd = superparet.find(".imgselect"),
            imgp = prevparent.find("img"),
            imgid = prevparent.find("input[name=ssteammember_image_id]");

        imgp.attr("src", "");
        imgid.val("");
        prevparent.addClass("hidden");
        btnadd.html("Select Image");
    });
});