﻿/*
 Copyright (c) 2003-2020, CKSource - Frederico Knabben. All rights reserved.
 For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
*/
(function() {
    function h(a) {
        var e = CKEDITOR.plugins.getPath("preview"),
            d = a.config,
            g = a.lang.preview.preview,
            f = function() {
                var a = location.origin,
                    b = location.pathname;
                if (!d.baseHref && !CKEDITOR.env.gecko) return "";
                if (d.baseHref) return '\x3cbase href\x3d"{HREF}"\x3e'.replace("{HREF}", d.baseHref);
                b = b.split("/");
                b.pop();
                b = b.join("/");
                return '\x3cbase href\x3d"{HREF}"\x3e'.replace("{HREF}", a + b + "/")
            }();
        return d.fullPage ? a.getData().replace(/<head>/, "$\x26" + f).replace(/[^>]*(?=<\/title>)/, "$\x26 \x26mdash; " + g) : d.docType + '\x3chtml dir\x3d"' + d.contentsLangDirection + '"\x3e\x3chead\x3e' + f + "\x3ctitle\x3e" + g + "\x3c/title\x3e" + CKEDITOR.tools.buildStyleHtml(d.contentsCss) + '\x3clink rel\x3d"stylesheet" media\x3d"screen" href\x3d"' + e + 'styles/screen.css"\x3e\x3c/head\x3e' + function() {
            var c = "\x3cbody\x3e",
                b = a.document && a.document.getBody();
            if (!b) return c;
            b.getAttribute("id") && (c = c.replace("\x3e", ' id\x3d"' + b.getAttribute("id") + '"\x3e'));
            b.getAttribute("class") && (c = c.replace("\x3e", ' class\x3d"' + b.getAttribute("class") + '"\x3e'));
            return c
        }() + a.getData() + "\x3c/body\x3e\x3c/html\x3e"
    }
    CKEDITOR.plugins.add("preview", {
        lang: "af,ar,az,bg,bn,bs,ca,cs,cy,da,de,de-ch,el,en,en-au,en-ca,en-gb,eo,es,es-mx,et,eu,fa,fi,fo,fr,fr-ca,gl,gu,he,hi,hr,hu,id,is,it,ja,ka,km,ko,ku,lt,lv,mk,mn,ms,nb,nl,no,oc,pl,pt,pt-br,ro,ru,si,sk,sl,sq,sr,sr-latn,sv,th,tr,tt,ug,uk,vi,zh,zh-cn",
        icons: "preview,preview-rtl",
        hidpi: !0,
        init: function(a) {
            a.addCommand("preview", {
                modes: {
                    wysiwyg: 1
                },
                canUndo: !1,
                readOnly: 1,
                exec: CKEDITOR.plugins.preview.createPreview
            });
            a.ui.addButton && a.ui.addButton("Preview", {
                label: a.lang.preview.preview,
                command: "preview",
                toolbar: "document,40"
            })
        }
    });
    CKEDITOR.plugins.preview = {
        createPreview: function(a) {
            var e, d, g, f = {
                    dataValue: h(a)
                },
                c = window.screen;
            e = Math.round(.8 * c.width);
            d = Math.round(.7 * c.height);
            g = Math.round(.1 * c.width);
            c = CKEDITOR.env.ie ? "javascript:void( (function(){document.open();" + ("(" + CKEDITOR.tools.fixDomain + ")();").replace(/\/\/.*?\n/g, "").replace(/parent\./g, "window.opener.") + "document.write( window.opener._cke_htmlToLoad );document.close();window.opener._cke_htmlToLoad \x3d null;})() )" : null;
            var b;
            b = CKEDITOR.plugins.getPath("preview");
            b = CKEDITOR.env.gecko ? CKEDITOR.getUrl(b + "preview.html") : "";
            if (!1 === a.fire("contentPreview", f)) return !1;
            if (c || b) window._cke_htmlToLoad = f.dataValue;
            a = window.open(b, null, ["toolbar\x3dyes,location\x3dno,status\x3dyes,menubar\x3dyes,scrollbars\x3dyes,resizable\x3dyes", "width\x3d" + e, "height\x3d" + d, "left\x3d" + g].join());
            c && a && (a.location = c);
            window._cke_htmlToLoad || (e = a.document, e.open(), e.write(f.dataValue), e.close());
            return new CKEDITOR.dom.window(a)
        }
    }
})();