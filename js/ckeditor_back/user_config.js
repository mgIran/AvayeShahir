CKEDITOR.editorConfig = function( config ) {
    config.toolbarGroups = [
        { name: 'document', groups: [ 'document', 'doctools', 'mode' ] },
        { name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
        { name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
        { name: 'forms', groups: [ 'forms' ] },
        { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
        { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
        { name: 'colors', groups: [ 'colors' ] },
        { name: 'styles', groups: [ 'styles' ] },
        { name: 'links', groups: [ 'links' ] },
        { name: 'insert', groups: [ 'insert' ] },
        '/',
        { name: 'tools', groups: [ 'tools' ] },
        { name: 'others', groups: [ 'others' ] },
        { name: 'about', groups: [ 'about' ] }
    ];

    config.removeButtons = 'Source,Save,Templates,Undo,Cut,Redo,Copy,Paste,PasteText,PasteFromWord,NewPage,Preview,Print,Find,Replace,SelectAll,Scayt,Form,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Strike,NumberedList,BulletedList,CreateDiv,Language,Image,Flash,Table,HorizontalRule,SpecialChar,PageBreak,Iframe,Smiley,Styles,Format,Font,Maximize,ShowBlocks,About,Checkbox';
};