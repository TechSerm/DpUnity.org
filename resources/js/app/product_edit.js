let Edit = {
    contestDescriptionEditor: "",
    setEditor: function(description) {
        this.contestDescriptionEditor = CKEDITOR.replace('contestDescriptionEditor');
        CKEDITOR.config.height = 100;
        CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
        CKEDITOR.config.extraPlugins = 'autogrow,justify,image2,div';
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
            items: ['CreateDiv', 'Link', 'Image', 'CoderojFileManager', 'Table', 'Mathjax']
        }, {
            name: "paragraph",
            items: ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock']
        }, {
            name: 'tools',
            items: ['CoderojPreview', 'Maximize']
        }];
        this.contestDescriptionEditor.config.toolbar = toolbarConstraintsEditor;
        CKEDITOR.instances.contestDescriptionEditor.setData(atob(description));
    },

    getEditorData: function() {
        return CKEDITOR.instances.contestDescriptionEditor.getData()
    },

};

module.exports = {
    Edit
};