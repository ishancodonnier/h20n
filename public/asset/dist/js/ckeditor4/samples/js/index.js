if (CKEDITOR.env.ie && CKEDITOR.env.version < 9)
    CKEDITOR.tools.enableHtml5Elements(document);
CKEDITOR.config.height = 150;
CKEDITOR.config.width = "auto";


// CKEDITOR.config.font_names = 'Arial/Arial, Helvetica, sans-serif;' +
// 	'Comic Sans MS/Comic Sans MS, cursive;' +
// 	'Courier New/Courier New, Courier, monospace;' +
// 	'Georgia/Georgia, serif;' +
// 	'Lucida Sans Unicode/Lucida Sans Unicode, Lucida Grande, sans-serif;' +
// 	'Tahoma/Tahoma, Geneva, sans-serif;' +
// 	'Times New Roman/Times New Roman, Times, serif;' +
// 	'Trebuchet MS/Trebuchet MS, Helvetica, sans-serif;' +
//     'Source Sans Pro/Source Sans Pro, sans-serif;' +
// 	'Verdana/Verdana, Geneva, sans-serif';

var initSample = (function () {
    var wysiwygareaAvailable = isWysiwygareaAvailable(),
        isBBCodeBuiltIn = !!CKEDITOR.plugins.get("bbcode");

    return function () {
        var editorElement = CKEDITOR.document.getById("description");

        if (isBBCodeBuiltIn) {
            editorElement.setHtml();
        }

        if (wysiwygareaAvailable) {
            CKEDITOR.replace("description");
        } else {
            editorElement.setAttribute("contenteditable", "true");
            CKEDITOR.inline("description");
        }
    };

    function isWysiwygareaAvailable() {
        if (CKEDITOR.revision == "%RE" + "V%") {
            return true;
        }

        return !!CKEDITOR.plugins.get("wysiwygarea");
    }
})();
