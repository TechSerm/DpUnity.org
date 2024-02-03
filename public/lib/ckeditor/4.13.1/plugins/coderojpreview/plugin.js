CKEDITOR.plugins.add('coderojpreview', {
    icons: 'coderojpreview',
    init: function(editor) {
        editor.addCommand('previewEditor', {
            exec: function(editor) {
                var now = new Date();
                var modal = Helper.modal(750,"Preview");
                modal.open();
                modal.html(editor.getData());
                if (typeof MathJax !== 'undefined') {
                    MathJax.Hub.Queue(["Typeset", MathJax.Hub]);
                }
            }
        });
        editor.ui.addButton('CoderojPreview', {
            label: 'Preview Editor',
            command: 'previewEditor',
            toolbar: 'insert'
        });
    }
});