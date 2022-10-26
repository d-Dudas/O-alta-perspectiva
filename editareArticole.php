<?php
    include 'header.php';
    if(isset($_SESSION["useruid"])) {
        if($_SESSION["ifadmin"] != 1) {
            header("location: index.php");
        }
    }
    else {
        header("location: index.php");
    }

    $id = $_GET["id"];

    $json = file_get_contents('./articles.json');
    $data = json_decode($json, true);


echo "

<script src='./tinymce\js\\tinymce/tinymce.min.js'></script>

<script>
    tinymce.init({
    selector: '#text',
    plugins: 'print preview paste importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars emoticons',
    imagetools_cors_hosts: ['picsum.photos'],
    menubar: 'file edit view insert format tools table help',
    toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | ltr rtl',
    toolbar_sticky: true,
    autosave_ask_before_unload: true,
    autosave_interval: \"30s\",
    autosave_prefix: \"{path}{query}-{id}-\",
    autosave_restore_when_empty: false,
    autosave_retention: \"2m\",
    image_advtab: true,
    /*content_css: '//www.tiny.cloud/css/codepen.min.css',*/
    link_list: [
        { title: 'My page 1', value: 'https://www.codexworld.com' },
        { title: 'My page 2', value: 'https://www.xwebtools.com' }
    ],
    image_list: [
        { title: 'My page 1', value: 'https://www.codexworld.com' },
        { title: 'My page 2', value: 'https://www.xwebtools.com' }
    ],
    image_class_list: [
        { title: 'None', value: '' },
        { title: 'Some class', value: 'class-name' }
    ],
    importcss_append: true,
    file_picker_callback: function (callback, value, meta) {
        /* Provide file and text for the link dialog */
        if (meta.filetype === 'file') {
            callback('https://www.google.com/logos/google.jpg', { text: 'My text' });
        }
    
        /* Provide image and alt text for the image dialog */
        if (meta.filetype === 'image') {
            callback('https://www.google.com/logos/google.jpg', { alt: 'My alt text' });
        }
    
        /* Provide alternative source and posted for the media dialog */
        if (meta.filetype === 'media') {
            callback('movie.mp4', { source2: 'alt.ogg', poster: 'https://www.google.com/logos/google.jpg' });
        }
    },
    templates: [
        { title: 'New Table', description: 'creates a new table', content: '<div class=\"mceTmpl\"><table width=\"98%%\"  border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr><th scope=\"col\"> </th><th scope=\"col\"> </th></tr><tr><td> </td><td> </td></tr></table></div>' },
        { title: 'Starting my story', description: 'A cure for writers block', content: 'Once upon a time...' },
        { title: 'New list with dates', description: 'New List with dates', content: '<div class=\"mceTmpl\"><span class=\"cdate\">cdate</span><br /><span class=\"mdate\">mdate</span><h2>My List</h2><ul><li></li><li></li></ul></div>' }
    ],
    template_cdate_format: '[Date Created (CDATE): %m/%d/%Y : %H:%M:%S]',
    template_mdate_format: '[Date Modified (MDATE): %m/%d/%Y : %H:%M:%S]',
    height: 600,
    image_caption: true,
    quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
    noneditable_noneditable_class: \"mceNonEditable\",
    toolbar_mode: 'sliding',
    contextmenu: \"link image imagetools table\",
    setup: function (editor) {
        editor.on('init', function (e) {
          editor.setContent(`".$data['articles'][$id]['text']."`);
        });
      }
});
</script>
<?php 

";

echo '
    <form id="articol_nou" method="POST" action="includes/editare_articol.inc.php">
    <form id="articol_nou" method="POST" action="includes/editare_articol.inc.php?id='.$id.'">
        <label for="titlu"> Titlu:
            <br><br><input type="text" name="titlu" id = "titlu" value = "'.$data['articles'][$id]['title'].'">
        </label><br><br>
        <label for="image"> Imagine:
            <br><br><input type="file" name="image" id="image" value = "'.$data['articles'][$id]['image'].'">
        </label><br><br>
        <label for="text"> Articol:
            <br><br><textarea name="text" id="text" value = "'.$data['articles'][$id]['text'].'"></textarea>
        </label><br><br>
        <input type="submit" value="Editare articol '.$id.'" id="buton_submit">
    </form>
';

    include 'footer.php';
?>