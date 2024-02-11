let Edit = {
    descriptionEditor: "",
    setEditor: function(description, fileUploadUrl) {
        console.log(fileUploadUrl, description);
        this.descriptionEditor = CKEDITOR.replace('descriptionEditor', {
            filebrowserUploadUrl: fileUploadUrl,
            filebrowserUploadMethod: 'form',
            allowedContent : true,
        });
        CKEDITOR.config.height = 100;
        CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
        CKEDITOR.config.extraPlugins = 'autogrow,justify,image2,filebrowser,div';
        CKEDITOR.config.codeSnippet_theme = 'pojoaque';
        CKEDITOR.config.fontSize_defaultLabel = '12px';
        CKEDITOR.config.disableObjectResizing = false;
        CKEDITOR.config.autoGrow_minHeight = 100;
        CKEDITOR.config.autoGrow_maxHeight = 300;

        CKEDITOR.config.tabSpaces = 4;

        var toolbarConstraintsEditor = [{
            name: "paragraph",
            items: ['Bold', 'Italic', 'Strike']
        }, {
            name: "paragraph",
            items: ["NumberedList", "BulletedList"]
        }, {
            name: 'basicstyles',
            groups: ['basicstyles', 'cleanup'],
            items: ['CreateDiv', 'Link', 'Image', 'content', 'Table', 'Mathjax']
        }, {
            name: "paragraph",
            items: ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock']
        }, {
            name: 'tools',
            items: ['CoderojPreview', 'Maximize']
        }];
        this.descriptionEditor.config.toolbar = toolbarConstraintsEditor;
        CKEDITOR.instances.descriptionEditor.setData(atob(description));
    },

    getEditorData: function() {
        return CKEDITOR.instances.descriptionEditor.getData()
    },

};

module.exports = {
    Edit
};