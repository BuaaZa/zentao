(function (e, t) {
    var n, r, i = typeof t, o = e.document, a = e.location, s = e.jQuery, u = e.$, l = {}, c = [], p = "3.5.1",
        f = c.concat, d = c.push, h = c.slice, g = c.indexOf, m = l.toString, y = l.hasOwnProperty, v = p.trim,
        b = function (e, t) {
            return new b.fn.init(e, t, r)
        }, x = /[+-]?(?:\d*\.|)\d+(?:[eE][+-]?\d+|)/.source, w = /\S+/g, T = /^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g,
        N = /^(?:(<[\w\W]+>)[^>]*|#([\w-]*))$/, C = /^<(\w+)\s*\/?>(?:<\/\1>|)$/, k = /^[\],:{}\s]*$/,
        E = /(?:^|:|,)(?:\s*\[)+/g, S = /\\(?:["\\\/bfnrt]|u[\da-fA-F]{4})/g,
        A = /"[^"\\\r\n]*"|true|false|null|-?(?:\d+\.|)\d+(?:[eE][+-]?\d+|)/g, j = /^-ms-/, D = /-([\da-z])/gi,
        L = function (e, t) {
            return t.toUpperCase()
        }, H = function (e) {
            (o.addEventListener || "load" === e.type || "complete" === o.readyState) && (q(), b.ready())
        }, q = function () {
            o.addEventListener ? (o.removeEventListener("DOMContentLoaded", H, !1), e.removeEventListener("load", H, !1)) : (o.detachEvent("onreadystatechange", H), e.detachEvent("onload", H))
        };
    b.fn = b.prototype = {
        jquery: p, constructor: b, init: function (e, n, r) {
            var i, a;
            if (!e) return this;
            if ("string" == typeof e) {
                if (i = "<" === e.charAt(0) && ">" === e.charAt(e.length - 1) && e.length >= 3 ? [null, e, null] : N.exec(e), !i || !i[1] && n) return !n || n.jquery ? (n || r).find(e) : this.constructor(n).find(e);
                if (i[1]) {
                    if (n = n instanceof b ? n[0] : n, b.merge(this, b.parseHTML(i[1], n && n.nodeType ? n.ownerDocument || n : o, !0)), C.test(i[1]) && b.isPlainObject(n)) for (i in n) b.isFunction(this[i]) ? this[i](n[i]) : this.attr(i, n[i]);
                    return this
                }
                if (a = o.getElementById(i[2]), a && a.parentNode) {
                    if (a.id !== i[2]) return r.find(e);
                    this.length = 1, this[0] = a
                }
                return this.context = o, this.selector = e, this
            }
            return e.nodeType ? (this.context = this[0] = e, this.length = 1, this) : b.isFunction(e) ? r.ready(e) : (e.selector !== t && (this.selector = e.selector, this.context = e.context), b.makeArray(e, this))
        }, selector: "", length: 0, size: function () {
            return this.length
        }, toArray: function () {
            return h.call(this)
        }, get: function (e) {
            return null == e ? this.toArray() : 0 > e ? this[this.length + e] : this[e]
        }, pushStack: function (e) {
            var t = b.merge(this.constructor(), e);
            return t.prevObject = this, t.context = this.context, t
        }, each: function (e, t) {
            return b.each(this, e, t)
        }, ready: function (e) {
            return b.ready.promise().done(e), this
        }, slice: function () {
            return this.pushStack(h.apply(this, arguments))
        }, first: function () {
            return this.eq(0)
        }, last: function () {
            return this.eq(-1)
        }, eq: function (e) {
            var t = this.length, n = +e + (0 > e ? t : 0);
            return this.pushStack(n >= 0 && t > n ? [this[n]] : [])
        }, map: function (e) {
            return this.pushStack(b.map(this, function (t, n) {
                return e.call(t, n, t)
            }))
        }, end: function () {
            return this.prevObject || this.constructor(null)
        }, push: d, sort: [].sort, splice: [].splice
    }, b.fn.init.prototype = b.fn, b.extend = b.fn.extend = function () {
        var e, n, r, i, o, a, s = arguments[0] || {}, u = 1, l = arguments.length, c = !1;
        for ("boolean" == typeof s && (c = s, s = arguments[1] || {}, u = 2), "object" == typeof s || b.isFunction(s) || (s = {}), l === u && (s = this, --u); l > u; u++) if (null != (o = arguments[u])) for (i in o) e = s[i], r = o[i], s !== r && (c && r && (b.isPlainObject(r) || (n = b.isArray(r))) ? (n ? (n = !1, a = e && b.isArray(e) ? e : []) : a = e && b.isPlainObject(e) ? e : {}, s[i] = b.extend(c, a, r)) : r !== t && (s[i] = r));
        return s
    }, b.extend({
        noConflict: function (t) {
            return e.$ === b && (e.$ = u), t && e.jQuery === b && (e.jQuery = s), b
        }, isReady: !1, readyWait: 1, holdReady: function (e) {
            e ? b.readyWait++ : b.ready(!0)
        }, ready: function (e) {
            if (e === !0 ? !--b.readyWait : !b.isReady) {
                if (!o.body) return setTimeout(b.ready);
                b.isReady = !0, e !== !0 && --b.readyWait > 0 || (n.resolveWith(o, [b]), b.fn.trigger && b(o).trigger("ready").off("ready"))
            }
        }, isFunction: function (e) {
            return "function" === b.type(e)
        }, isArray: Array.isArray || function (e) {
            return "array" === b.type(e)
        }, isWindow: function (e) {
            return null != e && e == e.window
        }, isNumeric: function (e) {
            return !isNaN(parseFloat(e)) && isFinite(e)
        }, type: function (e) {
            return null == e ? e + "" : "object" == typeof e || "function" == typeof e ? l[m.call(e)] || "object" : typeof e
        }, isPlainObject: function (e) {
            if (!e || "object" !== b.type(e) || e.nodeType || b.isWindow(e)) return !1;
            try {
                if (e.constructor && !y.call(e, "constructor") && !y.call(e.constructor.prototype, "isPrototypeOf")) return !1
            } catch (n) {
                return !1
            }
            var r;
            for (r in e) ;
            return r === t || y.call(e, r)
        }, isEmptyObject: function (e) {
            var t;
            for (t in e) return !1;
            return !0
        }, error: function (e) {
            throw Error(e)
        }, parseHTML: function (e, t, n) {
            if (!e || "string" != typeof e) return null;
            "boolean" == typeof t && (n = t, t = !1), t = t || o;
            var r = C.exec(e), i = !n && [];
            return r ? [t.createElement(r[1])] : (r = b.buildFragment([e], t, i), i && b(i).remove(), b.merge([], r.childNodes))
        }, parseJSON: function (n) {
            return e.JSON && e.JSON.parse ? e.JSON.parse(n) : null === n ? n : "string" == typeof n && (n = b.trim(n), n && k.test(n.replace(S, "@").replace(A, "]").replace(E, ""))) ? Function("return " + n)() : (b.error("Invalid JSON: " + n), t)
        }, parseXML: function (n) {
            var r, i;
            if (!n || "string" != typeof n) return null;
            try {
                e.DOMParser ? (i = new DOMParser, r = i.parseFromString(n, "text/xml")) : (r = new ActiveXObject("Microsoft.XMLDOM"), r.async = "false", r.loadXML(n))
            } catch (o) {
                r = t
            }
            return r && r.documentElement && !r.getElementsByTagName("parsererror").length || b.error("Invalid XML: " + n), r
        }, noop: function () {
        }, globalEval: function (t) {
            t && b.trim(t) && (e.execScript || function (t) {
                e.eval.call(e, t)
            })(t)
        }, camelCase: function (e) {
            return e.replace(j, "ms-").replace(D, L)
        }, nodeName: function (e, t) {
            return e.nodeName && e.nodeName.toLowerCase() === t.toLowerCase()
        }, each: function (e, t, n) {
            var r, i = 0, o = e.length, a = M(e);
            if (n) {
                if (a) {
                    for (; o > i; i++) if (r = t.apply(e[i], n), r === !1) break
                } else for (i in e) if (r = t.apply(e[i], n), r === !1) break
            } else if (a) {
                for (; o > i; i++) if (r = t.call(e[i], i, e[i]), r === !1) break
            } else for (i in e) if (r = t.call(e[i], i, e[i]), r === !1) break;
            return e
        }, trim: v && !v.call("\ufeff\u00a0") ? function (e) {
            return null == e ? "" : v.call(e)
        } : function (e) {
            return null == e ? "" : (e + "").replace(T, "")
        }, makeArray: function (e, t) {
            var n = t || [];
            return null != e && (M(Object(e)) ? b.merge(n, "string" == typeof e ? [e] : e) : d.call(n, e)), n
        }, inArray: function (e, t, n) {
            var r;
            if (t) {
                if (g) return g.call(t, e, n);
                for (r = t.length, n = n ? 0 > n ? Math.max(0, r + n) : n : 0; r > n; n++) if (n in t && t[n] === e) return n
            }
            return -1
        }, merge: function (e, n) {
            var r = n.length, i = e.length, o = 0;
            if ("number" == typeof r) for (; r > o; o++) e[i++] = n[o]; else while (n[o] !== t) e[i++] = n[o++];
            return e.length = i, e
        }, grep: function (e, t, n) {
            var r, i = [], o = 0, a = e.length;
            for (n = !!n; a > o; o++) r = !!t(e[o], o), n !== r && i.push(e[o]);
            return i
        }, map: function (e, t, n) {
            var r, i = 0, o = e.length, a = M(e), s = [];
            if (a) for (; o > i; i++) r = t(e[i], i, n), null != r && (s[s.length] = r); else for (i in e) r = t(e[i], i, n), null != r && (s[s.length] = r);
            return f.apply([], s)
        }, guid: 1, proxy: function (e, n) {
            var r, i, o;
            return "string" == typeof n && (o = e[n], n = e, e = o), b.isFunction(e) ? (r = h.call(arguments, 2), i = function () {
                return e.apply(n || this, r.concat(h.call(arguments)))
            }, i.guid = e.guid = e.guid || b.guid++, i) : t
        }, access: function (e, n, r, i, o, a, s) {
            var u = 0, l = e.length, c = null == r;
            if ("object" === b.type(r)) {
                o = !0;
                for (u in r) b.access(e, n, u, r[u], !0, a, s)
            } else if (i !== t && (o = !0, b.isFunction(i) || (s = !0), c && (s ? (n.call(e, i), n = null) : (c = n, n = function (e, t, n) {
                return c.call(b(e), n)
            })), n)) for (; l > u; u++) n(e[u], r, s ? i : i.call(e[u], u, n(e[u], r)));
            return o ? e : c ? n.call(e) : l ? n(e[0], r) : a
        }, now: function () {
            return (new Date).getTime()
        }
    }), b.ready.promise = function (t) {
        if (!n) if (n = b.Deferred(), "complete" === o.readyState) setTimeout(b.ready); else if (o.addEventListener) o.addEventListener("DOMContentLoaded", H, !1), e.addEventListener("load", H, !1); else {
            o.attachEvent("onreadystatechange", H), e.attachEvent("onload", H);
            var r = !1;
            try {
                r = null == e.frameElement && o.documentElement
            } catch (i) {
            }
            r && r.doScroll && function a() {
                if (!b.isReady) {
                    try {
                        r.doScroll("left")
                    } catch (e) {
                        return setTimeout(a, 50)
                    }
                    q(), b.ready()
                }
            }()
        }
        return n.promise(t)
    }, b.each("Boolean Number String Function Array Date RegExp Object Error".split(" "), function (e, t) {
        l["[object " + t + "]"] = t.toLowerCase()
    });

    function M(e) {
        var t = e.length, n = b.type(e);
        return b.isWindow(e) ? !1 : 1 === e.nodeType && t ? !0 : "array" === n || "function" !== n && (0 === t || "number" == typeof t && t > 0 && t - 1 in e)
    }

    r = b(o);
    var _ = {};

    function F(e) {
        var t = _[e] = {};
        return b.each(e.match(w) || [], function (e, n) {
            t[n] = !0
        }), t
    }

    b.Callbacks = function (e) {
        e = "string" == typeof e ? _[e] || F(e) : b.extend({}, e);
        var n, r, i, o, a, s, u = [], l = !e.once && [], c = function (t) {
            for (r = e.memory && t, i = !0, a = s || 0, s = 0, o = u.length, n = !0; u && o > a; a++) if (u[a].apply(t[0], t[1]) === !1 && e.stopOnFalse) {
                r = !1;
                break
            }
            n = !1, u && (l ? l.length && c(l.shift()) : r ? u = [] : p.disable())
        }, p = {
            add: function () {
                if (u) {
                    var t = u.length;
                    (function i(t) {
                        b.each(t, function (t, n) {
                            var r = b.type(n);
                            "function" === r ? e.unique && p.has(n) || u.push(n) : n && n.length && "string" !== r && i(n)
                        })
                    })(arguments), n ? o = u.length : r && (s = t, c(r))
                }
                return this
            }, remove: function () {
                return u && b.each(arguments, function (e, t) {
                    var r;
                    while ((r = b.inArray(t, u, r)) > -1) u.splice(r, 1), n && (o >= r && o--, a >= r && a--)
                }), this
            }, has: function (e) {
                return e ? b.inArray(e, u) > -1 : !(!u || !u.length)
            }, empty: function () {
                return u = [], this
            }, disable: function () {
                return u = l = r = t, this
            }, disabled: function () {
                return !u
            }, lock: function () {
                return l = t, r || p.disable(), this
            }, locked: function () {
                return !l
            }, fireWith: function (e, t) {
                return t = t || [], t = [e, t.slice ? t.slice() : t], !u || i && !l || (n ? l.push(t) : c(t)), this
            }, fire: function () {
                return p.fireWith(this, arguments), this
            }, fired: function () {
                return !!i
            }
        };
        return p
    }, b.extend({
        Deferred: function (e) {
            var t = [["resolve", "done", b.Callbacks("once memory"), "resolved"], ["reject", "fail", b.Callbacks("once memory"), "rejected"], ["notify", "progress", b.Callbacks("memory")]],
                n = "pending", r = {
                    state: function () {
                        return n
                    }, always: function () {
                        return i.done(arguments).fail(arguments), this
                    }, then: function () {
                        var e = arguments;
                        return b.Deferred(function (n) {
                            b.each(t, function (t, o) {
                                var a = o[0], s = b.isFunction(e[t]) && e[t];
                                i[o[1]](function () {
                                    var e = s && s.apply(this, arguments);
                                    e && b.isFunction(e.promise) ? e.promise().done(n.resolve).fail(n.reject).progress(n.notify) : n[a + "With"](this === r ? n.promise() : this, s ? [e] : arguments)
                                })
                            }), e = null
                        }).promise()
                    }, promise: function (e) {
                        return null != e ? b.extend(e, r) : r
                    }
                }, i = {};
            return r.pipe = r.then, b.each(t, function (e, o) {
                var a = o[2], s = o[3];
                r[o[1]] = a.add, s && a.add(function () {
                    n = s
                }, t[1 ^ e][2].disable, t[2][2].lock), i[o[0]] = function () {
                    return i[o[0] + "With"](this === i ? r : this, arguments), this
                }, i[o[0] + "With"] = a.fireWith
            }), r.promise(i), e && e.call(i, i), i
        }, when: function (e) {
            var t = 0, n = h.call(arguments), r = n.length, i = 1 !== r || e && b.isFunction(e.promise) ? r : 0,
                o = 1 === i ? e : b.Deferred(), a = function (e, t, n) {
                    return function (r) {
                        t[e] = this, n[e] = arguments.length > 1 ? h.call(arguments) : r, n === s ? o.notifyWith(t, n) : --i || o.resolveWith(t, n)
                    }
                }, s, u, l;
            if (r > 1) for (s = Array(r), u = Array(r), l = Array(r); r > t; t++) n[t] && b.isFunction(n[t].promise) ? n[t].promise().done(a(t, l, n)).fail(o.reject).progress(a(t, u, s)) : --i;
            return i || o.resolveWith(l, n), o.promise()
        }
    }), b.support = function () {
        var t, n, r, a, s, u, l, c, p, f, d = o.createElement("div");
        if (d.setAttribute("className", "t"), d.innerHTML = "  <link/><table></table><a href='/a'>a</a><input type='checkbox'/>", n = d.getElementsByTagName("*"), r = d.getElementsByTagName("a")[0], !n || !r || !n.length) return {};
        s = o.createElement("select"), l = s.appendChild(o.createElement("option")), a = d.getElementsByTagName("input")[0], r.style.cssText = "top:1px;float:left;opacity:.5", t = {
            getSetAttribute: "t" !== d.className,
            leadingWhitespace: 3 === d.firstChild.nodeType,
            tbody: !d.getElementsByTagName("tbody").length,
            htmlSerialize: !!d.getElementsByTagName("link").length,
            style: /top/.test(r.getAttribute("style")),
            hrefNormalized: "/a" === r.getAttribute("href"),
            opacity: /^0.5/.test(r.style.opacity),
            cssFloat: !!r.style.cssFloat,
            checkOn: !!a.value,
            optSelected: l.selected,
            enctype: !!o.createElement("form").enctype,
            html5Clone: "<:nav></:nav>" !== o.createElement("nav").cloneNode(!0).outerHTML,
            boxModel: "CSS1Compat" === o.compatMode,
            deleteExpando: !0,
            noCloneEvent: !0,
            inlineBlockNeedsLayout: !1,
            shrinkWrapBlocks: !1,
            reliableMarginRight: !0,
            boxSizingReliable: !0,
            pixelPosition: !1
        }, a.checked = !0, t.noCloneChecked = a.cloneNode(!0).checked, s.disabled = !0, t.optDisabled = !l.disabled;
        try {
            delete d.test
        } catch (h) {
            t.deleteExpando = !1
        }
        a = o.createElement("input"), a.setAttribute("value", ""), t.input = "" === a.getAttribute("value"), a.value = "t", a.setAttribute("type", "radio"), t.radioValue = "t" === a.value, a.setAttribute("checked", "t"), a.setAttribute("name", "t"), u = o.createDocumentFragment(), u.appendChild(a), t.appendChecked = a.checked, t.checkClone = u.cloneNode(!0).cloneNode(!0).lastChild.checked, d.attachEvent && (d.attachEvent("onclick", function () {
            t.noCloneEvent = !1
        }), d.cloneNode(!0).click());
        for (f in {
            submit: !0,
            change: !0,
            focusin: !0
        }) d.setAttribute(c = "on" + f, "t"), t[f + "Bubbles"] = c in e || d.attributes[c].expando === !1;
        return d.style.backgroundClip = "content-box", d.cloneNode(!0).style.backgroundClip = "", t.clearCloneStyle = "content-box" === d.style.backgroundClip, b(function () {
            var n, r, a,
                s = "padding:0;margin:0;border:0;display:block;box-sizing:content-box;-moz-box-sizing:content-box;-webkit-box-sizing:content-box;",
                u = o.getElementsByTagName("body")[0];
            u && (n = o.createElement("div"), n.style.cssText = "border:0;width:0;height:0;position:absolute;top:0;left:-9999px;margin-top:1px", u.appendChild(n).appendChild(d), d.innerHTML = "<table><tr><td></td><td>t</td></tr></table>", a = d.getElementsByTagName("td"), a[0].style.cssText = "padding:0;margin:0;border:0;display:none", p = 0 === a[0].offsetHeight, a[0].style.display = "", a[1].style.display = "none", t.reliableHiddenOffsets = p && 0 === a[0].offsetHeight, d.innerHTML = "", d.style.cssText = "box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;padding:1px;border:1px;display:block;width:4px;margin-top:1%;position:absolute;top:1%;", t.boxSizing = 4 === d.offsetWidth, t.doesNotIncludeMarginInBodyOffset = 1 !== u.offsetTop, e.getComputedStyle && (t.pixelPosition = "1%" !== (e.getComputedStyle(d, null) || {}).top, t.boxSizingReliable = "4px" === (e.getComputedStyle(d, null) || {width: "4px"}).width, r = d.appendChild(o.createElement("div")), r.style.cssText = d.style.cssText = s, r.style.marginRight = r.style.width = "0", d.style.width = "1px", t.reliableMarginRight = !parseFloat((e.getComputedStyle(r, null) || {}).marginRight)), typeof d.style.zoom !== i && (d.innerHTML = "", d.style.cssText = s + "width:1px;padding:1px;display:inline;zoom:1", t.inlineBlockNeedsLayout = 3 === d.offsetWidth, d.style.display = "block", d.innerHTML = "<div></div>", d.firstChild.style.width = "5px", t.shrinkWrapBlocks = 3 !== d.offsetWidth, t.inlineBlockNeedsLayout && (u.style.zoom = 1)), u.removeChild(n), n = d = a = r = null)
        }), n = s = u = l = r = a = null, t
    }();
    var O = /(?:\{[\s\S]*\}|\[[\s\S]*\])$/, B = /([A-Z])/g;

    function P(e, n, r, i) {
        if (b.acceptData(e)) {
            var o, a, s = b.expando, u = "string" == typeof n, l = e.nodeType, p = l ? b.cache : e,
                f = l ? e[s] : e[s] && s;
            if (f && p[f] && (i || p[f].data) || !u || r !== t) return f || (l ? e[s] = f = c.pop() || b.guid++ : f = s), p[f] || (p[f] = {}, l || (p[f].toJSON = b.noop)), ("object" == typeof n || "function" == typeof n) && (i ? p[f] = b.extend(p[f], n) : p[f].data = b.extend(p[f].data, n)), o = p[f], i || (o.data || (o.data = {}), o = o.data), r !== t && (o[b.camelCase(n)] = r), u ? (a = o[n], null == a && (a = o[b.camelCase(n)])) : a = o, a
        }
    }

    function R(e, t, n) {
        if (b.acceptData(e)) {
            var r, i, o, a = e.nodeType, s = a ? b.cache : e, u = a ? e[b.expando] : b.expando;
            if (s[u]) {
                if (t && (o = n ? s[u] : s[u].data)) {
                    b.isArray(t) ? t = t.concat(b.map(t, b.camelCase)) : t in o ? t = [t] : (t = b.camelCase(t), t = t in o ? [t] : t.split(" "));
                    for (r = 0, i = t.length; i > r; r++) delete o[t[r]];
                    if (!(n ? $ : b.isEmptyObject)(o)) return
                }
                (n || (delete s[u].data, $(s[u]))) && (a ? b.cleanData([e], !0) : b.support.deleteExpando || s != s.window ? delete s[u] : s[u] = null)
            }
        }
    }

    b.extend({
        cache: {},
        expando: "jQuery" + (p + Math.random()).replace(/\D/g, ""),
        noData: {embed: !0, object: "clsid:D27CDB6E-AE6D-11cf-96B8-444553540000", applet: !0},
        hasData: function (e) {
            return e = e.nodeType ? b.cache[e[b.expando]] : e[b.expando], !!e && !$(e)
        },
        data: function (e, t, n) {
            return P(e, t, n)
        },
        removeData: function (e, t) {
            return R(e, t)
        },
        _data: function (e, t, n) {
            return P(e, t, n, !0)
        },
        _removeData: function (e, t) {
            return R(e, t, !0)
        },
        acceptData: function (e) {
            if (e.nodeType && 1 !== e.nodeType && 9 !== e.nodeType) return !1;
            var t = e.nodeName && b.noData[e.nodeName.toLowerCase()];
            return !t || t !== !0 && e.getAttribute("classid") === t
        }
    }), b.fn.extend({
        data: function (e, n) {
            var r, i, o = this[0], a = 0, s = null;
            if (e === t) {
                if (this.length && (s = b.data(o), 1 === o.nodeType && !b._data(o, "parsedAttrs"))) {
                    for (r = o.attributes; r.length > a; a++) i = r[a].name, i.indexOf("data-") || (i = b.camelCase(i.slice(5)), W(o, i, s[i]));
                    b._data(o, "parsedAttrs", !0)
                }
                return s
            }
            return "object" == typeof e ? this.each(function () {
                b.data(this, e)
            }) : b.access(this, function (n) {
                return n === t ? o ? W(o, e, b.data(o, e)) : null : (this.each(function () {
                    b.data(this, e, n)
                }), t)
            }, null, n, arguments.length > 1, null, !0)
        }, removeData: function (e) {
            return this.each(function () {
                b.removeData(this, e)
            })
        }
    });

    function W(e, n, r) {
        if (r === t && 1 === e.nodeType) {
            var i = "data-" + n.replace(B, "-$1").toLowerCase();
            if (r = e.getAttribute(i), "string" == typeof r) {
                try {
                    r = "true" === r ? !0 : "false" === r ? !1 : "null" === r ? null : +r + "" === r ? +r : O.test(r) ? b.parseJSON(r) : r
                } catch (o) {
                }
                b.data(e, n, r)
            } else r = t
        }
        return r
    }

    function $(e) {
        var t;
        for (t in e) if (("data" !== t || !b.isEmptyObject(e[t])) && "toJSON" !== t) return !1;
        return !0
    }

    b.extend({
        queue: function (e, n, r) {
            var i;
            return e ? (n = (n || "fx") + "queue", i = b._data(e, n), r && (!i || b.isArray(r) ? i = b._data(e, n, b.makeArray(r)) : i.push(r)), i || []) : t
        }, dequeue: function (e, t) {
            t = t || "fx";
            var n = b.queue(e, t), r = n.length, i = n.shift(), o = b._queueHooks(e, t), a = function () {
                b.dequeue(e, t)
            };
            "inprogress" === i && (i = n.shift(), r--), o.cur = i, i && ("fx" === t && n.unshift("inprogress"), delete o.stop, i.call(e, a, o)), !r && o && o.empty.fire()
        }, _queueHooks: function (e, t) {
            var n = t + "queueHooks";
            return b._data(e, n) || b._data(e, n, {
                empty: b.Callbacks("once memory").add(function () {
                    b._removeData(e, t + "queue"), b._removeData(e, n)
                })
            })
        }
    }), b.fn.extend({
        queue: function (e, n) {
            var r = 2;
            return "string" != typeof e && (n = e, e = "fx", r--), r > arguments.length ? b.queue(this[0], e) : n === t ? this : this.each(function () {
                var t = b.queue(this, e, n);
                b._queueHooks(this, e), "fx" === e && "inprogress" !== t[0] && b.dequeue(this, e)
            })
        }, dequeue: function (e) {
            return this.each(function () {
                b.dequeue(this, e)
            })
        }, delay: function (e, t) {
            return e = b.fx ? b.fx.speeds[e] || e : e, t = t || "fx", this.queue(t, function (t, n) {
                var r = setTimeout(t, e);
                n.stop = function () {
                    clearTimeout(r)
                }
            })
        }, clearQueue: function (e) {
            return this.queue(e || "fx", [])
        }, promise: function (e, n) {
            var r, i = 1, o = b.Deferred(), a = this, s = this.length, u = function () {
                --i || o.resolveWith(a, [a])
            };
            "string" != typeof e && (n = e, e = t), e = e || "fx";
            while (s--) r = b._data(a[s], e + "queueHooks"), r && r.empty && (i++, r.empty.add(u));
            return u(), o.promise(n)
        }
    });
    var I, z, X = /[\t\r\n]/g, U = /\r/g, V = /^(?:input|select|textarea|button|object)$/i, Y = /^(?:a|area)$/i,
        J = /^(?:checked|selected|autofocus|autoplay|async|controls|defer|disabled|hidden|loop|multiple|open|readonly|required|scoped)$/i,
        G = /^(?:checked|selected)$/i, Q = b.support.getSetAttribute, K = b.support.input;
    b.fn.extend({
        attr: function (e, t) {
            return b.access(this, b.attr, e, t, arguments.length > 1)
        }, removeAttr: function (e) {
            return this.each(function () {
                b.removeAttr(this, e)
            })
        }, prop: function (e, t) {
            return b.access(this, b.prop, e, t, arguments.length > 1)
        }, removeProp: function (e) {
            return e = b.propFix[e] || e, this.each(function () {
                try {
                    this[e] = t, delete this[e]
                } catch (n) {
                }
            })
        }, addClass: function (e) {
            var t, n, r, i, o, a = 0, s = this.length, u = "string" == typeof e && e;
            if (b.isFunction(e)) return this.each(function (t) {
                b(this).addClass(e.call(this, t, this.className))
            });
            if (u) for (t = (e || "").match(w) || []; s > a; a++) if (n = this[a], r = 1 === n.nodeType && (n.className ? (" " + n.className + " ").replace(X, " ") : " ")) {
                o = 0;
                while (i = t[o++]) 0 > r.indexOf(" " + i + " ") && (r += i + " ");
                n.className = b.trim(r)
            }
            return this
        }, removeClass: function (e) {
            var t, n, r, i, o, a = 0, s = this.length, u = 0 === arguments.length || "string" == typeof e && e;
            if (b.isFunction(e)) return this.each(function (t) {
                b(this).removeClass(e.call(this, t, this.className))
            });
            if (u) for (t = (e || "").match(w) || []; s > a; a++) if (n = this[a], r = 1 === n.nodeType && (n.className ? (" " + n.className + " ").replace(X, " ") : "")) {
                o = 0;
                while (i = t[o++]) while (r.indexOf(" " + i + " ") >= 0) r = r.replace(" " + i + " ", " ");
                n.className = e ? b.trim(r) : ""
            }
            return this
        }, toggleClass: function (e, t) {
            var n = typeof e, r = "boolean" == typeof t;
            return b.isFunction(e) ? this.each(function (n) {
                b(this).toggleClass(e.call(this, n, this.className, t), t)
            }) : this.each(function () {
                if ("string" === n) {
                    var o, a = 0, s = b(this), u = t, l = e.match(w) || [];
                    while (o = l[a++]) u = r ? u : !s.hasClass(o), s[u ? "addClass" : "removeClass"](o)
                } else (n === i || "boolean" === n) && (this.className && b._data(this, "__className__", this.className), this.className = this.className || e === !1 ? "" : b._data(this, "__className__") || "")
            })
        }, hasClass: function (e) {
            var t = " " + e + " ", n = 0, r = this.length;
            for (; r > n; n++) if (1 === this[n].nodeType && (" " + this[n].className + " ").replace(X, " ").indexOf(t) >= 0) return !0;
            return !1
        }, val: function (e) {
            var n, r, i, o = this[0];
            {
                if (arguments.length) return i = b.isFunction(e), this.each(function (n) {
                    var o, a = b(this);
                    1 === this.nodeType && (o = i ? e.call(this, n, a.val()) : e, null == o ? o = "" : "number" == typeof o ? o += "" : b.isArray(o) && (o = b.map(o, function (e) {
                        return null == e ? "" : e + ""
                    })), r = b.valHooks[this.type] || b.valHooks[this.nodeName.toLowerCase()], r && "set" in r && r.set(this, o, "value") !== t || (this.value = o))
                });
                if (o) return r = b.valHooks[o.type] || b.valHooks[o.nodeName.toLowerCase()], r && "get" in r && (n = r.get(o, "value")) !== t ? n : (n = o.value, "string" == typeof n ? n.replace(U, "") : null == n ? "" : n)
            }
        }
    }), b.extend({
        valHooks: {
            option: {
                get: function (e) {
                    var t = e.attributes.value;
                    return !t || t.specified ? e.value : e.text
                }
            }, select: {
                get: function (e) {
                    var t, n, r = e.options, i = e.selectedIndex, o = "select-one" === e.type || 0 > i,
                        a = o ? null : [], s = o ? i + 1 : r.length, u = 0 > i ? s : o ? i : 0;
                    for (; s > u; u++) if (n = r[u], !(!n.selected && u !== i || (b.support.optDisabled ? n.disabled : null !== n.getAttribute("disabled")) || n.parentNode.disabled && b.nodeName(n.parentNode, "optgroup"))) {
                        if (t = b(n).val(), o) return t;
                        a.push(t)
                    }
                    return a
                }, set: function (e, t) {
                    var n = b.makeArray(t);
                    return b(e).find("option").each(function () {
                        this.selected = b.inArray(b(this).val(), n) >= 0
                    }), n.length || (e.selectedIndex = -1), n
                }
            }
        },
        attr: function (e, n, r) {
            var o, a, s, u = e.nodeType;
            if (e && 3 !== u && 8 !== u && 2 !== u) return typeof e.getAttribute === i ? b.prop(e, n, r) : (a = 1 !== u || !b.isXMLDoc(e), a && (n = n.toLowerCase(), o = b.attrHooks[n] || (J.test(n) ? z : I)), r === t ? o && a && "get" in o && null !== (s = o.get(e, n)) ? s : (typeof e.getAttribute !== i && (s = e.getAttribute(n)), null == s ? t : s) : null !== r ? o && a && "set" in o && (s = o.set(e, r, n)) !== t ? s : (e.setAttribute(n, r + ""), r) : (b.removeAttr(e, n), t))
        },
        removeAttr: function (e, t) {
            var n, r, i = 0, o = t && t.match(w);
            if (o && 1 === e.nodeType) while (n = o[i++]) r = b.propFix[n] || n, J.test(n) ? !Q && G.test(n) ? e[b.camelCase("default-" + n)] = e[r] = !1 : e[r] = !1 : b.attr(e, n, ""), e.removeAttribute(Q ? n : r)
        },
        attrHooks: {
            type: {
                set: function (e, t) {
                    if (!b.support.radioValue && "radio" === t && b.nodeName(e, "input")) {
                        var n = e.value;
                        return e.setAttribute("type", t), n && (e.value = n), t
                    }
                }
            }
        },
        propFix: {
            tabindex: "tabIndex",
            readonly: "readOnly",
            "for": "htmlFor",
            "class": "className",
            maxlength: "maxLength",
            cellspacing: "cellSpacing",
            cellpadding: "cellPadding",
            rowspan: "rowSpan",
            colspan: "colSpan",
            usemap: "useMap",
            frameborder: "frameBorder",
            contenteditable: "contentEditable"
        },
        prop: function (e, n, r) {
            var i, o, a, s = e.nodeType;
            if (e && 3 !== s && 8 !== s && 2 !== s) return a = 1 !== s || !b.isXMLDoc(e), a && (n = b.propFix[n] || n, o = b.propHooks[n]), r !== t ? o && "set" in o && (i = o.set(e, r, n)) !== t ? i : e[n] = r : o && "get" in o && null !== (i = o.get(e, n)) ? i : e[n]
        },
        propHooks: {
            tabIndex: {
                get: function (e) {
                    var n = e.getAttributeNode("tabindex");
                    return n && n.specified ? parseInt(n.value, 10) : V.test(e.nodeName) || Y.test(e.nodeName) && e.href ? 0 : t
                }
            }
        }
    }), z = {
        get: function (e, n) {
            var r = b.prop(e, n), i = "boolean" == typeof r && e.getAttribute(n),
                o = "boolean" == typeof r ? K && Q ? null != i : G.test(n) ? e[b.camelCase("default-" + n)] : !!i : e.getAttributeNode(n);
            return o && o.value !== !1 ? n.toLowerCase() : t
        }, set: function (e, t, n) {
            return t === !1 ? b.removeAttr(e, n) : K && Q || !G.test(n) ? e.setAttribute(!Q && b.propFix[n] || n, n) : e[b.camelCase("default-" + n)] = e[n] = !0, n
        }
    }, K && Q || (b.attrHooks.value = {
        get: function (e, n) {
            var r = e.getAttributeNode(n);
            return b.nodeName(e, "input") ? e.defaultValue : r && r.specified ? r.value : t
        }, set: function (e, n, r) {
            return b.nodeName(e, "input") ? (e.defaultValue = n, t) : I && I.set(e, n, r)
        }
    }), Q || (I = b.valHooks.button = {
        get: function (e, n) {
            var r = e.getAttributeNode(n);
            return r && ("id" === n || "name" === n || "coords" === n ? "" !== r.value : r.specified) ? r.value : t
        }, set: function (e, n, r) {
            var i = e.getAttributeNode(r);
            return i || e.setAttributeNode(i = e.ownerDocument.createAttribute(r)), i.value = n += "", "value" === r || n === e.getAttribute(r) ? n : t
        }
    }, b.attrHooks.contenteditable = {
        get: I.get, set: function (e, t, n) {
            I.set(e, "" === t ? !1 : t, n)
        }
    }, b.each(["width", "height"], function (e, n) {
        b.attrHooks[n] = b.extend(b.attrHooks[n], {
            set: function (e, r) {
                return "" === r ? (e.setAttribute(n, "auto"), r) : t
            }
        })
    })), b.support.hrefNormalized || (b.each(["href", "src", "width", "height"], function (e, n) {
        b.attrHooks[n] = b.extend(b.attrHooks[n], {
            get: function (e) {
                var r = e.getAttribute(n, 2);
                return null == r ? t : r
            }
        })
    }), b.each(["href", "src"], function (e, t) {
        b.propHooks[t] = {
            get: function (e) {
                return e.getAttribute(t, 4)
            }
        }
    })), b.support.style || (b.attrHooks.style = {
        get: function (e) {
            return e.style.cssText || t
        }, set: function (e, t) {
            return e.style.cssText = t + ""
        }
    }), b.support.optSelected || (b.propHooks.selected = b.extend(b.propHooks.selected, {
        get: function (e) {
            var t = e.parentNode;
            return t && (t.selectedIndex, t.parentNode && t.parentNode.selectedIndex), null
        }
    })), b.support.enctype || (b.propFix.enctype = "encoding"), b.support.checkOn || b.each(["radio", "checkbox"], function () {
        b.valHooks[this] = {
            get: function (e) {
                return null === e.getAttribute("value") ? "on" : e.value
            }
        }
    }), b.each(["radio", "checkbox"], function () {
        b.valHooks[this] = b.extend(b.valHooks[this], {
            set: function (e, n) {
                return b.isArray(n) ? e.checked = b.inArray(b(e).val(), n) >= 0 : t
            }
        })
    });
    var Z = /^(?:input|select|textarea)$/i, et = /^key/, tt = /^(?:mouse|contextmenu)|click/,
        nt = /^(?:focusinfocus|focusoutblur)$/, rt = /^([^.]*)(?:\.(.+)|)$/;

    function it() {
        return !0
    }

    function ot() {
        return !1
    }

    b.event = {
        global: {},
        add: function (e, n, r, o, a) {
            var s, u, l, c, p, f, d, h, g, m, y, v = b._data(e);
            if (v) {
                r.handler && (c = r, r = c.handler, a = c.selector), r.guid || (r.guid = b.guid++), (u = v.events) || (u = v.events = {}), (f = v.handle) || (f = v.handle = function (e) {
                    return typeof b === i || e && b.event.triggered === e.type ? t : b.event.dispatch.apply(f.elem, arguments)
                }, f.elem = e), n = (n || "").match(w) || [""], l = n.length;
                while (l--) s = rt.exec(n[l]) || [], g = y = s[1], m = (s[2] || "").split(".").sort(), p = b.event.special[g] || {}, g = (a ? p.delegateType : p.bindType) || g, p = b.event.special[g] || {}, d = b.extend({
                    type: g,
                    origType: y,
                    data: o,
                    handler: r,
                    guid: r.guid,
                    selector: a,
                    needsContext: a && b.expr.match.needsContext.test(a),
                    namespace: m.join(".")
                }, c), (h = u[g]) || (h = u[g] = [], h.delegateCount = 0, p.setup && p.setup.call(e, o, m, f) !== !1 || (e.addEventListener ? e.addEventListener(g, f, !1) : e.attachEvent && e.attachEvent("on" + g, f))), p.add && (p.add.call(e, d), d.handler.guid || (d.handler.guid = r.guid)), a ? h.splice(h.delegateCount++, 0, d) : h.push(d), b.event.global[g] = !0;
                e = null
            }
        },
        remove: function (e, t, n, r, i) {
            var o, a, s, u, l, c, p, f, d, h, g, m = b.hasData(e) && b._data(e);
            if (m && (c = m.events)) {
                t = (t || "").match(w) || [""], l = t.length;
                while (l--) if (s = rt.exec(t[l]) || [], d = g = s[1], h = (s[2] || "").split(".").sort(), d) {
                    p = b.event.special[d] || {}, d = (r ? p.delegateType : p.bindType) || d, f = c[d] || [], s = s[2] && RegExp("(^|\\.)" + h.join("\\.(?:.*\\.|)") + "(\\.|$)"), u = o = f.length;
                    while (o--) a = f[o], !i && g !== a.origType || n && n.guid !== a.guid || s && !s.test(a.namespace) || r && r !== a.selector && ("**" !== r || !a.selector) || (f.splice(o, 1), a.selector && f.delegateCount--, p.remove && p.remove.call(e, a));
                    u && !f.length && (p.teardown && p.teardown.call(e, h, m.handle) !== !1 || b.removeEvent(e, d, m.handle), delete c[d])
                } else for (d in c) b.event.remove(e, d + t[l], n, r, !0);
                b.isEmptyObject(c) && (delete m.handle, b._removeData(e, "events"))
            }
        },
        trigger: function (n, r, i, a) {
            var s, u, l, c, p, f, d, h = [i || o], g = y.call(n, "type") ? n.type : n,
                m = y.call(n, "namespace") ? n.namespace.split(".") : [];
            if (l = f = i = i || o, 3 !== i.nodeType && 8 !== i.nodeType && !nt.test(g + b.event.triggered) && (g.indexOf(".") >= 0 && (m = g.split("."), g = m.shift(), m.sort()), u = 0 > g.indexOf(":") && "on" + g, n = n[b.expando] ? n : new b.Event(g, "object" == typeof n && n), n.isTrigger = !0, n.namespace = m.join("."), n.namespace_re = n.namespace ? RegExp("(^|\\.)" + m.join("\\.(?:.*\\.|)") + "(\\.|$)") : null, n.result = t, n.target || (n.target = i), r = null == r ? [n] : b.makeArray(r, [n]), p = b.event.special[g] || {}, a || !p.trigger || p.trigger.apply(i, r) !== !1)) {
                if (!a && !p.noBubble && !b.isWindow(i)) {
                    for (c = p.delegateType || g, nt.test(c + g) || (l = l.parentNode); l; l = l.parentNode) h.push(l), f = l;
                    f === (i.ownerDocument || o) && h.push(f.defaultView || f.parentWindow || e)
                }
                d = 0;
                while ((l = h[d++]) && !n.isPropagationStopped()) n.type = d > 1 ? c : p.bindType || g, s = (b._data(l, "events") || {})[n.type] && b._data(l, "handle"), s && s.apply(l, r), s = u && l[u], s && b.acceptData(l) && s.apply && s.apply(l, r) === !1 && n.preventDefault();
                if (n.type = g, !(a || n.isDefaultPrevented() || p._default && p._default.apply(i.ownerDocument, r) !== !1 || "click" === g && b.nodeName(i, "a") || !b.acceptData(i) || !u || !i[g] || b.isWindow(i))) {
                    f = i[u], f && (i[u] = null), b.event.triggered = g;
                    try {
                        i[g]()
                    } catch (v) {
                    }
                    b.event.triggered = t, f && (i[u] = f)
                }
                return n.result
            }
        },
        dispatch: function (e) {
            e = b.event.fix(e);
            var n, r, i, o, a, s = [], u = h.call(arguments), l = (b._data(this, "events") || {})[e.type] || [],
                c = b.event.special[e.type] || {};
            if (u[0] = e, e.delegateTarget = this, !c.preDispatch || c.preDispatch.call(this, e) !== !1) {
                s = b.event.handlers.call(this, e, l), n = 0;
                while ((o = s[n++]) && !e.isPropagationStopped()) {
                    e.currentTarget = o.elem, a = 0;
                    while ((i = o.handlers[a++]) && !e.isImmediatePropagationStopped()) (!e.namespace_re || e.namespace_re.test(i.namespace)) && (e.handleObj = i, e.data = i.data, r = ((b.event.special[i.origType] || {}).handle || i.handler).apply(o.elem, u), r !== t && (e.result = r) === !1 && (e.preventDefault(), e.stopPropagation()))
                }
                return c.postDispatch && c.postDispatch.call(this, e), e.result
            }
        },
        handlers: function (e, n) {
            var r, i, o, a, s = [], u = n.delegateCount, l = e.target;
            if (u && l.nodeType && (!e.button || "click" !== e.type)) for (; l != this; l = l.parentNode || this) if (1 === l.nodeType && (l.disabled !== !0 || "click" !== e.type)) {
                for (o = [], a = 0; u > a; a++) i = n[a], r = i.selector + " ", o[r] === t && (o[r] = i.needsContext ? b(r, this).index(l) >= 0 : b.find(r, this, null, [l]).length), o[r] && o.push(i);
                o.length && s.push({elem: l, handlers: o})
            }
            return n.length > u && s.push({elem: this, handlers: n.slice(u)}), s
        },
        fix: function (e) {
            if (e[b.expando]) return e;
            var t, n, r, i = e.type, a = e, s = this.fixHooks[i];
            s || (this.fixHooks[i] = s = tt.test(i) ? this.mouseHooks : et.test(i) ? this.keyHooks : {}), r = s.props ? this.props.concat(s.props) : this.props, e = new b.Event(a), t = r.length;
            while (t--) n = r[t], e[n] = a[n];
            return e.target || (e.target = a.srcElement || o), 3 === e.target.nodeType && (e.target = e.target.parentNode), e.metaKey = !!e.metaKey, s.filter ? s.filter(e, a) : e
        },
        props: "altKey bubbles cancelable ctrlKey currentTarget eventPhase metaKey relatedTarget shiftKey target timeStamp view which".split(" "),
        fixHooks: {},
        keyHooks: {
            props: "char charCode key keyCode".split(" "), filter: function (e, t) {
                return null == e.which && (e.which = null != t.charCode ? t.charCode : t.keyCode), e
            }
        },
        mouseHooks: {
            props: "button buttons clientX clientY fromElement offsetX offsetY pageX pageY screenX screenY toElement".split(" "),
            filter: function (e, n) {
                var r, i, a, s = n.button, u = n.fromElement;
                return null == e.pageX && null != n.clientX && (i = e.target.ownerDocument || o, a = i.documentElement, r = i.body, e.pageX = n.clientX + (a && a.scrollLeft || r && r.scrollLeft || 0) - (a && a.clientLeft || r && r.clientLeft || 0), e.pageY = n.clientY + (a && a.scrollTop || r && r.scrollTop || 0) - (a && a.clientTop || r && r.clientTop || 0)), !e.relatedTarget && u && (e.relatedTarget = u === e.target ? n.toElement : u), e.which || s === t || (e.which = 1 & s ? 1 : 2 & s ? 3 : 4 & s ? 2 : 0), e
            }
        },
        special: {
            load: {noBubble: !0}, click: {
                trigger: function () {
                    return b.nodeName(this, "input") && "checkbox" === this.type && this.click ? (this.click(), !1) : t
                }
            }, focus: {
                trigger: function () {
                    if (this !== o.activeElement && this.focus) try {
                        return this.focus(), !1
                    } catch (e) {
                    }
                }, delegateType: "focusin"
            }, blur: {
                trigger: function () {
                    return this === o.activeElement && this.blur ? (this.blur(), !1) : t
                }, delegateType: "focusout"
            }, beforeunload: {
                postDispatch: function (e) {
                    e.result !== t && (e.originalEvent.returnValue = e.result)
                }
            }
        },
        simulate: function (e, t, n, r) {
            var i = b.extend(new b.Event, n, {type: e, isSimulated: !0, originalEvent: {}});
            r ? b.event.trigger(i, null, t) : b.event.dispatch.call(t, i), i.isDefaultPrevented() && n.preventDefault()
        }
    }, b.removeEvent = o.removeEventListener ? function (e, t, n) {
        e.removeEventListener && e.removeEventListener(t, n, !1)
    } : function (e, t, n) {
        var r = "on" + t;
        e.detachEvent && (typeof e[r] === i && (e[r] = null), e.detachEvent(r, n))
    }, b.Event = function (e, n) {
        return this instanceof b.Event ? (e && e.type ? (this.originalEvent = e, this.type = e.type, this.isDefaultPrevented = e.defaultPrevented || e.returnValue === !1 || e.defaultPrevented && e.defaultPrevented() ? it : ot) : this.type = e, n && b.extend(this, n), this.timeStamp = e && e.timeStamp || b.now(), this[b.expando] = !0, t) : new b.Event(e, n)
    }, b.Event.prototype = {
        isDefaultPrevented: ot,
        isPropagationStopped: ot,
        isImmediatePropagationStopped: ot,
        preventDefault: function () {
            var e = this.originalEvent;
            this.isDefaultPrevented = it, e && (e.preventDefault ? e.preventDefault() : e.returnValue = !1)
        },
        stopPropagation: function () {
            var e = this.originalEvent;
            this.isPropagationStopped = it, e && (e.stopPropagation && e.stopPropagation(), e.cancelBubble = !0)
        },
        stopImmediatePropagation: function () {
            this.isImmediatePropagationStopped = it, this.stopPropagation()
        }
    }, b.each({mouseenter: "mouseover", mouseleave: "mouseout"}, function (e, t) {
        b.event.special[e] = {
            delegateType: t, bindType: t, handle: function (e) {
                var n, r = this, i = e.relatedTarget, o = e.handleObj;
                return (!i || i !== r && !b.contains(r, i)) && (e.type = o.origType, n = o.handler.apply(this, arguments), e.type = t), n
            }
        }
    }), b.support.submitBubbles || (b.event.special.submit = {
        setup: function () {
            return b.nodeName(this, "form") ? !1 : (b.event.add(this, "click._submit keypress._submit", function (e) {
                var n = e.target, r = b.nodeName(n, "input") || b.nodeName(n, "button") ? n.form : t;
                r && !b._data(r, "submitBubbles") && (b.event.add(r, "submit._submit", function (e) {
                    e._submit_bubble = !0
                }), b._data(r, "submitBubbles", !0))
            }), t)
        }, postDispatch: function (e) {
            e._submit_bubble && (delete e._submit_bubble, this.parentNode && !e.isTrigger && b.event.simulate("submit", this.parentNode, e, !0))
        }, teardown: function () {
            return b.nodeName(this, "form") ? !1 : (b.event.remove(this, "._submit"), t)
        }
    }), b.support.changeBubbles || (b.event.special.change = {
        setup: function () {
            return Z.test(this.nodeName) ? (("checkbox" === this.type || "radio" === this.type) && (b.event.add(this, "propertychange._change", function (e) {
                "checked" === e.originalEvent.propertyName && (this._just_changed = !0)
            }), b.event.add(this, "click._change", function (e) {
                this._just_changed && !e.isTrigger && (this._just_changed = !1), b.event.simulate("change", this, e, !0)
            })), !1) : (b.event.add(this, "beforeactivate._change", function (e) {
                var t = e.target;
                Z.test(t.nodeName) && !b._data(t, "changeBubbles") && (b.event.add(t, "change._change", function (e) {
                    !this.parentNode || e.isSimulated || e.isTrigger || b.event.simulate("change", this.parentNode, e, !0)
                }), b._data(t, "changeBubbles", !0))
            }), t)
        }, handle: function (e) {
            var n = e.target;
            return this !== n || e.isSimulated || e.isTrigger || "radio" !== n.type && "checkbox" !== n.type ? e.handleObj.handler.apply(this, arguments) : t
        }, teardown: function () {
            return b.event.remove(this, "._change"), !Z.test(this.nodeName)
        }
    }), b.support.focusinBubbles || b.each({focus: "focusin", blur: "focusout"}, function (e, t) {
        var n = 0, r = function (e) {
            b.event.simulate(t, e.target, b.event.fix(e), !0)
        };
        b.event.special[t] = {
            setup: function () {
                0 === n++ && o.addEventListener(e, r, !0)
            }, teardown: function () {
                0 === --n && o.removeEventListener(e, r, !0)
            }
        }
    }), b.fn.extend({
        on: function (e, n, r, i, o) {
            var a, s;
            if ("object" == typeof e) {
                "string" != typeof n && (r = r || n, n = t);
                for (a in e) this.on(a, n, r, e[a], o);
                return this
            }
            if (null == r && null == i ? (i = n, r = n = t) : null == i && ("string" == typeof n ? (i = r, r = t) : (i = r, r = n, n = t)), i === !1) i = ot; else if (!i) return this;
            return 1 === o && (s = i, i = function (e) {
                return b().off(e), s.apply(this, arguments)
            }, i.guid = s.guid || (s.guid = b.guid++)), this.each(function () {
                b.event.add(this, e, i, r, n)
            })
        }, one: function (e, t, n, r) {
            return this.on(e, t, n, r, 1)
        }, off: function (e, n, r) {
            var i, o;
            if (e && e.preventDefault && e.handleObj) return i = e.handleObj, b(e.delegateTarget).off(i.namespace ? i.origType + "." + i.namespace : i.origType, i.selector, i.handler), this;
            if ("object" == typeof e) {
                for (o in e) this.off(o, n, e[o]);
                return this
            }
            return (n === !1 || "function" == typeof n) && (r = n, n = t), r === !1 && (r = ot), this.each(function () {
                b.event.remove(this, e, r, n)
            })
        }, bind: function (e, t, n) {
            return this.on(e, null, t, n)
        }, unbind: function (e, t) {
            return this.off(e, null, t)
        }, delegate: function (e, t, n, r) {
            return this.on(t, e, n, r)
        }, undelegate: function (e, t, n) {
            return 1 === arguments.length ? this.off(e, "**") : this.off(t, e || "**", n)
        }, trigger: function (e, t) {
            return this.each(function () {
                b.event.trigger(e, t, this)
            })
        }, triggerHandler: function (e, n) {
            var r = this[0];
            return r ? b.event.trigger(e, n, r, !0) : t
        }
    }), function (e, t) {
        var n, r, i, o, a, s, u, l, c, p, f, d, h, g, m, y, v, x = "sizzle" + -new Date, w = e.document, T = {}, N = 0,
            C = 0, k = it(), E = it(), S = it(), A = typeof t, j = 1 << 31, D = [], L = D.pop, H = D.push, q = D.slice,
            M = D.indexOf || function (e) {
                var t = 0, n = this.length;
                for (; n > t; t++) if (this[t] === e) return t;
                return -1
            }, _ = "[\\x20\\t\\r\\n\\f]", F = "(?:\\\\.|[\\w-]|[^\\x00-\\xa0])+", O = F.replace("w", "w#"),
            B = "([*^$|!~]?=)",
            P = "\\[" + _ + "*(" + F + ")" + _ + "*(?:" + B + _ + "*(?:(['\"])((?:\\\\.|[^\\\\])*?)\\3|(" + O + ")|)|)" + _ + "*\\]",
            R = ":(" + F + ")(?:\\(((['\"])((?:\\\\.|[^\\\\])*?)\\3|((?:\\\\.|[^\\\\()[\\]]|" + P.replace(3, 8) + ")*)|.*)\\)|)",
            W = RegExp("^" + _ + "+|((?:^|[^\\\\])(?:\\\\.)*)" + _ + "+$", "g"), $ = RegExp("^" + _ + "*," + _ + "*"),
            I = RegExp("^" + _ + "*([\\x20\\t\\r\\n\\f>+~])" + _ + "*"), z = RegExp(R), X = RegExp("^" + O + "$"), U = {
                ID: RegExp("^#(" + F + ")"),
                CLASS: RegExp("^\\.(" + F + ")"),
                NAME: RegExp("^\\[name=['\"]?(" + F + ")['\"]?\\]"),
                TAG: RegExp("^(" + F.replace("w", "w*") + ")"),
                ATTR: RegExp("^" + P),
                PSEUDO: RegExp("^" + R),
                CHILD: RegExp("^:(only|first|last|nth|nth-last)-(child|of-type)(?:\\(" + _ + "*(even|odd|(([+-]|)(\\d*)n|)" + _ + "*(?:([+-]|)" + _ + "*(\\d+)|))" + _ + "*\\)|)", "i"),
                needsContext: RegExp("^" + _ + "*[>+~]|:(even|odd|eq|gt|lt|nth|first|last)(?:\\(" + _ + "*((?:-\\d)?\\d*)" + _ + "*\\)|)(?=[^-]|$)", "i")
            }, V = /[\x20\t\r\n\f]*[+~]/, Y = /^[^{]+\{\s*\[native code/, J = /^(?:#([\w-]+)|(\w+)|\.([\w-]+))$/,
            G = /^(?:input|select|textarea|button)$/i, Q = /^h\d$/i, K = /'|\\/g,
            Z = /\=[\x20\t\r\n\f]*([^'"\]]*)[\x20\t\r\n\f]*\]/g, et = /\\([\da-fA-F]{1,6}[\x20\t\r\n\f]?|.)/g,
            tt = function (e, t) {
                var n = "0x" + t - 65536;
                return n !== n ? t : 0 > n ? String.fromCharCode(n + 65536) : String.fromCharCode(55296 | n >> 10, 56320 | 1023 & n)
            };
        try {
            q.call(w.documentElement.childNodes, 0)[0].nodeType
        } catch (nt) {
            q = function (e) {
                var t, n = [];
                while (t = this[e++]) n.push(t);
                return n
            }
        }

        function rt(e) {
            return Y.test(e + "")
        }

        function it() {
            var e, t = [];
            return e = function (n, r) {
                return t.push(n += " ") > i.cacheLength && delete e[t.shift()], e[n] = r
            }
        }

        function ot(e) {
            return e[x] = !0, e
        }

        function at(e) {
            var t = p.createElement("div");
            try {
                return e(t)
            } catch (n) {
                return !1
            } finally {
                t = null
            }
        }

        function st(e, t, n, r) {
            var i, o, a, s, u, l, f, g, m, v;
            if ((t ? t.ownerDocument || t : w) !== p && c(t), t = t || p, n = n || [], !e || "string" != typeof e) return n;
            if (1 !== (s = t.nodeType) && 9 !== s) return [];
            if (!d && !r) {
                if (i = J.exec(e)) if (a = i[1]) {
                    if (9 === s) {
                        if (o = t.getElementById(a), !o || !o.parentNode) return n;
                        if (o.id === a) return n.push(o), n
                    } else if (t.ownerDocument && (o = t.ownerDocument.getElementById(a)) && y(t, o) && o.id === a) return n.push(o), n
                } else {
                    if (i[2]) return H.apply(n, q.call(t.getElementsByTagName(e), 0)), n;
                    if ((a = i[3]) && T.getByClassName && t.getElementsByClassName) return H.apply(n, q.call(t.getElementsByClassName(a), 0)), n
                }
                if (T.qsa && !h.test(e)) {
                    if (f = !0, g = x, m = t, v = 9 === s && e, 1 === s && "object" !== t.nodeName.toLowerCase()) {
                        l = ft(e), (f = t.getAttribute("id")) ? g = f.replace(K, "\\$&") : t.setAttribute("id", g), g = "[id='" + g + "'] ", u = l.length;
                        while (u--) l[u] = g + dt(l[u]);
                        m = V.test(e) && t.parentNode || t, v = l.join(",")
                    }
                    if (v) try {
                        return H.apply(n, q.call(m.querySelectorAll(v), 0)), n
                    } catch (b) {
                    } finally {
                        f || t.removeAttribute("id")
                    }
                }
            }
            return wt(e.replace(W, "$1"), t, n, r)
        }

        a = st.isXML = function (e) {
            var t = e && (e.ownerDocument || e).documentElement;
            return t ? "HTML" !== t.nodeName : !1
        }, c = st.setDocument = function (e) {
            var n = e ? e.ownerDocument || e : w;
            return n !== p && 9 === n.nodeType && n.documentElement ? (p = n, f = n.documentElement, d = a(n), T.tagNameNoComments = at(function (e) {
                return e.appendChild(n.createComment("")), !e.getElementsByTagName("*").length
            }), T.attributes = at(function (e) {
                e.innerHTML = "<select></select>";
                var t = typeof e.lastChild.getAttribute("multiple");
                return "boolean" !== t && "string" !== t
            }), T.getByClassName = at(function (e) {
                return e.innerHTML = "<div class='hidden e'></div><div class='hidden'></div>", e.getElementsByClassName && e.getElementsByClassName("e").length ? (e.lastChild.className = "e", 2 === e.getElementsByClassName("e").length) : !1
            }), T.getByName = at(function (e) {
                e.id = x + 0, e.innerHTML = "<a name='" + x + "'></a><div name='" + x + "'></div>", f.insertBefore(e, f.firstChild);
                var t = n.getElementsByName && n.getElementsByName(x).length === 2 + n.getElementsByName(x + 0).length;
                return T.getIdNotName = !n.getElementById(x), f.removeChild(e), t
            }), i.attrHandle = at(function (e) {
                return e.innerHTML = "<a href='#'></a>", e.firstChild && typeof e.firstChild.getAttribute !== A && "#" === e.firstChild.getAttribute("href")
            }) ? {} : {
                href: function (e) {
                    return e.getAttribute("href", 2)
                }, type: function (e) {
                    return e.getAttribute("type")
                }
            }, T.getIdNotName ? (i.find.ID = function (e, t) {
                if (typeof t.getElementById !== A && !d) {
                    var n = t.getElementById(e);
                    return n && n.parentNode ? [n] : []
                }
            }, i.filter.ID = function (e) {
                var t = e.replace(et, tt);
                return function (e) {
                    return e.getAttribute("id") === t
                }
            }) : (i.find.ID = function (e, n) {
                if (typeof n.getElementById !== A && !d) {
                    var r = n.getElementById(e);
                    return r ? r.id === e || typeof r.getAttributeNode !== A && r.getAttributeNode("id").value === e ? [r] : t : []
                }
            }, i.filter.ID = function (e) {
                var t = e.replace(et, tt);
                return function (e) {
                    var n = typeof e.getAttributeNode !== A && e.getAttributeNode("id");
                    return n && n.value === t
                }
            }), i.find.TAG = T.tagNameNoComments ? function (e, n) {
                return typeof n.getElementsByTagName !== A ? n.getElementsByTagName(e) : t
            } : function (e, t) {
                var n, r = [], i = 0, o = t.getElementsByTagName(e);
                if ("*" === e) {
                    while (n = o[i++]) 1 === n.nodeType && r.push(n);
                    return r
                }
                return o
            }, i.find.NAME = T.getByName && function (e, n) {
                return typeof n.getElementsByName !== A ? n.getElementsByName(name) : t
            }, i.find.CLASS = T.getByClassName && function (e, n) {
                return typeof n.getElementsByClassName === A || d ? t : n.getElementsByClassName(e)
            }, g = [], h = [":focus"], (T.qsa = rt(n.querySelectorAll)) && (at(function (e) {
                e.innerHTML = "<select><option selected=''></option></select>", e.querySelectorAll("[selected]").length || h.push("\\[" + _ + "*(?:checked|disabled|ismap|multiple|readonly|selected|value)"), e.querySelectorAll(":checked").length || h.push(":checked")
            }), at(function (e) {
                e.innerHTML = "<input type='hidden' i=''/>", e.querySelectorAll("[i^='']").length && h.push("[*^$]=" + _ + "*(?:\"\"|'')"), e.querySelectorAll(":enabled").length || h.push(":enabled", ":disabled"), e.querySelectorAll("*,:x"), h.push(",.*:")
            })), (T.matchesSelector = rt(m = f.matchesSelector || f.mozMatchesSelector || f.webkitMatchesSelector || f.oMatchesSelector || f.msMatchesSelector)) && at(function (e) {
                T.disconnectedMatch = m.call(e, "div"), m.call(e, "[s!='']:x"), g.push("!=", R)
            }), h = RegExp(h.join("|")), g = RegExp(g.join("|")), y = rt(f.contains) || f.compareDocumentPosition ? function (e, t) {
                var n = 9 === e.nodeType ? e.documentElement : e, r = t && t.parentNode;
                return e === r || !(!r || 1 !== r.nodeType || !(n.contains ? n.contains(r) : e.compareDocumentPosition && 16 & e.compareDocumentPosition(r)))
            } : function (e, t) {
                if (t) while (t = t.parentNode) if (t === e) return !0;
                return !1
            }, v = f.compareDocumentPosition ? function (e, t) {
                var r;
                return e === t ? (u = !0, 0) : (r = t.compareDocumentPosition && e.compareDocumentPosition && e.compareDocumentPosition(t)) ? 1 & r || e.parentNode && 11 === e.parentNode.nodeType ? e === n || y(w, e) ? -1 : t === n || y(w, t) ? 1 : 0 : 4 & r ? -1 : 1 : e.compareDocumentPosition ? -1 : 1
            } : function (e, t) {
                var r, i = 0, o = e.parentNode, a = t.parentNode, s = [e], l = [t];
                if (e === t) return u = !0, 0;
                if (!o || !a) return e === n ? -1 : t === n ? 1 : o ? -1 : a ? 1 : 0;
                if (o === a) return ut(e, t);
                r = e;
                while (r = r.parentNode) s.unshift(r);
                r = t;
                while (r = r.parentNode) l.unshift(r);
                while (s[i] === l[i]) i++;
                return i ? ut(s[i], l[i]) : s[i] === w ? -1 : l[i] === w ? 1 : 0
            }, u = !1, [0, 0].sort(v), T.detectDuplicates = u, p) : p
        }, st.matches = function (e, t) {
            return st(e, null, null, t)
        }, st.matchesSelector = function (e, t) {
            if ((e.ownerDocument || e) !== p && c(e), t = t.replace(Z, "='$1']"), !(!T.matchesSelector || d || g && g.test(t) || h.test(t))) try {
                var n = m.call(e, t);
                if (n || T.disconnectedMatch || e.document && 11 !== e.document.nodeType) return n
            } catch (r) {
            }
            return st(t, p, null, [e]).length > 0
        }, st.contains = function (e, t) {
            return (e.ownerDocument || e) !== p && c(e), y(e, t)
        }, st.attr = function (e, t) {
            var n;
            return (e.ownerDocument || e) !== p && c(e), d || (t = t.toLowerCase()), (n = i.attrHandle[t]) ? n(e) : d || T.attributes ? e.getAttribute(t) : ((n = e.getAttributeNode(t)) || e.getAttribute(t)) && e[t] === !0 ? t : n && n.specified ? n.value : null
        }, st.error = function (e) {
            throw Error("Syntax error, unrecognized expression: " + e)
        }, st.uniqueSort = function (e) {
            var t, n = [], r = 1, i = 0;
            if (u = !T.detectDuplicates, e.sort(v), u) {
                for (; t = e[r]; r++) t === e[r - 1] && (i = n.push(r));
                while (i--) e.splice(n[i], 1)
            }
            return e
        };

        function ut(e, t) {
            var n = t && e, r = n && (~t.sourceIndex || j) - (~e.sourceIndex || j);
            if (r) return r;
            if (n) while (n = n.nextSibling) if (n === t) return -1;
            return e ? 1 : -1
        }

        function lt(e) {
            return function (t) {
                var n = t.nodeName.toLowerCase();
                return "input" === n && t.type === e
            }
        }

        function ct(e) {
            return function (t) {
                var n = t.nodeName.toLowerCase();
                return ("input" === n || "button" === n) && t.type === e
            }
        }

        function pt(e) {
            return ot(function (t) {
                return t = +t, ot(function (n, r) {
                    var i, o = e([], n.length, t), a = o.length;
                    while (a--) n[i = o[a]] && (n[i] = !(r[i] = n[i]))
                })
            })
        }

        o = st.getText = function (e) {
            var t, n = "", r = 0, i = e.nodeType;
            if (i) {
                if (1 === i || 9 === i || 11 === i) {
                    if ("string" == typeof e.textContent) return e.textContent;
                    for (e = e.firstChild; e; e = e.nextSibling) n += o(e)
                } else if (3 === i || 4 === i) return e.nodeValue
            } else for (; t = e[r]; r++) n += o(t);
            return n
        }, i = st.selectors = {
            cacheLength: 50,
            createPseudo: ot,
            match: U,
            find: {},
            relative: {
                ">": {dir: "parentNode", first: !0},
                " ": {dir: "parentNode"},
                "+": {dir: "previousSibling", first: !0},
                "~": {dir: "previousSibling"}
            },
            preFilter: {
                ATTR: function (e) {
                    return e[1] = e[1].replace(et, tt), e[3] = (e[4] || e[5] || "").replace(et, tt), "~=" === e[2] && (e[3] = " " + e[3] + " "), e.slice(0, 4)
                }, CHILD: function (e) {
                    return e[1] = e[1].toLowerCase(), "nth" === e[1].slice(0, 3) ? (e[3] || st.error(e[0]), e[4] = +(e[4] ? e[5] + (e[6] || 1) : 2 * ("even" === e[3] || "odd" === e[3])), e[5] = +(e[7] + e[8] || "odd" === e[3])) : e[3] && st.error(e[0]), e
                }, PSEUDO: function (e) {
                    var t, n = !e[5] && e[2];
                    return U.CHILD.test(e[0]) ? null : (e[4] ? e[2] = e[4] : n && z.test(n) && (t = ft(n, !0)) && (t = n.indexOf(")", n.length - t) - n.length) && (e[0] = e[0].slice(0, t), e[2] = n.slice(0, t)), e.slice(0, 3))
                }
            },
            filter: {
                TAG: function (e) {
                    return "*" === e ? function () {
                        return !0
                    } : (e = e.replace(et, tt).toLowerCase(), function (t) {
                        return t.nodeName && t.nodeName.toLowerCase() === e
                    })
                }, CLASS: function (e) {
                    var t = k[e + " "];
                    return t || (t = RegExp("(^|" + _ + ")" + e + "(" + _ + "|$)")) && k(e, function (e) {
                        return t.test(e.className || typeof e.getAttribute !== A && e.getAttribute("class") || "")
                    })
                }, ATTR: function (e, t, n) {
                    return function (r) {
                        var i = st.attr(r, e);
                        return null == i ? "!=" === t : t ? (i += "", "=" === t ? i === n : "!=" === t ? i !== n : "^=" === t ? n && 0 === i.indexOf(n) : "*=" === t ? n && i.indexOf(n) > -1 : "$=" === t ? n && i.slice(-n.length) === n : "~=" === t ? (" " + i + " ").indexOf(n) > -1 : "|=" === t ? i === n || i.slice(0, n.length + 1) === n + "-" : !1) : !0
                    }
                }, CHILD: function (e, t, n, r, i) {
                    var o = "nth" !== e.slice(0, 3), a = "last" !== e.slice(-4), s = "of-type" === t;
                    return 1 === r && 0 === i ? function (e) {
                        return !!e.parentNode
                    } : function (t, n, u) {
                        var l, c, p, f, d, h, g = o !== a ? "nextSibling" : "previousSibling", m = t.parentNode,
                            y = s && t.nodeName.toLowerCase(), v = !u && !s;
                        if (m) {
                            if (o) {
                                while (g) {
                                    p = t;
                                    while (p = p[g]) if (s ? p.nodeName.toLowerCase() === y : 1 === p.nodeType) return !1;
                                    h = g = "only" === e && !h && "nextSibling"
                                }
                                return !0
                            }
                            if (h = [a ? m.firstChild : m.lastChild], a && v) {
                                c = m[x] || (m[x] = {}), l = c[e] || [], d = l[0] === N && l[1], f = l[0] === N && l[2], p = d && m.childNodes[d];
                                while (p = ++d && p && p[g] || (f = d = 0) || h.pop()) if (1 === p.nodeType && ++f && p === t) {
                                    c[e] = [N, d, f];
                                    break
                                }
                            } else if (v && (l = (t[x] || (t[x] = {}))[e]) && l[0] === N) f = l[1]; else while (p = ++d && p && p[g] || (f = d = 0) || h.pop()) if ((s ? p.nodeName.toLowerCase() === y : 1 === p.nodeType) && ++f && (v && ((p[x] || (p[x] = {}))[e] = [N, f]), p === t)) break;
                            return f -= i, f === r || 0 === f % r && f / r >= 0
                        }
                    }
                }, PSEUDO: function (e, t) {
                    var n, r = i.pseudos[e] || i.setFilters[e.toLowerCase()] || st.error("unsupported pseudo: " + e);
                    return r[x] ? r(t) : r.length > 1 ? (n = [e, e, "", t], i.setFilters.hasOwnProperty(e.toLowerCase()) ? ot(function (e, n) {
                        var i, o = r(e, t), a = o.length;
                        while (a--) i = M.call(e, o[a]), e[i] = !(n[i] = o[a])
                    }) : function (e) {
                        return r(e, 0, n)
                    }) : r
                }
            },
            pseudos: {
                not: ot(function (e) {
                    var t = [], n = [], r = s(e.replace(W, "$1"));
                    return r[x] ? ot(function (e, t, n, i) {
                        var o, a = r(e, null, i, []), s = e.length;
                        while (s--) (o = a[s]) && (e[s] = !(t[s] = o))
                    }) : function (e, i, o) {
                        return t[0] = e, r(t, null, o, n), !n.pop()
                    }
                }), has: ot(function (e) {
                    return function (t) {
                        return st(e, t).length > 0
                    }
                }), contains: ot(function (e) {
                    return function (t) {
                        return (t.textContent || t.innerText || o(t)).indexOf(e) > -1
                    }
                }), lang: ot(function (e) {
                    return X.test(e || "") || st.error("unsupported lang: " + e), e = e.replace(et, tt).toLowerCase(), function (t) {
                        var n;
                        do if (n = d ? t.getAttribute("xml:lang") || t.getAttribute("lang") : t.lang) return n = n.toLowerCase(), n === e || 0 === n.indexOf(e + "-"); while ((t = t.parentNode) && 1 === t.nodeType);
                        return !1
                    }
                }), target: function (t) {
                    var n = e.location && e.location.hash;
                    return n && n.slice(1) === t.id
                }, root: function (e) {
                    return e === f
                }, focus: function (e) {
                    return e === p.activeElement && (!p.hasFocus || p.hasFocus()) && !!(e.type || e.href || ~e.tabIndex)
                }, enabled: function (e) {
                    return e.disabled === !1
                }, disabled: function (e) {
                    return e.disabled === !0
                }, checked: function (e) {
                    var t = e.nodeName.toLowerCase();
                    return "input" === t && !!e.checked || "option" === t && !!e.selected
                }, selected: function (e) {
                    return e.parentNode && e.parentNode.selectedIndex, e.selected === !0
                }, empty: function (e) {
                    for (e = e.firstChild; e; e = e.nextSibling) if (e.nodeName > "@" || 3 === e.nodeType || 4 === e.nodeType) return !1;
                    return !0
                }, parent: function (e) {
                    return !i.pseudos.empty(e)
                }, header: function (e) {
                    return Q.test(e.nodeName)
                }, input: function (e) {
                    return G.test(e.nodeName)
                }, button: function (e) {
                    var t = e.nodeName.toLowerCase();
                    return "input" === t && "button" === e.type || "button" === t
                }, text: function (e) {
                    var t;
                    return "input" === e.nodeName.toLowerCase() && "text" === e.type && (null == (t = e.getAttribute("type")) || t.toLowerCase() === e.type)
                }, first: pt(function () {
                    return [0]
                }), last: pt(function (e, t) {
                    return [t - 1]
                }), eq: pt(function (e, t, n) {
                    return [0 > n ? n + t : n]
                }), even: pt(function (e, t) {
                    var n = 0;
                    for (; t > n; n += 2) e.push(n);
                    return e
                }), odd: pt(function (e, t) {
                    var n = 1;
                    for (; t > n; n += 2) e.push(n);
                    return e
                }), lt: pt(function (e, t, n) {
                    var r = 0 > n ? n + t : n;
                    for (; --r >= 0;) e.push(r);
                    return e
                }), gt: pt(function (e, t, n) {
                    var r = 0 > n ? n + t : n;
                    for (; t > ++r;) e.push(r);
                    return e
                })
            }
        };
        for (n in {radio: !0, checkbox: !0, file: !0, password: !0, image: !0}) i.pseudos[n] = lt(n);
        for (n in {submit: !0, reset: !0}) i.pseudos[n] = ct(n);

        function ft(e, t) {
            var n, r, o, a, s, u, l, c = E[e + " "];
            if (c) return t ? 0 : c.slice(0);
            s = e, u = [], l = i.preFilter;
            while (s) {
                (!n || (r = $.exec(s))) && (r && (s = s.slice(r[0].length) || s), u.push(o = [])), n = !1, (r = I.exec(s)) && (n = r.shift(), o.push({
                    value: n,
                    type: r[0].replace(W, " ")
                }), s = s.slice(n.length));
                for (a in i.filter) !(r = U[a].exec(s)) || l[a] && !(r = l[a](r)) || (n = r.shift(), o.push({
                    value: n,
                    type: a,
                    matches: r
                }), s = s.slice(n.length));
                if (!n) break
            }
            return t ? s.length : s ? st.error(e) : E(e, u).slice(0)
        }

        function dt(e) {
            var t = 0, n = e.length, r = "";
            for (; n > t; t++) r += e[t].value;
            return r
        }

        function ht(e, t, n) {
            var i = t.dir, o = n && "parentNode" === i, a = C++;
            return t.first ? function (t, n, r) {
                while (t = t[i]) if (1 === t.nodeType || o) return e(t, n, r)
            } : function (t, n, s) {
                var u, l, c, p = N + " " + a;
                if (s) {
                    while (t = t[i]) if ((1 === t.nodeType || o) && e(t, n, s)) return !0
                } else while (t = t[i]) if (1 === t.nodeType || o) if (c = t[x] || (t[x] = {}), (l = c[i]) && l[0] === p) {
                    if ((u = l[1]) === !0 || u === r) return u === !0
                } else if (l = c[i] = [p], l[1] = e(t, n, s) || r, l[1] === !0) return !0
            }
        }

        function gt(e) {
            return e.length > 1 ? function (t, n, r) {
                var i = e.length;
                while (i--) if (!e[i](t, n, r)) return !1;
                return !0
            } : e[0]
        }

        function mt(e, t, n, r, i) {
            var o, a = [], s = 0, u = e.length, l = null != t;
            for (; u > s; s++) (o = e[s]) && (!n || n(o, r, i)) && (a.push(o), l && t.push(s));
            return a
        }

        function yt(e, t, n, r, i, o) {
            return r && !r[x] && (r = yt(r)), i && !i[x] && (i = yt(i, o)), ot(function (o, a, s, u) {
                var l, c, p, f = [], d = [], h = a.length, g = o || xt(t || "*", s.nodeType ? [s] : s, []),
                    m = !e || !o && t ? g : mt(g, f, e, s, u), y = n ? i || (o ? e : h || r) ? [] : a : m;
                if (n && n(m, y, s, u), r) {
                    l = mt(y, d), r(l, [], s, u), c = l.length;
                    while (c--) (p = l[c]) && (y[d[c]] = !(m[d[c]] = p))
                }
                if (o) {
                    if (i || e) {
                        if (i) {
                            l = [], c = y.length;
                            while (c--) (p = y[c]) && l.push(m[c] = p);
                            i(null, y = [], l, u)
                        }
                        c = y.length;
                        while (c--) (p = y[c]) && (l = i ? M.call(o, p) : f[c]) > -1 && (o[l] = !(a[l] = p))
                    }
                } else y = mt(y === a ? y.splice(h, y.length) : y), i ? i(null, a, y, u) : H.apply(a, y)
            })
        }

        function vt(e) {
            var t, n, r, o = e.length, a = i.relative[e[0].type], s = a || i.relative[" "], u = a ? 1 : 0,
                c = ht(function (e) {
                    return e === t
                }, s, !0), p = ht(function (e) {
                    return M.call(t, e) > -1
                }, s, !0), f = [function (e, n, r) {
                    return !a && (r || n !== l) || ((t = n).nodeType ? c(e, n, r) : p(e, n, r))
                }];
            for (; o > u; u++) if (n = i.relative[e[u].type]) f = [ht(gt(f), n)]; else {
                if (n = i.filter[e[u].type].apply(null, e[u].matches), n[x]) {
                    for (r = ++u; o > r; r++) if (i.relative[e[r].type]) break;
                    return yt(u > 1 && gt(f), u > 1 && dt(e.slice(0, u - 1)).replace(W, "$1"), n, r > u && vt(e.slice(u, r)), o > r && vt(e = e.slice(r)), o > r && dt(e))
                }
                f.push(n)
            }
            return gt(f)
        }

        function bt(e, t) {
            var n = 0, o = t.length > 0, a = e.length > 0, s = function (s, u, c, f, d) {
                var h, g, m, y = [], v = 0, b = "0", x = s && [], w = null != d, T = l,
                    C = s || a && i.find.TAG("*", d && u.parentNode || u), k = N += null == T ? 1 : Math.random() || .1;
                for (w && (l = u !== p && u, r = n); null != (h = C[b]); b++) {
                    if (a && h) {
                        g = 0;
                        while (m = e[g++]) if (m(h, u, c)) {
                            f.push(h);
                            break
                        }
                        w && (N = k, r = ++n)
                    }
                    o && ((h = !m && h) && v--, s && x.push(h))
                }
                if (v += b, o && b !== v) {
                    g = 0;
                    while (m = t[g++]) m(x, y, u, c);
                    if (s) {
                        if (v > 0) while (b--) x[b] || y[b] || (y[b] = L.call(f));
                        y = mt(y)
                    }
                    H.apply(f, y), w && !s && y.length > 0 && v + t.length > 1 && st.uniqueSort(f)
                }
                return w && (N = k, l = T), x
            };
            return o ? ot(s) : s
        }

        s = st.compile = function (e, t) {
            var n, r = [], i = [], o = S[e + " "];
            if (!o) {
                t || (t = ft(e)), n = t.length;
                while (n--) o = vt(t[n]), o[x] ? r.push(o) : i.push(o);
                o = S(e, bt(i, r))
            }
            return o
        };

        function xt(e, t, n) {
            var r = 0, i = t.length;
            for (; i > r; r++) st(e, t[r], n);
            return n
        }

        function wt(e, t, n, r) {
            var o, a, u, l, c, p = ft(e);
            if (!r && 1 === p.length) {
                if (a = p[0] = p[0].slice(0), a.length > 2 && "ID" === (u = a[0]).type && 9 === t.nodeType && !d && i.relative[a[1].type]) {
                    if (t = i.find.ID(u.matches[0].replace(et, tt), t)[0], !t) return n;
                    e = e.slice(a.shift().value.length)
                }
                o = U.needsContext.test(e) ? 0 : a.length;
                while (o--) {
                    if (u = a[o], i.relative[l = u.type]) break;
                    if ((c = i.find[l]) && (r = c(u.matches[0].replace(et, tt), V.test(a[0].type) && t.parentNode || t))) {
                        if (a.splice(o, 1), e = r.length && dt(a), !e) return H.apply(n, q.call(r, 0)), n;
                        break
                    }
                }
            }
            return s(e, p)(r, t, d, n, V.test(e)), n
        }

        i.pseudos.nth = i.pseudos.eq;

        function Tt() {
        }

        i.filters = Tt.prototype = i.pseudos, i.setFilters = new Tt, c(), st.attr = b.attr, b.find = st, b.expr = st.selectors, b.expr[":"] = b.expr.pseudos, b.unique = st.uniqueSort, b.text = st.getText, b.isXMLDoc = st.isXML, b.contains = st.contains
    }(e);
    var at = /Until$/, st = /^(?:parents|prev(?:Until|All))/, ut = /^.[^:#\[\.,]*$/, lt = b.expr.match.needsContext,
        ct = {children: !0, contents: !0, next: !0, prev: !0};
    b.fn.extend({
        find: function (e) {
            var t, n, r, i = this.length;
            if ("string" != typeof e) return r = this, this.pushStack(b(e).filter(function () {
                for (t = 0; i > t; t++) if (b.contains(r[t], this)) return !0
            }));
            for (n = [], t = 0; i > t; t++) b.find(e, this[t], n);
            return n = this.pushStack(i > 1 ? b.unique(n) : n), n.selector = (this.selector ? this.selector + " " : "") + e, n
        }, has: function (e) {
            var t, n = b(e, this), r = n.length;
            return this.filter(function () {
                for (t = 0; r > t; t++) if (b.contains(this, n[t])) return !0
            })
        }, not: function (e) {
            return this.pushStack(ft(this, e, !1))
        }, filter: function (e) {
            return this.pushStack(ft(this, e, !0))
        }, is: function (e) {
            return !!e && ("string" == typeof e ? lt.test(e) ? b(e, this.context).index(this[0]) >= 0 : b.filter(e, this).length > 0 : this.filter(e).length > 0)
        }, closest: function (e, t) {
            var n, r = 0, i = this.length, o = [], a = lt.test(e) || "string" != typeof e ? b(e, t || this.context) : 0;
            for (; i > r; r++) {
                n = this[r];
                while (n && n.ownerDocument && n !== t && 11 !== n.nodeType) {
                    if (a ? a.index(n) > -1 : b.find.matchesSelector(n, e)) {
                        o.push(n);
                        break
                    }
                    n = n.parentNode
                }
            }
            return this.pushStack(o.length > 1 ? b.unique(o) : o)
        }, index: function (e) {
            return e ? "string" == typeof e ? b.inArray(this[0], b(e)) : b.inArray(e.jquery ? e[0] : e, this) : this[0] && this[0].parentNode ? this.first().prevAll().length : -1
        }, add: function (e, t) {
            var n = "string" == typeof e ? b(e, t) : b.makeArray(e && e.nodeType ? [e] : e), r = b.merge(this.get(), n);
            return this.pushStack(b.unique(r))
        }, addBack: function (e) {
            return this.add(null == e ? this.prevObject : this.prevObject.filter(e))
        }
    }), b.fn.andSelf = b.fn.addBack;

    function pt(e, t) {
        do e = e[t]; while (e && 1 !== e.nodeType);
        return e
    }

    b.each({
        parent: function (e) {
            var t = e.parentNode;
            return t && 11 !== t.nodeType ? t : null
        }, parents: function (e) {
            return b.dir(e, "parentNode")
        }, parentsUntil: function (e, t, n) {
            return b.dir(e, "parentNode", n)
        }, next: function (e) {
            return pt(e, "nextSibling")
        }, prev: function (e) {
            return pt(e, "previousSibling")
        }, nextAll: function (e) {
            return b.dir(e, "nextSibling")
        }, prevAll: function (e) {
            return b.dir(e, "previousSibling")
        }, nextUntil: function (e, t, n) {
            return b.dir(e, "nextSibling", n)
        }, prevUntil: function (e, t, n) {
            return b.dir(e, "previousSibling", n)
        }, siblings: function (e) {
            return b.sibling((e.parentNode || {}).firstChild, e)
        }, children: function (e) {
            return b.sibling(e.firstChild)
        }, contents: function (e) {
            return b.nodeName(e, "iframe") ? e.contentDocument || e.contentWindow.document : b.merge([], e.childNodes)
        }
    }, function (e, t) {
        b.fn[e] = function (n, r) {
            var i = b.map(this, t, n);
            return at.test(e) || (r = n), r && "string" == typeof r && (i = b.filter(r, i)), i = this.length > 1 && !ct[e] ? b.unique(i) : i, this.length > 1 && st.test(e) && (i = i.reverse()), this.pushStack(i)
        }
    }), b.extend({
        filter: function (e, t, n) {
            return n && (e = ":not(" + e + ")"), 1 === t.length ? b.find.matchesSelector(t[0], e) ? [t[0]] : [] : b.find.matches(e, t)
        }, dir: function (e, n, r) {
            var i = [], o = e[n];
            while (o && 9 !== o.nodeType && (r === t || 1 !== o.nodeType || !b(o).is(r))) 1 === o.nodeType && i.push(o), o = o[n];
            return i
        }, sibling: function (e, t) {
            var n = [];
            for (; e; e = e.nextSibling) 1 === e.nodeType && e !== t && n.push(e);
            return n
        }
    });

    function ft(e, t, n) {
        if (t = t || 0, b.isFunction(t)) return b.grep(e, function (e, r) {
            var i = !!t.call(e, r, e);
            return i === n
        });
        if (t.nodeType) return b.grep(e, function (e) {
            return e === t === n
        });
        if ("string" == typeof t) {
            var r = b.grep(e, function (e) {
                return 1 === e.nodeType
            });
            if (ut.test(t)) return b.filter(t, r, !n);
            t = b.filter(t, r)
        }
        return b.grep(e, function (e) {
            return b.inArray(e, t) >= 0 === n
        })
    }

    function dt(e) {
        var t = ht.split("|"), n = e.createDocumentFragment();
        if (n.createElement) while (t.length) n.createElement(t.pop());
        return n
    }

    var ht = "abbr|article|aside|audio|bdi|canvas|data|datalist|details|figcaption|figure|footer|header|hgroup|mark|meter|nav|output|progress|section|summary|time|video",
        gt = / jQuery\d+="(?:null|\d+)"/g, mt = RegExp("<(?:" + ht + ")[\\s/>]", "i"), yt = /^\s+/,
        vt = /<(?!area|br|col|embed|hr|img|input|link|meta|param)(([\w:]+)[^>]*)\/>/gi, bt = /<([\w:]+)/,
        xt = /<tbody/i, wt = /<|&#?\w+;/, Tt = /<(?:script|style|link)/i, Nt = /^(?:checkbox|radio)$/i,
        Ct = /checked\s*(?:[^=]|=\s*.checked.)/i, kt = /^$|\/(?:java|ecma)script/i, Et = /^true\/(.*)/,
        St = /^\s*<!(?:\[CDATA\[|--)|(?:\]\]|--)>\s*$/g, At = {
            option: [1, "<select multiple='multiple'>", "</select>"],
            legend: [1, "<fieldset>", "</fieldset>"],
            area: [1, "<map>", "</map>"],
            param: [1, "<object>", "</object>"],
            thead: [1, "<table>", "</table>"],
            tr: [2, "<table><tbody>", "</tbody></table>"],
            col: [2, "<table><tbody></tbody><colgroup>", "</colgroup></table>"],
            td: [3, "<table><tbody><tr>", "</tr></tbody></table>"],
            _default: b.support.htmlSerialize ? [0, "", ""] : [1, "X<div>", "</div>"]
        }, jt = dt(o), Dt = jt.appendChild(o.createElement("div"));
    At.optgroup = At.option, At.tbody = At.tfoot = At.colgroup = At.caption = At.thead, At.th = At.td, b.fn.extend({
        text: function (e) {
            return b.access(this, function (e) {
                return e === t ? b.text(this) : this.empty().append((this[0] && this[0].ownerDocument || o).createTextNode(e))
            }, null, e, arguments.length)
        }, wrapAll: function (e) {
            if (b.isFunction(e)) return this.each(function (t) {
                b(this).wrapAll(e.call(this, t))
            });
            if (this[0]) {
                var t = b(e, this[0].ownerDocument).eq(0).clone(!0);
                this[0].parentNode && t.insertBefore(this[0]), t.map(function () {
                    var e = this;
                    while (e.firstChild && 1 === e.firstChild.nodeType) e = e.firstChild;
                    return e
                }).append(this)
            }
            return this
        }, wrapInner: function (e) {
            return b.isFunction(e) ? this.each(function (t) {
                b(this).wrapInner(e.call(this, t))
            }) : this.each(function () {
                var t = b(this), n = t.contents();
                n.length ? n.wrapAll(e) : t.append(e)
            })
        }, wrap: function (e) {
            var t = b.isFunction(e);
            return this.each(function (n) {
                b(this).wrapAll(t ? e.call(this, n) : e)
            })
        }, unwrap: function () {
            return this.parent().each(function () {
                b.nodeName(this, "body") || b(this).replaceWith(this.childNodes)
            }).end()
        }, append: function () {
            return this.domManip(arguments, !0, function (e) {
                (1 === this.nodeType || 11 === this.nodeType || 9 === this.nodeType) && this.appendChild(e)
            })
        }, prepend: function () {
            return this.domManip(arguments, !0, function (e) {
                (1 === this.nodeType || 11 === this.nodeType || 9 === this.nodeType) && this.insertBefore(e, this.firstChild)
            })
        }, before: function () {
            return this.domManip(arguments, !1, function (e) {
                this.parentNode && this.parentNode.insertBefore(e, this)
            })
        }, after: function () {
            return this.domManip(arguments, !1, function (e) {
                this.parentNode && this.parentNode.insertBefore(e, this.nextSibling)
            })
        }, remove: function (e, t) {
            var n, r = 0;
            for (; null != (n = this[r]); r++) (!e || b.filter(e, [n]).length > 0) && (t || 1 !== n.nodeType || b.cleanData(Ot(n)), n.parentNode && (t && b.contains(n.ownerDocument, n) && Mt(Ot(n, "script")), n.parentNode.removeChild(n)));
            return this
        }, empty: function () {
            var e, t = 0;
            for (; null != (e = this[t]); t++) {
                1 === e.nodeType && b.cleanData(Ot(e, !1));
                while (e.firstChild) e.removeChild(e.firstChild);
                e.options && b.nodeName(e, "select") && (e.options.length = 0)
            }
            return this
        }, clone: function (e, t) {
            return e = null == e ? !1 : e, t = null == t ? e : t, this.map(function () {
                return b.clone(this, e, t)
            })
        }, html: function (e) {
            return b.access(this, function (e) {
                var n = this[0] || {}, r = 0, i = this.length;
                if (e === t) return 1 === n.nodeType ? n.innerHTML.replace(gt, "") : t;
                if (!("string" != typeof e || Tt.test(e) || !b.support.htmlSerialize && mt.test(e) || !b.support.leadingWhitespace && yt.test(e) || At[(bt.exec(e) || ["", ""])[1].toLowerCase()])) {
                    e = e.replace(vt, "<$1></$2>");
                    try {
                        for (; i > r; r++) n = this[r] || {}, 1 === n.nodeType && (b.cleanData(Ot(n, !1)), n.innerHTML = e);
                        n = 0
                    } catch (o) {
                    }
                }
                n && this.empty().append(e)
            }, null, e, arguments.length)
        }, replaceWith: function (e) {
            var t = b.isFunction(e);
            return t || "string" == typeof e || (e = b(e).not(this).detach()), this.domManip([e], !0, function (e) {
                var t = this.nextSibling, n = this.parentNode;
                n && (b(this).remove(), n.insertBefore(e, t))
            })
        }, detach: function (e) {
            return this.remove(e, !0)
        }, domManip: function (e, n, r) {
            e = f.apply([], e);
            var i, o, a, s, u, l, c = 0, p = this.length, d = this, h = p - 1, g = e[0], m = b.isFunction(g);
            if (m || !(1 >= p || "string" != typeof g || b.support.checkClone) && Ct.test(g)) return this.each(function (i) {
                var o = d.eq(i);
                m && (e[0] = g.call(this, i, n ? o.html() : t)), o.domManip(e, n, r)
            });
            if (p && (l = b.buildFragment(e, this[0].ownerDocument, !1, this), i = l.firstChild, 1 === l.childNodes.length && (l = i), i)) {
                for (n = n && b.nodeName(i, "tr"), s = b.map(Ot(l, "script"), Ht), a = s.length; p > c; c++) o = l, c !== h && (o = b.clone(o, !0, !0), a && b.merge(s, Ot(o, "script"))), r.call(n && b.nodeName(this[c], "table") ? Lt(this[c], "tbody") : this[c], o, c);
                if (a) for (u = s[s.length - 1].ownerDocument, b.map(s, qt), c = 0; a > c; c++) o = s[c], kt.test(o.type || "") && !b._data(o, "globalEval") && b.contains(u, o) && (o.src ? b.ajax({
                    url: o.src,
                    type: "GET",
                    dataType: "script",
                    async: !1,
                    global: !1,
                    "throws": !0
                }) : b.globalEval((o.text || o.textContent || o.innerHTML || "").replace(St, "")));
                l = i = null
            }
            return this
        }
    });

    function Lt(e, t) {
        return e.getElementsByTagName(t)[0] || e.appendChild(e.ownerDocument.createElement(t))
    }

    function Ht(e) {
        var t = e.getAttributeNode("type");
        return e.type = (t && t.specified) + "/" + e.type, e
    }

    function qt(e) {
        var t = Et.exec(e.type);
        return t ? e.type = t[1] : e.removeAttribute("type"), e
    }

    function Mt(e, t) {
        var n, r = 0;
        for (; null != (n = e[r]); r++) b._data(n, "globalEval", !t || b._data(t[r], "globalEval"))
    }

    function _t(e, t) {
        if (1 === t.nodeType && b.hasData(e)) {
            var n, r, i, o = b._data(e), a = b._data(t, o), s = o.events;
            if (s) {
                delete a.handle, a.events = {};
                for (n in s) for (r = 0, i = s[n].length; i > r; r++) b.event.add(t, n, s[n][r])
            }
            a.data && (a.data = b.extend({}, a.data))
        }
    }

    function Ft(e, t) {
        var n, r, i;
        if (1 === t.nodeType) {
            if (n = t.nodeName.toLowerCase(), !b.support.noCloneEvent && t[b.expando]) {
                i = b._data(t);
                for (r in i.events) b.removeEvent(t, r, i.handle);
                t.removeAttribute(b.expando)
            }
            "script" === n && t.text !== e.text ? (Ht(t).text = e.text, qt(t)) : "object" === n ? (t.parentNode && (t.outerHTML = e.outerHTML), b.support.html5Clone && e.innerHTML && !b.trim(t.innerHTML) && (t.innerHTML = e.innerHTML)) : "input" === n && Nt.test(e.type) ? (t.defaultChecked = t.checked = e.checked, t.value !== e.value && (t.value = e.value)) : "option" === n ? t.defaultSelected = t.selected = e.defaultSelected : ("input" === n || "textarea" === n) && (t.defaultValue = e.defaultValue)
        }
    }

    b.each({
        appendTo: "append",
        prependTo: "prepend",
        insertBefore: "before",
        insertAfter: "after",
        replaceAll: "replaceWith"
    }, function (e, t) {
        b.fn[e] = function (e) {
            var n, r = 0, i = [], o = b(e), a = o.length - 1;
            for (; a >= r; r++) n = r === a ? this : this.clone(!0), b(o[r])[t](n), d.apply(i, n.get());
            return this.pushStack(i)
        }
    });

    function Ot(e, n) {
        var r, o, a = 0,
            s = typeof e.getElementsByTagName !== i ? e.getElementsByTagName(n || "*") : typeof e.querySelectorAll !== i ? e.querySelectorAll(n || "*") : t;
        if (!s) for (s = [], r = e.childNodes || e; null != (o = r[a]); a++) !n || b.nodeName(o, n) ? s.push(o) : b.merge(s, Ot(o, n));
        return n === t || n && b.nodeName(e, n) ? b.merge([e], s) : s
    }

    function Bt(e) {
        Nt.test(e.type) && (e.defaultChecked = e.checked)
    }

    b.extend({
        clone: function (e, t, n) {
            var r, i, o, a, s, u = b.contains(e.ownerDocument, e);
            if (b.support.html5Clone || b.isXMLDoc(e) || !mt.test("<" + e.nodeName + ">") ? o = e.cloneNode(!0) : (Dt.innerHTML = e.outerHTML, Dt.removeChild(o = Dt.firstChild)), !(b.support.noCloneEvent && b.support.noCloneChecked || 1 !== e.nodeType && 11 !== e.nodeType || b.isXMLDoc(e))) for (r = Ot(o), s = Ot(e), a = 0; null != (i = s[a]); ++a) r[a] && Ft(i, r[a]);
            if (t) if (n) for (s = s || Ot(e), r = r || Ot(o), a = 0; null != (i = s[a]); a++) _t(i, r[a]); else _t(e, o);
            return r = Ot(o, "script"), r.length > 0 && Mt(r, !u && Ot(e, "script")), r = s = i = null, o
        }, buildFragment: function (e, t, n, r) {
            var i, o, a, s, u, l, c, p = e.length, f = dt(t), d = [], h = 0;
            for (; p > h; h++) if (o = e[h], o || 0 === o) if ("object" === b.type(o)) b.merge(d, o.nodeType ? [o] : o); else if (wt.test(o)) {
                s = s || f.appendChild(t.createElement("div")), u = (bt.exec(o) || ["", ""])[1].toLowerCase(), c = At[u] || At._default, s.innerHTML = c[1] + o.replace(vt, "<$1></$2>") + c[2], i = c[0];
                while (i--) s = s.lastChild;
                if (!b.support.leadingWhitespace && yt.test(o) && d.push(t.createTextNode(yt.exec(o)[0])), !b.support.tbody) {
                    o = "table" !== u || xt.test(o) ? "<table>" !== c[1] || xt.test(o) ? 0 : s : s.firstChild, i = o && o.childNodes.length;
                    while (i--) b.nodeName(l = o.childNodes[i], "tbody") && !l.childNodes.length && o.removeChild(l)
                }
                b.merge(d, s.childNodes), s.textContent = "";
                while (s.firstChild) s.removeChild(s.firstChild);
                s = f.lastChild
            } else d.push(t.createTextNode(o));
            s && f.removeChild(s), b.support.appendChecked || b.grep(Ot(d, "input"), Bt), h = 0;
            while (o = d[h++]) if ((!r || -1 === b.inArray(o, r)) && (a = b.contains(o.ownerDocument, o), s = Ot(f.appendChild(o), "script"), a && Mt(s), n)) {
                i = 0;
                while (o = s[i++]) kt.test(o.type || "") && n.push(o)
            }
            return s = null, f
        }, cleanData: function (e, t) {
            var n, r, o, a, s = 0, u = b.expando, l = b.cache, p = b.support.deleteExpando, f = b.event.special;
            for (; null != (n = e[s]); s++) if ((t || b.acceptData(n)) && (o = n[u], a = o && l[o])) {
                if (a.events) for (r in a.events) f[r] ? b.event.remove(n, r) : b.removeEvent(n, r, a.handle);
                l[o] && (delete l[o], p ? delete n[u] : typeof n.removeAttribute !== i ? n.removeAttribute(u) : n[u] = null, c.push(o))
            }
        }
    });
    var Pt, Rt, Wt, $t = /alpha\([^)]*\)/i, It = /opacity\s*=\s*([^)]*)/, zt = /^(top|right|bottom|left)$/,
        Xt = /^(none|table(?!-c[ea]).+)/, Ut = /^margin/, Vt = RegExp("^(" + x + ")(.*)$", "i"),
        Yt = RegExp("^(" + x + ")(?!px)[a-z%]+$", "i"), Jt = RegExp("^([+-])=(" + x + ")", "i"), Gt = {BODY: "block"},
        Qt = {position: "absolute", visibility: "hidden", display: "block"}, Kt = {letterSpacing: 0, fontWeight: 400},
        Zt = ["Top", "Right", "Bottom", "Left"], en = ["Webkit", "O", "Moz", "ms"];

    function tn(e, t) {
        if (t in e) return t;
        var n = t.charAt(0).toUpperCase() + t.slice(1), r = t, i = en.length;
        while (i--) if (t = en[i] + n, t in e) return t;
        return r
    }

    function nn(e, t) {
        return e = t || e, "none" === b.css(e, "display") || !b.contains(e.ownerDocument, e)
    }

    function rn(e, t) {
        var n, r, i, o = [], a = 0, s = e.length;
        for (; s > a; a++) r = e[a], r.style && (o[a] = b._data(r, "olddisplay"), n = r.style.display, t ? (o[a] || "none" !== n || (r.style.display = ""), "" === r.style.display && nn(r) && (o[a] = b._data(r, "olddisplay", un(r.nodeName)))) : o[a] || (i = nn(r), (n && "none" !== n || !i) && b._data(r, "olddisplay", i ? n : b.css(r, "display"))));
        for (a = 0; s > a; a++) r = e[a], r.style && (t && "none" !== r.style.display && "" !== r.style.display || (r.style.display = t ? o[a] || "" : "none"));
        return e
    }

    b.fn.extend({
        css: function (e, n) {
            return b.access(this, function (e, n, r) {
                var i, o, a = {}, s = 0;
                if (b.isArray(n)) {
                    for (o = Rt(e), i = n.length; i > s; s++) a[n[s]] = b.css(e, n[s], !1, o);
                    return a
                }
                return r !== t ? b.style(e, n, r) : b.css(e, n)
            }, e, n, arguments.length > 1)
        }, show: function () {
            return rn(this, !0)
        }, hide: function () {
            return rn(this)
        }, toggle: function (e) {
            var t = "boolean" == typeof e;
            return this.each(function () {
                (t ? e : nn(this)) ? b(this).show() : b(this).hide()
            })
        }
    }), b.extend({
        cssHooks: {
            opacity: {
                get: function (e, t) {
                    if (t) {
                        var n = Wt(e, "opacity");
                        return "" === n ? "1" : n
                    }
                }
            }
        },
        cssNumber: {
            columnCount: !0,
            fillOpacity: !0,
            fontWeight: !0,
            lineHeight: !0,
            opacity: !0,
            orphans: !0,
            widows: !0,
            zIndex: !0,
            zoom: !0
        },
        cssProps: {"float": b.support.cssFloat ? "cssFloat" : "styleFloat"},
        style: function (e, n, r, i) {
            if (e && 3 !== e.nodeType && 8 !== e.nodeType && e.style) {
                var o, a, s, u = b.camelCase(n), l = e.style;
                if (n = b.cssProps[u] || (b.cssProps[u] = tn(l, u)), s = b.cssHooks[n] || b.cssHooks[u], r === t) return s && "get" in s && (o = s.get(e, !1, i)) !== t ? o : l[n];
                if (a = typeof r, "string" === a && (o = Jt.exec(r)) && (r = (o[1] + 1) * o[2] + parseFloat(b.css(e, n)), a = "number"), !(null == r || "number" === a && isNaN(r) || ("number" !== a || b.cssNumber[u] || (r += "px"), b.support.clearCloneStyle || "" !== r || 0 !== n.indexOf("background") || (l[n] = "inherit"), s && "set" in s && (r = s.set(e, r, i)) === t))) try {
                    l[n] = r
                } catch (c) {
                }
            }
        },
        css: function (e, n, r, i) {
            var o, a, s, u = b.camelCase(n);
            return n = b.cssProps[u] || (b.cssProps[u] = tn(e.style, u)), s = b.cssHooks[n] || b.cssHooks[u], s && "get" in s && (a = s.get(e, !0, r)), a === t && (a = Wt(e, n, i)), "normal" === a && n in Kt && (a = Kt[n]), "" === r || r ? (o = parseFloat(a), r === !0 || b.isNumeric(o) ? o || 0 : a) : a
        },
        swap: function (e, t, n, r) {
            var i, o, a = {};
            for (o in t) a[o] = e.style[o], e.style[o] = t[o];
            i = n.apply(e, r || []);
            for (o in t) e.style[o] = a[o];
            return i
        }
    }), e.getComputedStyle ? (Rt = function (t) {
        return e.getComputedStyle(t, null)
    }, Wt = function (e, n, r) {
        var i, o, a, s = r || Rt(e), u = s ? s.getPropertyValue(n) || s[n] : t, l = e.style;
        return s && ("" !== u || b.contains(e.ownerDocument, e) || (u = b.style(e, n)), Yt.test(u) && Ut.test(n) && (i = l.width, o = l.minWidth, a = l.maxWidth, l.minWidth = l.maxWidth = l.width = u, u = s.width, l.width = i, l.minWidth = o, l.maxWidth = a)), u
    }) : o.documentElement.currentStyle && (Rt = function (e) {
        return e.currentStyle
    }, Wt = function (e, n, r) {
        var i, o, a, s = r || Rt(e), u = s ? s[n] : t, l = e.style;
        return null == u && l && l[n] && (u = l[n]), Yt.test(u) && !zt.test(n) && (i = l.left, o = e.runtimeStyle, a = o && o.left, a && (o.left = e.currentStyle.left), l.left = "fontSize" === n ? "1em" : u, u = l.pixelLeft + "px", l.left = i, a && (o.left = a)), "" === u ? "auto" : u
    });

    function on(e, t, n) {
        var r = Vt.exec(t);
        return r ? Math.max(0, r[1] - (n || 0)) + (r[2] || "px") : t
    }

    function an(e, t, n, r, i) {
        var o = n === (r ? "border" : "content") ? 4 : "width" === t ? 1 : 0, a = 0;
        for (; 4 > o; o += 2) "margin" === n && (a += b.css(e, n + Zt[o], !0, i)), r ? ("content" === n && (a -= b.css(e, "padding" + Zt[o], !0, i)), "margin" !== n && (a -= b.css(e, "border" + Zt[o] + "Width", !0, i))) : (a += b.css(e, "padding" + Zt[o], !0, i), "padding" !== n && (a += b.css(e, "border" + Zt[o] + "Width", !0, i)));
        return a
    }

    function sn(e, t, n) {
        var r = !0, i = "width" === t ? e.offsetWidth : e.offsetHeight, o = Rt(e),
            a = b.support.boxSizing && "border-box" === b.css(e, "boxSizing", !1, o);
        if (0 >= i || null == i) {
            if (i = Wt(e, t, o), (0 > i || null == i) && (i = e.style[t]), Yt.test(i)) return i;
            r = a && (b.support.boxSizingReliable || i === e.style[t]), i = parseFloat(i) || 0
        }
        return i + an(e, t, n || (a ? "border" : "content"), r, o) + "px"
    }

    function un(e) {
        var t = o, n = Gt[e];
        return n || (n = ln(e, t), "none" !== n && n || (Pt = (Pt || b("<iframe frameborder='0' width='0' height='0'/>").css("cssText", "display:block !important")).appendTo(t.documentElement), t = (Pt[0].contentWindow || Pt[0].contentDocument).document, t.write("<!doctype html><html><body>"), t.close(), n = ln(e, t), Pt.detach()), Gt[e] = n), n
    }

    function ln(e, t) {
        var n = b(t.createElement(e)).appendTo(t.body), r = b.css(n[0], "display");
        return n.remove(), r
    }

    b.each(["height", "width"], function (e, n) {
        b.cssHooks[n] = {
            get: function (e, r, i) {
                return r ? 0 === e.offsetWidth && Xt.test(b.css(e, "display")) ? b.swap(e, Qt, function () {
                    return sn(e, n, i)
                }) : sn(e, n, i) : t
            }, set: function (e, t, r) {
                var i = r && Rt(e);
                return on(e, t, r ? an(e, n, r, b.support.boxSizing && "border-box" === b.css(e, "boxSizing", !1, i), i) : 0)
            }
        }
    }), b.support.opacity || (b.cssHooks.opacity = {
        get: function (e, t) {
            return It.test((t && e.currentStyle ? e.currentStyle.filter : e.style.filter) || "") ? .01 * parseFloat(RegExp.$1) + "" : t ? "1" : ""
        }, set: function (e, t) {
            var n = e.style, r = e.currentStyle, i = b.isNumeric(t) ? "alpha(opacity=" + 100 * t + ")" : "",
                o = r && r.filter || n.filter || "";
            n.zoom = 1, (t >= 1 || "" === t) && "" === b.trim(o.replace($t, "")) && n.removeAttribute && (n.removeAttribute("filter"), "" === t || r && !r.filter) || (n.filter = $t.test(o) ? o.replace($t, i) : o + " " + i)
        }
    }), b(function () {
        b.support.reliableMarginRight || (b.cssHooks.marginRight = {
            get: function (e, n) {
                return n ? b.swap(e, {display: "inline-block"}, Wt, [e, "marginRight"]) : t
            }
        }), !b.support.pixelPosition && b.fn.position && b.each(["top", "left"], function (e, n) {
            b.cssHooks[n] = {
                get: function (e, r) {
                    return r ? (r = Wt(e, n), Yt.test(r) ? b(e).position()[n] + "px" : r) : t
                }
            }
        })
    }), b.expr && b.expr.filters && (b.expr.filters.hidden = function (e) {
        return 0 >= e.offsetWidth && 0 >= e.offsetHeight || !b.support.reliableHiddenOffsets && "none" === (e.style && e.style.display || b.css(e, "display"))
    }, b.expr.filters.visible = function (e) {
        return !b.expr.filters.hidden(e)
    }), b.each({margin: "", padding: "", border: "Width"}, function (e, t) {
        b.cssHooks[e + t] = {
            expand: function (n) {
                var r = 0, i = {}, o = "string" == typeof n ? n.split(" ") : [n];
                for (; 4 > r; r++) i[e + Zt[r] + t] = o[r] || o[r - 2] || o[0];
                return i
            }
        }, Ut.test(e) || (b.cssHooks[e + t].set = on)
    });
    var cn = /%20/g, pn = /\[\]$/, fn = /\r?\n/g, dn = /^(?:submit|button|image|reset|file)$/i,
        hn = /^(?:input|select|textarea|keygen)/i;
    b.fn.extend({
        serialize: function () {
            return b.param(this.serializeArray())
        }, serializeArray: function () {
            return this.map(function () {
                var e = b.prop(this, "elements");
                return e ? b.makeArray(e) : this
            }).filter(function () {
                var e = this.type;
                return this.name && !b(this).is(":disabled") && hn.test(this.nodeName) && !dn.test(e) && (this.checked || !Nt.test(e))
            }).map(function (e, t) {
                var n = b(this).val();
                return null == n ? null : b.isArray(n) ? b.map(n, function (e) {
                    return {name: t.name, value: e.replace(fn, "\r\n")}
                }) : {name: t.name, value: n.replace(fn, "\r\n")}
            }).get()
        }
    }), b.param = function (e, n) {
        var r, i = [], o = function (e, t) {
            t = b.isFunction(t) ? t() : null == t ? "" : t, i[i.length] = encodeURIComponent(e) + "=" + encodeURIComponent(t)
        };
        if (n === t && (n = b.ajaxSettings && b.ajaxSettings.traditional), b.isArray(e) || e.jquery && !b.isPlainObject(e)) b.each(e, function () {
            o(this.name, this.value)
        }); else for (r in e) gn(r, e[r], n, o);
        return i.join("&").replace(cn, "+")
    };

    function gn(e, t, n, r) {
        var i;
        if (b.isArray(t)) b.each(t, function (t, i) {
            n || pn.test(e) ? r(e, i) : gn(e + "[" + ("object" == typeof i ? t : "") + "]", i, n, r)
        }); else if (n || "object" !== b.type(t)) r(e, t); else for (i in t) gn(e + "[" + i + "]", t[i], n, r)
    }

    b.each("blur focus focusin focusout load resize scroll unload click dblclick mousedown mouseup mousemove mouseover mouseout mouseenter mouseleave change select submit keydown keypress keyup error contextmenu".split(" "), function (e, t) {
        b.fn[t] = function (e, n) {
            return arguments.length > 0 ? this.on(t, null, e, n) : this.trigger(t)
        }
    }), b.fn.hover = function (e, t) {
        return this.mouseenter(e).mouseleave(t || e)
    };
    var mn, yn, vn = b.now(), bn = /\?/, xn = /#.*$/, wn = /([?&])_=[^&]*/, Tn = /^(.*?):[ \t]*([^\r\n]*)\r?$/gm,
        Nn = /^(?:about|app|app-storage|.+-extension|file|res|widget):$/, Cn = /^(?:GET|HEAD)$/, kn = /^\/\//,
        En = /^([\w.+-]+:)(?:\/\/([^\/?#:]*)(?::(\d+)|)|)/, Sn = b.fn.load, An = {}, jn = {}, Dn = "*/".concat("*");
    try {
        yn = a.href
    } catch (Ln) {
        yn = o.createElement("a"), yn.href = "", yn = yn.href
    }
    mn = En.exec(yn.toLowerCase()) || [];

    function Hn(e) {
        return function (t, n) {
            "string" != typeof t && (n = t, t = "*");
            var r, i = 0, o = t.toLowerCase().match(w) || [];
            if (b.isFunction(n)) while (r = o[i++]) "+" === r[0] ? (r = r.slice(1) || "*", (e[r] = e[r] || []).unshift(n)) : (e[r] = e[r] || []).push(n)
        }
    }

    function qn(e, n, r, i) {
        var o = {}, a = e === jn;

        function s(u) {
            var l;
            return o[u] = !0, b.each(e[u] || [], function (e, u) {
                var c = u(n, r, i);
                return "string" != typeof c || a || o[c] ? a ? !(l = c) : t : (n.dataTypes.unshift(c), s(c), !1)
            }), l
        }

        return s(n.dataTypes[0]) || !o["*"] && s("*")
    }

    function Mn(e, n) {
        var r, i, o = b.ajaxSettings.flatOptions || {};
        for (i in n) n[i] !== t && ((o[i] ? e : r || (r = {}))[i] = n[i]);
        return r && b.extend(!0, e, r), e
    }

    b.fn.load = function (e, n, r) {
        if ("string" != typeof e && Sn) return Sn.apply(this, arguments);
        var i, o, a, s = this, u = e.indexOf(" ");
        return u >= 0 && (i = e.slice(u, e.length), e = e.slice(0, u)), b.isFunction(n) ? (r = n, n = t) : n && "object" == typeof n && (a = "POST"), s.length > 0 && b.ajax({
            url: e,
            type: a,
            dataType: "html",
            data: n
        }).done(function (e) {
            o = arguments, s.html(i ? b("<div>").append(b.parseHTML(e)).find(i) : e)
        }).complete(r && function (e, t) {
            s.each(r, o || [e.responseText, t, e])
        }), this
    }, b.each(["ajaxStart", "ajaxStop", "ajaxComplete", "ajaxError", "ajaxSuccess", "ajaxSend"], function (e, t) {
        b.fn[t] = function (e) {
            return this.on(t, e)
        }
    }), b.each(["get", "post"], function (e, n) {
        b[n] = function (e, r, i, o) {
            return b.isFunction(r) && (o = o || i, i = r, r = t), b.ajax({
                url: e,
                type: n,
                dataType: o,
                data: r,
                success: i
            })
        }
    }), b.extend({
        active: 0,
        lastModified: {},
        etag: {},
        ajaxSettings: {
            url: yn,
            type: "GET",
            isLocal: Nn.test(mn[1]),
            global: !0,
            processData: !0,
            async: !0,
            contentType: "application/x-www-form-urlencoded; charset=UTF-8",
            accepts: {
                "*": Dn,
                text: "text/plain",
                html: "text/html",
                xml: "application/xml, text/xml",
                json: "application/json, text/javascript"
            },
            contents: {xml: /xml/, html: /html/, json: /json/},
            responseFields: {xml: "responseXML", text: "responseText"},
            converters: {"* text": e.String, "text html": !0, "text json": b.parseJSON, "text xml": b.parseXML},
            flatOptions: {url: !0, context: !0}
        },
        ajaxSetup: function (e, t) {
            return t ? Mn(Mn(e, b.ajaxSettings), t) : Mn(b.ajaxSettings, e)
        },
        ajaxPrefilter: Hn(An),
        ajaxTransport: Hn(jn),
        ajax: function (e, n) {
            "object" == typeof e && (n = e, e = t), n = n || {};
            var r, i, o, a, s, u, l, c, p = b.ajaxSetup({}, n), f = p.context || p,
                d = p.context && (f.nodeType || f.jquery) ? b(f) : b.event, h = b.Deferred(),
                g = b.Callbacks("once memory"), m = p.statusCode || {}, y = {}, v = {}, x = 0, T = "canceled", N = {
                    readyState: 0, getResponseHeader: function (e) {
                        var t;
                        if (2 === x) {
                            if (!c) {
                                c = {};
                                while (t = Tn.exec(a)) c[t[1].toLowerCase()] = t[2]
                            }
                            t = c[e.toLowerCase()]
                        }
                        return null == t ? null : t
                    }, getAllResponseHeaders: function () {
                        return 2 === x ? a : null
                    }, setRequestHeader: function (e, t) {
                        var n = e.toLowerCase();
                        return x || (e = v[n] = v[n] || e, y[e] = t), this
                    }, overrideMimeType: function (e) {
                        return x || (p.mimeType = e), this
                    }, statusCode: function (e) {
                        var t;
                        if (e) if (2 > x) for (t in e) m[t] = [m[t], e[t]]; else N.always(e[N.status]);
                        return this
                    }, abort: function (e) {
                        var t = e || T;
                        return l && l.abort(t), k(0, t), this
                    }
                };
            if (h.promise(N).complete = g.add, N.success = N.done, N.error = N.fail, p.url = ((e || p.url || yn) + "").replace(xn, "").replace(kn, mn[1] + "//"), p.type = n.method || n.type || p.method || p.type, p.dataTypes = b.trim(p.dataType || "*").toLowerCase().match(w) || [""], null == p.crossDomain && (r = En.exec(p.url.toLowerCase()), p.crossDomain = !(!r || r[1] === mn[1] && r[2] === mn[2] && (r[3] || ("http:" === r[1] ? 80 : 443)) == (mn[3] || ("http:" === mn[1] ? 80 : 443)))), p.data && p.processData && "string" != typeof p.data && (p.data = b.param(p.data, p.traditional)), qn(An, p, n, N), 2 === x) return N;
            u = p.global, u && 0 === b.active++ && b.event.trigger("ajaxStart"), p.type = p.type.toUpperCase(), p.hasContent = !Cn.test(p.type), o = p.url, p.hasContent || (p.data && (o = p.url += (bn.test(o) ? "&" : "?") + p.data, delete p.data), p.cache === !1 && (p.url = wn.test(o) ? o.replace(wn, "$1_=" + vn++) : o + (bn.test(o) ? "&" : "?") + "_=" + vn++)), p.ifModified && (b.lastModified[o] && N.setRequestHeader("If-Modified-Since", b.lastModified[o]), b.etag[o] && N.setRequestHeader("If-None-Match", b.etag[o])), (p.data && p.hasContent && p.contentType !== !1 || n.contentType) && N.setRequestHeader("Content-Type", p.contentType), N.setRequestHeader("Accept", p.dataTypes[0] && p.accepts[p.dataTypes[0]] ? p.accepts[p.dataTypes[0]] + ("*" !== p.dataTypes[0] ? ", " + Dn + "; q=0.01" : "") : p.accepts["*"]);
            for (i in p.headers) N.setRequestHeader(i, p.headers[i]);
            if (p.beforeSend && (p.beforeSend.call(f, N, p) === !1 || 2 === x)) return N.abort();
            T = "abort";
            for (i in {success: 1, error: 1, complete: 1}) N[i](p[i]);
            if (l = qn(jn, p, n, N)) {
                N.readyState = 1, u && d.trigger("ajaxSend", [N, p]), p.async && p.timeout > 0 && (s = setTimeout(function () {
                    N.abort("timeout")
                }, p.timeout));
                try {
                    x = 1, l.send(y, k)
                } catch (C) {
                    if (!(2 > x)) throw C;
                    k(-1, C)
                }
            } else k(-1, "No Transport");

            function k(e, n, r, i) {
                var c, y, v, w, T, C = n;
                2 !== x && (x = 2, s && clearTimeout(s), l = t, a = i || "", N.readyState = e > 0 ? 4 : 0, r && (w = _n(p, N, r)), e >= 200 && 300 > e || 304 === e ? (p.ifModified && (T = N.getResponseHeader("Last-Modified"), T && (b.lastModified[o] = T), T = N.getResponseHeader("etag"), T && (b.etag[o] = T)), 204 === e ? (c = !0, C = "nocontent") : 304 === e ? (c = !0, C = "notmodified") : (c = Fn(p, w), C = c.state, y = c.data, v = c.error, c = !v)) : (v = C, (e || !C) && (C = "error", 0 > e && (e = 0))), N.status = e, N.statusText = (n || C) + "", c ? h.resolveWith(f, [y, C, N]) : h.rejectWith(f, [N, C, v]), N.statusCode(m), m = t, u && d.trigger(c ? "ajaxSuccess" : "ajaxError", [N, p, c ? y : v]), g.fireWith(f, [N, C]), u && (d.trigger("ajaxComplete", [N, p]), --b.active || b.event.trigger("ajaxStop")))
            }

            return N
        },
        getScript: function (e, n) {
            return b.get(e, t, n, "script")
        },
        getJSON: function (e, t, n) {
            return b.get(e, t, n, "json")
        }
    });

    function _n(e, n, r) {
        var i, o, a, s, u = e.contents, l = e.dataTypes, c = e.responseFields;
        for (s in c) s in r && (n[c[s]] = r[s]);
        while ("*" === l[0]) l.shift(), o === t && (o = e.mimeType || n.getResponseHeader("Content-Type"));
        if (o) for (s in u) if (u[s] && u[s].test(o)) {
            l.unshift(s);
            break
        }
        if (l[0] in r) a = l[0]; else {
            for (s in r) {
                if (!l[0] || e.converters[s + " " + l[0]]) {
                    a = s;
                    break
                }
                i || (i = s)
            }
            a = a || i
        }
        return a ? (a !== l[0] && l.unshift(a), r[a]) : t
    }

    function Fn(e, t) {
        var n, r, i, o, a = {}, s = 0, u = e.dataTypes.slice(), l = u[0];
        if (e.dataFilter && (t = e.dataFilter(t, e.dataType)), u[1]) for (i in e.converters) a[i.toLowerCase()] = e.converters[i];
        for (; r = u[++s];) if ("*" !== r) {
            if ("*" !== l && l !== r) {
                if (i = a[l + " " + r] || a["* " + r], !i) for (n in a) if (o = n.split(" "), o[1] === r && (i = a[l + " " + o[0]] || a["* " + o[0]])) {
                    i === !0 ? i = a[n] : a[n] !== !0 && (r = o[0], u.splice(s--, 0, r));
                    break
                }
                if (i !== !0) if (i && e["throws"]) t = i(t); else try {
                    t = i(t)
                } catch (c) {
                    return {state: "parsererror", error: i ? c : "No conversion from " + l + " to " + r}
                }
            }
            l = r
        }
        return {state: "success", data: t}
    }

    b.ajaxSetup({
        accepts: {script: "text/javascript, application/javascript, application/ecmascript, application/x-ecmascript"},
        contents: {script: /(?:java|ecma)script/},
        converters: {
            "text script": function (e) {
                return b.globalEval(e), e
            }
        }
    }), b.ajaxPrefilter("script", function (e) {
        e.cache === t && (e.cache = !1), e.crossDomain && (e.type = "GET", e.global = !1)
    }), b.ajaxTransport("script", function (e) {
        if (e.crossDomain) {
            var n, r = o.head || b("head")[0] || o.documentElement;
            return {
                send: function (t, i) {
                    n = o.createElement("script"), n.async = !0, e.scriptCharset && (n.charset = e.scriptCharset), n.src = e.url, n.onload = n.onreadystatechange = function (e, t) {
                        (t || !n.readyState || /loaded|complete/.test(n.readyState)) && (n.onload = n.onreadystatechange = null, n.parentNode && n.parentNode.removeChild(n), n = null, t || i(200, "success"))
                    }, r.insertBefore(n, r.firstChild)
                }, abort: function () {
                    n && n.onload(t, !0)
                }
            }
        }
    });
    var On = [], Bn = /(=)\?(?=&|$)|\?\?/;
    b.ajaxSetup({
        jsonp: "callback", jsonpCallback: function () {
            var e = On.pop() || b.expando + "_" + vn++;
            return this[e] = !0, e
        }
    }), b.ajaxPrefilter("json jsonp", function (n, r, i) {
        var o, a, s,
            u = n.jsonp !== !1 && (Bn.test(n.url) ? "url" : "string" == typeof n.data && !(n.contentType || "").indexOf("application/x-www-form-urlencoded") && Bn.test(n.data) && "data");
        return u || "jsonp" === n.dataTypes[0] ? (o = n.jsonpCallback = b.isFunction(n.jsonpCallback) ? n.jsonpCallback() : n.jsonpCallback, u ? n[u] = n[u].replace(Bn, "$1" + o) : n.jsonp !== !1 && (n.url += (bn.test(n.url) ? "&" : "?") + n.jsonp + "=" + o), n.converters["script json"] = function () {
            return s || b.error(o + " was not called"), s[0]
        }, n.dataTypes[0] = "json", a = e[o], e[o] = function () {
            s = arguments
        }, i.always(function () {
            e[o] = a, n[o] && (n.jsonpCallback = r.jsonpCallback, On.push(o)), s && b.isFunction(a) && a(s[0]), s = a = t
        }), "script") : t
    });
    var Pn, Rn, Wn = 0, $n = e.ActiveXObject && function () {
        var e;
        for (e in Pn) Pn[e](t, !0)
    };

    function In() {
        try {
            return new e.XMLHttpRequest
        } catch (t) {
        }
    }

    function zn() {
        try {
            return new e.ActiveXObject("Microsoft.XMLHTTP")
        } catch (t) {
        }
    }

    b.ajaxSettings.xhr = e.ActiveXObject ? function () {
        return !this.isLocal && In() || zn()
    } : In, Rn = b.ajaxSettings.xhr(), b.support.cors = !!Rn && "withCredentials" in Rn, Rn = b.support.ajax = !!Rn, Rn && b.ajaxTransport(function (n) {
        if (!n.crossDomain || b.support.cors) {
            var r;
            return {
                send: function (i, o) {
                    var a, s, u = n.xhr();
                    if (n.username ? u.open(n.type, n.url, n.async, n.username, n.password) : u.open(n.type, n.url, n.async), n.xhrFields) for (s in n.xhrFields) u[s] = n.xhrFields[s];
                    n.mimeType && u.overrideMimeType && u.overrideMimeType(n.mimeType), n.crossDomain || i["X-Requested-With"] || (i["X-Requested-With"] = "XMLHttpRequest");
                    try {
                        for (s in i) u.setRequestHeader(s, i[s])
                    } catch (l) {
                    }
                    u.send(n.hasContent && n.data || null), r = function (e, i) {
                        var s, l, c, p;
                        try {
                            if (r && (i || 4 === u.readyState)) if (r = t, a && (u.onreadystatechange = b.noop, $n && delete Pn[a]), i) 4 !== u.readyState && u.abort(); else {
                                p = {}, s = u.status, l = u.getAllResponseHeaders(), "string" == typeof u.responseText && (p.text = u.responseText);
                                try {
                                    c = u.statusText
                                } catch (f) {
                                    c = ""
                                }
                                s || !n.isLocal || n.crossDomain ? 1223 === s && (s = 204) : s = p.text ? 200 : 404
                            }
                        } catch (d) {
                            i || o(-1, d)
                        }
                        p && o(s, c, p, l)
                    }, n.async ? 4 === u.readyState ? setTimeout(r) : (a = ++Wn, $n && (Pn || (Pn = {}, b(e).unload($n)), Pn[a] = r), u.onreadystatechange = r) : r()
                }, abort: function () {
                    r && r(t, !0)
                }
            }
        }
    });
    var Xn, Un, Vn = /^(?:toggle|show|hide)$/, Yn = RegExp("^(?:([+-])=|)(" + x + ")([a-z%]*)$", "i"),
        Jn = /queueHooks$/, Gn = [nr], Qn = {
            "*": [function (e, t) {
                var n, r, i = this.createTween(e, t), o = Yn.exec(t), a = i.cur(), s = +a || 0, u = 1, l = 20;
                if (o) {
                    if (n = +o[2], r = o[3] || (b.cssNumber[e] ? "" : "px"), "px" !== r && s) {
                        s = b.css(i.elem, e, !0) || n || 1;
                        do u = u || ".5", s /= u, b.style(i.elem, e, s + r); while (u !== (u = i.cur() / a) && 1 !== u && --l)
                    }
                    i.unit = r, i.start = s, i.end = o[1] ? s + (o[1] + 1) * n : n
                }
                return i
            }]
        };

    function Kn() {
        return setTimeout(function () {
            Xn = t
        }), Xn = b.now()
    }

    function Zn(e, t) {
        b.each(t, function (t, n) {
            var r = (Qn[t] || []).concat(Qn["*"]), i = 0, o = r.length;
            for (; o > i; i++) if (r[i].call(e, t, n)) return
        })
    }

    function er(e, t, n) {
        var r, i, o = 0, a = Gn.length, s = b.Deferred().always(function () {
            delete u.elem
        }), u = function () {
            if (i) return !1;
            var t = Xn || Kn(), n = Math.max(0, l.startTime + l.duration - t), r = n / l.duration || 0, o = 1 - r,
                a = 0, u = l.tweens.length;
            for (; u > a; a++) l.tweens[a].run(o);
            return s.notifyWith(e, [l, o, n]), 1 > o && u ? n : (s.resolveWith(e, [l]), !1)
        }, l = s.promise({
            elem: e,
            props: b.extend({}, t),
            opts: b.extend(!0, {specialEasing: {}}, n),
            originalProperties: t,
            originalOptions: n,
            startTime: Xn || Kn(),
            duration: n.duration,
            tweens: [],
            createTween: function (t, n) {
                var r = b.Tween(e, l.opts, t, n, l.opts.specialEasing[t] || l.opts.easing);
                return l.tweens.push(r), r
            },
            stop: function (t) {
                var n = 0, r = t ? l.tweens.length : 0;
                if (i) return this;
                for (i = !0; r > n; n++) l.tweens[n].run(1);
                return t ? s.resolveWith(e, [l, t]) : s.rejectWith(e, [l, t]), this
            }
        }), c = l.props;
        for (tr(c, l.opts.specialEasing); a > o; o++) if (r = Gn[o].call(l, e, c, l.opts)) return r;
        return Zn(l, c), b.isFunction(l.opts.start) && l.opts.start.call(e, l), b.fx.timer(b.extend(u, {
            elem: e,
            anim: l,
            queue: l.opts.queue
        })), l.progress(l.opts.progress).done(l.opts.done, l.opts.complete).fail(l.opts.fail).always(l.opts.always)
    }

    function tr(e, t) {
        var n, r, i, o, a;
        for (i in e) if (r = b.camelCase(i), o = t[r], n = e[i], b.isArray(n) && (o = n[1], n = e[i] = n[0]), i !== r && (e[r] = n, delete e[i]), a = b.cssHooks[r], a && "expand" in a) {
            n = a.expand(n), delete e[r];
            for (i in n) i in e || (e[i] = n[i], t[i] = o)
        } else t[r] = o
    }

    b.Animation = b.extend(er, {
        tweener: function (e, t) {
            b.isFunction(e) ? (t = e, e = ["*"]) : e = e.split(" ");
            var n, r = 0, i = e.length;
            for (; i > r; r++) n = e[r], Qn[n] = Qn[n] || [], Qn[n].unshift(t)
        }, prefilter: function (e, t) {
            t ? Gn.unshift(e) : Gn.push(e)
        }
    });

    function nr(e, t, n) {
        var r, i, o, a, s, u, l, c, p, f = this, d = e.style, h = {}, g = [], m = e.nodeType && nn(e);
        n.queue || (c = b._queueHooks(e, "fx"), null == c.unqueued && (c.unqueued = 0, p = c.empty.fire, c.empty.fire = function () {
            c.unqueued || p()
        }), c.unqueued++, f.always(function () {
            f.always(function () {
                c.unqueued--, b.queue(e, "fx").length || c.empty.fire()
            })
        })), 1 === e.nodeType && ("height" in t || "width" in t) && (n.overflow = [d.overflow, d.overflowX, d.overflowY], "inline" === b.css(e, "display") && "none" === b.css(e, "float") && (b.support.inlineBlockNeedsLayout && "inline" !== un(e.nodeName) ? d.zoom = 1 : d.display = "inline-block")), n.overflow && (d.overflow = "hidden", b.support.shrinkWrapBlocks || f.always(function () {
            d.overflow = n.overflow[0], d.overflowX = n.overflow[1], d.overflowY = n.overflow[2]
        }));
        for (i in t) if (a = t[i], Vn.exec(a)) {
            if (delete t[i], u = u || "toggle" === a, a === (m ? "hide" : "show")) continue;
            g.push(i)
        }
        if (o = g.length) {
            s = b._data(e, "fxshow") || b._data(e, "fxshow", {}), "hidden" in s && (m = s.hidden), u && (s.hidden = !m), m ? b(e).show() : f.done(function () {
                b(e).hide()
            }), f.done(function () {
                var t;
                b._removeData(e, "fxshow");
                for (t in h) b.style(e, t, h[t])
            });
            for (i = 0; o > i; i++) r = g[i], l = f.createTween(r, m ? s[r] : 0), h[r] = s[r] || b.style(e, r), r in s || (s[r] = l.start, m && (l.end = l.start, l.start = "width" === r || "height" === r ? 1 : 0))
        }
    }

    function rr(e, t, n, r, i) {
        return new rr.prototype.init(e, t, n, r, i)
    }

    b.Tween = rr, rr.prototype = {
        constructor: rr, init: function (e, t, n, r, i, o) {
            this.elem = e, this.prop = n, this.easing = i || "swing", this.options = t, this.start = this.now = this.cur(), this.end = r, this.unit = o || (b.cssNumber[n] ? "" : "px")
        }, cur: function () {
            var e = rr.propHooks[this.prop];
            return e && e.get ? e.get(this) : rr.propHooks._default.get(this)
        }, run: function (e) {
            var t, n = rr.propHooks[this.prop];
            return this.pos = t = this.options.duration ? b.easing[this.easing](e, this.options.duration * e, 0, 1, this.options.duration) : e, this.now = (this.end - this.start) * t + this.start, this.options.step && this.options.step.call(this.elem, this.now, this), n && n.set ? n.set(this) : rr.propHooks._default.set(this), this
        }
    }, rr.prototype.init.prototype = rr.prototype, rr.propHooks = {
        _default: {
            get: function (e) {
                var t;
                return null == e.elem[e.prop] || e.elem.style && null != e.elem.style[e.prop] ? (t = b.css(e.elem, e.prop, ""), t && "auto" !== t ? t : 0) : e.elem[e.prop]
            }, set: function (e) {
                b.fx.step[e.prop] ? b.fx.step[e.prop](e) : e.elem.style && (null != e.elem.style[b.cssProps[e.prop]] || b.cssHooks[e.prop]) ? b.style(e.elem, e.prop, e.now + e.unit) : e.elem[e.prop] = e.now
            }
        }
    }, rr.propHooks.scrollTop = rr.propHooks.scrollLeft = {
        set: function (e) {
            e.elem.nodeType && e.elem.parentNode && (e.elem[e.prop] = e.now)
        }
    }, b.each(["toggle", "show", "hide"], function (e, t) {
        var n = b.fn[t];
        b.fn[t] = function (e, r, i) {
            return null == e || "boolean" == typeof e ? n.apply(this, arguments) : this.animate(ir(t, !0), e, r, i)
        }
    }), b.fn.extend({
        fadeTo: function (e, t, n, r) {
            return this.filter(nn).css("opacity", 0).show().end().animate({opacity: t}, e, n, r)
        }, animate: function (e, t, n, r) {
            var i = b.isEmptyObject(e), o = b.speed(t, n, r), a = function () {
                var t = er(this, b.extend({}, e), o);
                a.finish = function () {
                    t.stop(!0)
                }, (i || b._data(this, "finish")) && t.stop(!0)
            };
            return a.finish = a, i || o.queue === !1 ? this.each(a) : this.queue(o.queue, a)
        }, stop: function (e, n, r) {
            var i = function (e) {
                var t = e.stop;
                delete e.stop, t(r)
            };
            return "string" != typeof e && (r = n, n = e, e = t), n && e !== !1 && this.queue(e || "fx", []), this.each(function () {
                var t = !0, n = null != e && e + "queueHooks", o = b.timers, a = b._data(this);
                if (n) a[n] && a[n].stop && i(a[n]); else for (n in a) a[n] && a[n].stop && Jn.test(n) && i(a[n]);
                for (n = o.length; n--;) o[n].elem !== this || null != e && o[n].queue !== e || (o[n].anim.stop(r), t = !1, o.splice(n, 1));
                (t || !r) && b.dequeue(this, e)
            })
        }, finish: function (e) {
            return e !== !1 && (e = e || "fx"), this.each(function () {
                var t, n = b._data(this), r = n[e + "queue"], i = n[e + "queueHooks"], o = b.timers,
                    a = r ? r.length : 0;
                for (n.finish = !0, b.queue(this, e, []), i && i.cur && i.cur.finish && i.cur.finish.call(this), t = o.length; t--;) o[t].elem === this && o[t].queue === e && (o[t].anim.stop(!0), o.splice(t, 1));
                for (t = 0; a > t; t++) r[t] && r[t].finish && r[t].finish.call(this);
                delete n.finish
            })
        }
    });

    function ir(e, t) {
        var n, r = {height: e}, i = 0;
        for (t = t ? 1 : 0; 4 > i; i += 2 - t) n = Zt[i], r["margin" + n] = r["padding" + n] = e;
        return t && (r.opacity = r.width = e), r
    }

    b.each({
        slideDown: ir("show"),
        slideUp: ir("hide"),
        slideToggle: ir("toggle"),
        fadeIn: {opacity: "show"},
        fadeOut: {opacity: "hide"},
        fadeToggle: {opacity: "toggle"}
    }, function (e, t) {
        b.fn[e] = function (e, n, r) {
            return this.animate(t, e, n, r)
        }
    }), b.speed = function (e, t, n) {
        var r = e && "object" == typeof e ? b.extend({}, e) : {
            complete: n || !n && t || b.isFunction(e) && e,
            duration: e,
            easing: n && t || t && !b.isFunction(t) && t
        };
        return r.duration = b.fx.off ? 0 : "number" == typeof r.duration ? r.duration : r.duration in b.fx.speeds ? b.fx.speeds[r.duration] : b.fx.speeds._default, (null == r.queue || r.queue === !0) && (r.queue = "fx"), r.old = r.complete, r.complete = function () {
            b.isFunction(r.old) && r.old.call(this), r.queue && b.dequeue(this, r.queue)
        }, r
    }, b.easing = {
        linear: function (e) {
            return e
        }, swing: function (e) {
            return .5 - Math.cos(e * Math.PI) / 2
        }
    }, b.timers = [], b.fx = rr.prototype.init, b.fx.tick = function () {
        var e, n = b.timers, r = 0;
        for (Xn = b.now(); n.length > r; r++) e = n[r], e() || n[r] !== e || n.splice(r--, 1);
        n.length || b.fx.stop(), Xn = t
    }, b.fx.timer = function (e) {
        e() && b.timers.push(e) && b.fx.start()
    }, b.fx.interval = 13, b.fx.start = function () {
        Un || (Un = setInterval(b.fx.tick, b.fx.interval))
    }, b.fx.stop = function () {
        clearInterval(Un), Un = null
    }, b.fx.speeds = {
        slow: 600,
        fast: 200,
        _default: 400
    }, b.fx.step = {}, b.expr && b.expr.filters && (b.expr.filters.animated = function (e) {
        return b.grep(b.timers, function (t) {
            return e === t.elem
        }).length
    }), b.fn.offset = function (e) {
        if (arguments.length) return e === t ? this : this.each(function (t) {
            b.offset.setOffset(this, e, t)
        });
        var n, r, o = {top: 0, left: 0}, a = this[0], s = a && a.ownerDocument;
        if (s) return n = s.documentElement, b.contains(n, a) ? (typeof a.getBoundingClientRect !== i && (o = a.getBoundingClientRect()), r = or(s), {
            top: o.top + (r.pageYOffset || n.scrollTop) - (n.clientTop || 0),
            left: o.left + (r.pageXOffset || n.scrollLeft) - (n.clientLeft || 0)
        }) : o
    }, b.offset = {
        setOffset: function (e, t, n) {
            var r = b.css(e, "position");
            "static" === r && (e.style.position = "relative");
            var i = b(e), o = i.offset(), a = b.css(e, "top"), s = b.css(e, "left"),
                u = ("absolute" === r || "fixed" === r) && b.inArray("auto", [a, s]) > -1, l = {}, c = {}, p, f;
            u ? (c = i.position(), p = c.top, f = c.left) : (p = parseFloat(a) || 0, f = parseFloat(s) || 0), b.isFunction(t) && (t = t.call(e, n, o)), null != t.top && (l.top = t.top - o.top + p), null != t.left && (l.left = t.left - o.left + f), "using" in t ? t.using.call(e, l) : i.css(l)
        }
    }, b.fn.extend({
        position: function () {
            if (this[0]) {
                var e, t, n = {top: 0, left: 0}, r = this[0];
                return "fixed" === b.css(r, "position") ? t = r.getBoundingClientRect() : (e = this.offsetParent(), t = this.offset(), b.nodeName(e[0], "html") || (n = e.offset()), n.top += b.css(e[0], "borderTopWidth", !0), n.left += b.css(e[0], "borderLeftWidth", !0)), {
                    top: t.top - n.top - b.css(r, "marginTop", !0),
                    left: t.left - n.left - b.css(r, "marginLeft", !0)
                }
            }
        }, offsetParent: function () {
            return this.map(function () {
                var e = this.offsetParent || o.documentElement;
                while (e && !b.nodeName(e, "html") && "static" === b.css(e, "position")) e = e.offsetParent;
                return e || o.documentElement
            })
        }
    }), b.each({scrollLeft: "pageXOffset", scrollTop: "pageYOffset"}, function (e, n) {
        var r = /Y/.test(n);
        b.fn[e] = function (i) {
            return b.access(this, function (e, i, o) {
                var a = or(e);
                return o === t ? a ? n in a ? a[n] : a.document.documentElement[i] : e[i] : (a ? a.scrollTo(r ? b(a).scrollLeft() : o, r ? o : b(a).scrollTop()) : e[i] = o, t)
            }, e, i, arguments.length, null)
        }
    });

    function or(e) {
        return b.isWindow(e) ? e : 9 === e.nodeType ? e.defaultView || e.parentWindow : !1
    }

    b.each({Height: "height", Width: "width"}, function (e, n) {
        b.each({padding: "inner" + e, content: n, "": "outer" + e}, function (r, i) {
            b.fn[i] = function (i, o) {
                var a = arguments.length && (r || "boolean" != typeof i),
                    s = r || (i === !0 || o === !0 ? "margin" : "border");
                return b.access(this, function (n, r, i) {
                    var o;
                    return b.isWindow(n) ? n.document.documentElement["client" + e] : 9 === n.nodeType ? (o = n.documentElement, Math.max(n.body["scroll" + e], o["scroll" + e], n.body["offset" + e], o["offset" + e], o["client" + e])) : i === t ? b.css(n, r, s) : b.style(n, r, i, s)
                }, n, a ? i : t, a, null)
            }
        })
    }), e.jQuery = e.$ = b, "function" == typeof define && define.amd && define.amd.jQuery && define("jquery", [], function () {
        return b
    })
})(window);
jQuery.migrateMute === void 0 && (jQuery.migrateMute = !0), function (e, t, n) {
    function r(n) {
        var r = t.console;
        i[n] || (i[n] = !0, e.migrateWarnings.push(n), r && r.warn && !e.migrateMute && (r.warn("JQMIGRATE: " + n), e.migrateTrace && r.trace && r.trace()))
    }

    function a(t, a, i, o) {
        if (Object.defineProperty) try {
            return Object.defineProperty(t, a, {
                configurable: !0, enumerable: !0, get: function () {
                    return r(o), i
                }, set: function (e) {
                    r(o), i = e
                }
            }), n
        } catch (s) {
        }
        e._definePropertyBroken = !0, t[a] = i
    }

    var i = {};
    e.migrateWarnings = [], !e.migrateMute && t.console && t.console.log && t.console.log("JQMIGRATE: Logging is active"), e.migrateTrace === n && (e.migrateTrace = !0), e.migrateReset = function () {
        i = {}, e.migrateWarnings.length = 0
    }, "BackCompat" === document.compatMode && r("jQuery is not compatible with Quirks Mode");
    var o = e("<input/>", {size: 1}).attr("size") && e.attrFn, s = e.attr,
        u = e.attrHooks.value && e.attrHooks.value.get || function () {
            return null
        }, c = e.attrHooks.value && e.attrHooks.value.set || function () {
            return n
        }, l = /^(?:input|button)$/i, d = /^[238]$/,
        p = /^(?:autofocus|autoplay|async|checked|controls|defer|disabled|hidden|loop|multiple|open|readonly|required|scoped|selected)$/i,
        f = /^(?:checked|selected)$/i;
    a(e, "attrFn", o || {}, "jQuery.attrFn is deprecated"), e.attr = function (t, a, i, u) {
        var c = a.toLowerCase(), g = t && t.nodeType;
        return u && (4 > s.length && r("jQuery.fn.attr( props, pass ) is deprecated"), t && !d.test(g) && (o ? a in o : e.isFunction(e.fn[a]))) ? e(t)[a](i) : ("type" === a && i !== n && l.test(t.nodeName) && t.parentNode && r("Can't change the 'type' of an input or button in IE 6/7/8"), !e.attrHooks[c] && p.test(c) && (e.attrHooks[c] = {
            get: function (t, r) {
                var a, i = e.prop(t, r);
                return i === !0 || "boolean" != typeof i && (a = t.getAttributeNode(r)) && a.nodeValue !== !1 ? r.toLowerCase() : n
            }, set: function (t, n, r) {
                var a;
                return n === !1 ? e.removeAttr(t, r) : (a = e.propFix[r] || r, a in t && (t[a] = !0), t.setAttribute(r, r.toLowerCase())), r
            }
        }, f.test(c) && r("jQuery.fn.attr('" + c + "') may use property instead of attribute")), s.call(e, t, a, i))
    }, e.attrHooks.value = {
        get: function (e, t) {
            var n = (e.nodeName || "").toLowerCase();
            return "button" === n ? u.apply(this, arguments) : ("input" !== n && "option" !== n && r("jQuery.fn.attr('value') no longer gets properties"), t in e ? e.value : null)
        }, set: function (e, t) {
            var a = (e.nodeName || "").toLowerCase();
            return "button" === a ? c.apply(this, arguments) : ("input" !== a && "option" !== a && r("jQuery.fn.attr('value', val) no longer sets properties"), e.value = t, n)
        }
    };
    var g, h, v = e.fn.init, m = e.parseJSON, y = /^([^<]*)(<[\w\W]+>)([^>]*)$/;
    e.fn.init = function (t, n, a) {
        var i;
        return t && "string" == typeof t && !e.isPlainObject(n) && (i = y.exec(e.trim(t))) && i[0] && ("<" !== t.charAt(0) && r("$(html) HTML strings must start with '<' character"), i[3] && r("$(html) HTML text after last tag is ignored"), "#" === i[0].charAt(0) && (r("HTML string cannot start with a '#' character"), e.error("JQMIGRATE: Invalid selector string (XSS)")), n && n.context && (n = n.context), e.parseHTML) ? v.call(this, e.parseHTML(i[2], n, !0), n, a) : v.apply(this, arguments)
    }, e.fn.init.prototype = e.fn, e.parseJSON = function (e) {
        return e || null === e ? m.apply(this, arguments) : (r("jQuery.parseJSON requires a valid JSON string"), null)
    }, e.uaMatch = function (e) {
        e = e.toLowerCase();
        var t = /(chrome)[ \/]([\w.]+)/.exec(e) || /(webkit)[ \/]([\w.]+)/.exec(e) || /(opera)(?:.*version|)[ \/]([\w.]+)/.exec(e) || /(msie) ([\w.]+)/.exec(e) || 0 > e.indexOf("compatible") && /(mozilla)(?:.*? rv:([\w.]+)|)/.exec(e) || [];
        return {browser: t[1] || "", version: t[2] || "0"}
    }, e.browser || (g = e.uaMatch(navigator.userAgent), h = {}, g.browser && (h[g.browser] = !0, h.version = g.version), h.chrome ? h.webkit = !0 : h.webkit && (h.safari = !0), e.browser = h), a(e, "browser", e.browser, "jQuery.browser is deprecated"), e.sub = function () {
        function t(e, n) {
            return new t.fn.init(e, n)
        }

        e.extend(!0, t, this), t.superclass = this, t.fn = t.prototype = this(), t.fn.constructor = t, t.sub = this.sub, t.fn.init = function (r, a) {
            return a && a instanceof e && !(a instanceof t) && (a = t(a)), e.fn.init.call(this, r, a, n)
        }, t.fn.init.prototype = t.fn;
        var n = t(document);
        return r("jQuery.sub() is deprecated"), t
    }, e.ajaxSetup({converters: {"text json": e.parseJSON}});
    var b = e.fn.data;
    e.fn.data = function (t) {
        var a, i, o = this[0];
        return !o || "events" !== t || 1 !== arguments.length || (a = e.data(o, t), i = e._data(o, t), a !== n && a !== i || i === n) ? b.apply(this, arguments) : (r("Use of jQuery.fn.data('events') is deprecated"), i)
    };
    var j = /\/(java|ecma)script/i, w = e.fn.andSelf || e.fn.addBack;
    e.fn.andSelf = function () {
        return r("jQuery.fn.andSelf() replaced by jQuery.fn.addBack()"), w.apply(this, arguments)
    }, e.clean || (e.clean = function (t, a, i, o) {
        a = a || document, a = !a.nodeType && a[0] || a, a = a.ownerDocument || a, r("jQuery.clean() is deprecated");
        var s, u, c, l, d = [];
        if (e.merge(d, e.buildFragment(t, a).childNodes), i) for (c = function (e) {
            return !e.type || j.test(e.type) ? o ? o.push(e.parentNode ? e.parentNode.removeChild(e) : e) : i.appendChild(e) : n
        }, s = 0; null != (u = d[s]); s++) e.nodeName(u, "script") && c(u) || (i.appendChild(u), u.getElementsByTagName !== n && (l = e.grep(e.merge([], u.getElementsByTagName("script")), c), d.splice.apply(d, [s + 1, 0].concat(l)), s += l.length));
        return d
    });
    var Q = e.event.add, x = e.event.remove, k = e.event.trigger, N = e.fn.toggle, T = e.fn.live, M = e.fn.die,
        S = "ajaxStart|ajaxStop|ajaxSend|ajaxComplete|ajaxError|ajaxSuccess", C = RegExp("\\b(?:" + S + ")\\b"),
        H = /(?:^|\s)hover(\.\S+|)\b/, A = function (t) {
            return "string" != typeof t || e.event.special.hover ? t : (H.test(t) && r("'hover' pseudo-event is deprecated, use 'mouseenter mouseleave'"), t && t.replace(H, "mouseenter$1 mouseleave$1"))
        };
    e.event.props && "attrChange" !== e.event.props[0] && e.event.props.unshift("attrChange", "attrName", "relatedNode", "srcElement"), e.event.dispatch && a(e.event, "handle", e.event.dispatch, "jQuery.event.handle is undocumented and deprecated"), e.event.add = function (e, t, n, a, i) {
        e !== document && C.test(t) && r("AJAX events should be attached to document: " + t), Q.call(this, e, A(t || ""), n, a, i)
    }, e.event.remove = function (e, t, n, r, a) {
        x.call(this, e, A(t) || "", n, r, a)
    }, e.fn.error = function () {
        var e = Array.prototype.slice.call(arguments, 0);
        return r("jQuery.fn.error() is deprecated"), e.splice(0, 0, "error"), arguments.length ? this.bind.apply(this, e) : (this.triggerHandler.apply(this, e), this)
    }, e.fn.toggle = function (t, n) {
        if (!e.isFunction(t) || !e.isFunction(n)) return N.apply(this, arguments);
        r("jQuery.fn.toggle(handler, handler...) is deprecated");
        var a = arguments, i = t.guid || e.guid++, o = 0, s = function (n) {
            var r = (e._data(this, "lastToggle" + t.guid) || 0) % o;
            return e._data(this, "lastToggle" + t.guid, r + 1), n.preventDefault(), a[r].apply(this, arguments) || !1
        };
        for (s.guid = i; a.length > o;) a[o++].guid = i;
        return this.click(s)
    }, e.fn.live = function (t, n, a) {
        return r("jQuery.fn.live() is deprecated"), T ? T.apply(this, arguments) : (e(this.context).on(t, this.selector, n, a), this)
    }, e.fn.die = function (t, n) {
        return r("jQuery.fn.die() is deprecated"), M ? M.apply(this, arguments) : (e(this.context).off(t, this.selector || "**", n), this)
    }, e.event.trigger = function (e, t, n, a) {
        return n || C.test(e) || r("Global events are undocumented and deprecated"), k.call(this, e, t, n || document, a)
    }, e.each(S.split("|"), function (t, n) {
        e.event.special[n] = {
            setup: function () {
                var t = this;
                return t !== document && (e.event.add(document, n + "." + e.guid, function () {
                    e.event.trigger(n, null, t, !0)
                }), e._data(this, n, e.guid++)), !1
            }, teardown: function () {
                return this !== document && e.event.remove(document, n + "." + e._data(this, n)), !1
            }
        }
    })
}(jQuery, window);
!function (e) {
    "function" == typeof define && define.amd ? define(["jquery"], e) : "object" == typeof module && "object" == typeof module.exports ? module.exports = e(require("jquery")) : e(jQuery)
}(function (e) {
    "use strict";
    e.extend({
        tablesorter: new function () {
            function t() {
                var e = arguments[0], t = arguments.length > 1 ? Array.prototype.slice.call(arguments) : e;
                "undefined" != typeof console && "undefined" != typeof console.log ? console[/error/i.test(e) ? "error" : /warn/i.test(e) ? "warn" : "log"](t) : alert(t)
            }

            function r(e, r) {
                t(e + " (" + ((new Date).getTime() - r.getTime()) + "ms)")
            }

            function s(e) {
                for (var t in e) return !1;
                return !0
            }

            function a(r, s, a, n) {
                for (var o, i, d = r.config, c = v.parsers.length, l = !1, u = "", p = !0; "" === u && p;) a++, s[a] ? (l = s[a].cells[n], u = v.getElementText(d, l, n), i = e(l), r.config.debug && t("Checking if value was empty on row " + a + ", column: " + n + ': "' + u + '"')) : p = !1;
                for (; --c >= 0;) if (o = v.parsers[c], o && "text" !== o.id && o.is && o.is(u, r, l, i)) return o;
                return v.getParserById("text")
            }

            function n(e) {
                var s, n, o, i, d, c, l, u, p, g, f = e.config,
                    m = f.$tbodies = f.$table.children("tbody:not(." + f.cssInfoBlock + ")"), h = 0, b = "",
                    y = m.length;
                if (0 === y) return f.debug ? t("Warning: *Empty table!* Not building a parser cache") : "";
                for (f.debug && (g = new Date, t("Detecting parsers for each column")), n = {
                    extractors: [],
                    parsers: []
                }; y > h;) {
                    if (s = m[h].rows, s.length) for (o = f.columns, i = 0; o > i; i++) d = f.$headers.filter('[data-column="' + i + '"]:last'), c = v.getColumnData(e, f.headers, i), p = v.getParserById(v.getData(d, c, "extractor")), u = v.getParserById(v.getData(d, c, "sorter")), l = "false" === v.getData(d, c, "parser"), f.empties[i] = (v.getData(d, c, "empty") || f.emptyTo || (f.emptyToBottom ? "bottom" : "top")).toLowerCase(), f.strings[i] = (v.getData(d, c, "string") || f.stringTo || "max").toLowerCase(), l && (u = v.getParserById("no-parser")), p || (p = !1), u || (u = a(e, s, -1, i)), f.debug && (b += "column:" + i + "; extractor:" + p.id + "; parser:" + u.id + "; string:" + f.strings[i] + "; empty: " + f.empties[i] + "\n"), n.parsers[i] = u, n.extractors[i] = p;
                    h += n.parsers.length ? y : 1
                }
                f.debug && (t(b ? b : "No parsers detected"), r("Completed detecting parsers", g)), f.parsers = n.parsers, f.extractors = n.extractors
            }

            function o(s) {
                var a, n, o, i, d, c, l, u, p, g, f, m, h, b = s.config, y = b.$tbodies, w = b.extractors,
                    x = b.parsers;
                if (b.cache = {}, b.totalRows = 0, !x) return b.debug ? t("Warning: *Empty table!* Not building a cache") : "";
                for (b.debug && (g = new Date), b.showProcessing && v.isProcessing(s, !0), l = 0; l < y.length; l++) {
                    for (h = [], a = b.cache[l] = {normalized: []}, f = y[l] && y[l].rows.length || 0, d = 0; f > d; ++d) if (m = {
                        child: [],
                        raw: []
                    }, u = e(y[l].rows[d]), p = [], u.hasClass(b.cssChildRow) && 0 !== d) n = a.normalized.length - 1, a.normalized[n][b.columns].$row = a.normalized[n][b.columns].$row.add(u), u.prev().hasClass(b.cssChildRow) || u.prev().addClass(v.css.cssHasChild), m.child[n] = e.trim(u[0].textContent || u.text() || ""); else {
                        for (m.$row = u, m.order = d, c = 0; c < b.columns; ++c) "undefined" != typeof x[c] ? (n = v.getElementText(b, u[0].cells[c], c), m.raw.push(n), o = "undefined" == typeof w[c].id ? n : w[c].format(n, s, u[0].cells[c], c), i = "no-parser" === x[c].id ? "" : x[c].format(o, s, u[0].cells[c], c), p.push(b.ignoreCase && "string" == typeof i ? i.toLowerCase() : i), "numeric" === (x[c].type || "").toLowerCase() && (h[c] = Math.max(Math.abs(i) || 0, h[c] || 0))) : b.debug && t("No parser found for cell:", u[0].cells[c], "does it have a header?");
                        p[b.columns] = m, a.normalized.push(p)
                    }
                    a.colMax = h, b.totalRows += a.normalized.length
                }
                b.showProcessing && v.isProcessing(s), b.debug && r("Building cache for " + f + " rows", g)
            }

            function i(e, t) {
                var a, n, o, i, d, c, l, u = e.config, p = u.widgetOptions, g = u.$tbodies, f = [], m = u.cache;
                if (s(m)) return u.appender ? u.appender(e, f) : e.isUpdating ? u.$table.trigger("updateComplete", e) : "";
                for (u.debug && (l = new Date), c = 0; c < g.length; c++) if (o = g.eq(c), o.length) {
                    for (i = v.processTbody(e, o, !0), a = m[c].normalized, n = a.length, d = 0; n > d; d++) f.push(a[d][u.columns].$row), u.appender && (!u.pager || u.pager.removeRows && p.pager_removeRows || u.pager.ajax) || i.append(a[d][u.columns].$row);
                    v.processTbody(e, i, !1)
                }
                u.appender && u.appender(e, f), u.debug && r("Rebuilt table", l), t || u.appender || v.applyWidget(e), e.isUpdating && u.$table.trigger("updateComplete", e)
            }

            function d(e) {
                return /^d/i.test(e) || 1 === e
            }

            function c(s) {
                var a, n, o, i, c, l, p, g = s.config;
                g.headerList = [], g.headerContent = [], g.debug && (p = new Date), g.columns = v.computeColumnIndex(g.$table.children("thead, tfoot").children("tr")), i = g.cssIcon ? '<i class="' + (g.cssIcon === v.css.icon ? v.css.icon : g.cssIcon + " " + v.css.icon) + '"></i>' : "", g.$headers = e(e.map(e(s).find(g.selectorHeaders), function (t, r) {
                    return n = e(t), n.parent().hasClass(g.cssIgnoreRow) ? void 0 : (a = v.getColumnData(s, g.headers, r, !0), g.headerContent[r] = n.html(), "" === g.headerTemplate || n.find("." + v.css.headerIn).length || (c = g.headerTemplate.replace(/\{content\}/g, n.html()).replace(/\{icon\}/g, n.find("." + v.css.icon).length ? "" : i), g.onRenderTemplate && (o = g.onRenderTemplate.apply(n, [r, c]), o && "string" == typeof o && (c = o)), n.html('<div class="' + v.css.headerIn + '">' + c + "</div>")), g.onRenderHeader && g.onRenderHeader.apply(n, [r, g, g.$table]), t.column = parseInt(n.attr("data-column"), 10), t.order = d(v.getData(n, a, "sortInitialOrder") || g.sortInitialOrder) ? [1, 0, 2] : [0, 1, 2], t.count = -1, t.lockedOrder = !1, l = v.getData(n, a, "lockedOrder") || !1, "undefined" != typeof l && l !== !1 && (t.order = t.lockedOrder = d(l) ? [1, 1, 1] : [0, 0, 0]), n.addClass(v.css.header + " " + g.cssHeader), g.headerList[r] = t, n.parent().addClass(v.css.headerRow + " " + g.cssHeaderRow).attr("role", "row"), g.tabIndex && n.attr("tabindex", 0), t)
                })), e(s).find(g.selectorHeaders).attr({
                    scope: "col",
                    role: "columnheader"
                }), u(s), g.debug && (r("Built headers:", p), t(g.$headers))
            }

            function l(e, t, r) {
                var s = e.config;
                s.$table.find(s.selectorRemove).remove(), n(e), o(e), y(s, t, r)
            }

            function u(t) {
                var r, s, a, n = t.config;
                n.$headers.each(function (o, i) {
                    s = e(i), a = v.getColumnData(t, n.headers, o, !0), r = "false" === v.getData(i, a, "sorter") || "false" === v.getData(i, a, "parser"), i.sortDisabled = r, s[r ? "addClass" : "removeClass"]("sorter-false").attr("aria-disabled", "" + r), t.id && (r ? s.removeAttr("aria-controls") : s.attr("aria-controls", t.id))
                })
            }

            function p(t) {
                var r, s, a, n = t.config, o = n.sortList, i = o.length, d = v.css.sortNone + " " + n.cssNone,
                    c = [v.css.sortAsc + " " + n.cssAsc, v.css.sortDesc + " " + n.cssDesc],
                    l = [n.cssIconAsc, n.cssIconDesc, n.cssIconNone], u = ["ascending", "descending"],
                    p = e(t).find("tfoot tr").children().add(n.$extraHeaders).removeClass(c.join(" "));
                for (n.$headers.removeClass(c.join(" ")).addClass(d).attr("aria-sort", "none").find("." + n.cssIcon).removeClass(l.join(" ")).addClass(l[2]), s = 0; i > s; s++) if (2 !== o[s][1] && (r = n.$headers.not(".sorter-false").filter('[data-column="' + o[s][0] + '"]' + (1 === i ? ":last" : "")), r.length)) {
                    for (a = 0; a < r.length; a++) r[a].sortDisabled || r.eq(a).removeClass(d).addClass(c[o[s][1]]).attr("aria-sort", u[o[s][1]]).find("." + n.cssIcon).removeClass(l[2]).addClass(l[o[s][1]]);
                    p.length && p.filter('[data-column="' + o[s][0] + '"]').removeClass(d).addClass(c[o[s][1]])
                }
                n.$headers.not(".sorter-false").each(function () {
                    var t = e(this), r = this.order[(this.count + 1) % (n.sortReset ? 3 : 2)],
                        s = e.trim(t.text()) + ": " + v.language[t.hasClass(v.css.sortAsc) ? "sortAsc" : t.hasClass(v.css.sortDesc) ? "sortDesc" : "sortNone"] + v.language[0 === r ? "nextAsc" : 1 === r ? "nextDesc" : "nextNone"];
                    t.attr("aria-label", s)
                })
            }

            function g(t, r) {
                var s, a, n, o, i, d = t.config, c = r || d.sortList;
                d.sortList = [], e.each(c, function (t, r) {
                    if (o = parseInt(r[0], 10), n = d.$headers.filter('[data-column="' + o + '"]:last')[0]) {
                        switch (a = ("" + r[1]).match(/^(1|d|s|o|n)/), a = a ? a[0] : "") {
                            case"1":
                            case"d":
                                a = 1;
                                break;
                            case"s":
                                a = i || 0;
                                break;
                            case"o":
                                s = n.order[(i || 0) % (d.sortReset ? 3 : 2)], a = 0 === s ? 1 : 1 === s ? 0 : 2;
                                break;
                            case"n":
                                n.count = n.count + 1, a = n.order[n.count % (d.sortReset ? 3 : 2)];
                                break;
                            default:
                                a = 0
                        }
                        i = 0 === t ? a : i, s = [o, parseInt(a, 10) || 0], d.sortList.push(s), a = e.inArray(s[1], n.order), n.count = a >= 0 ? a : s[1] % (d.sortReset ? 3 : 2)
                    }
                })
            }

            function f(e, t) {
                return e && e[t] ? e[t].type || "" : ""
            }

            function m(t, r, s) {
                if (t.isUpdating) return setTimeout(function () {
                    m(t, r, s)
                }, 50);
                var a, n, o, d, c, l = t.config, u = !s[l.sortMultiSortKey], g = l.$table;
                if (g.trigger("sortStart", t), r.count = s[l.sortResetKey] ? 2 : (r.count + 1) % (l.sortReset ? 3 : 2), l.sortRestart && (n = r, l.$headers.each(function () {
                    this === n || !u && e(this).is("." + v.css.sortDesc + ",." + v.css.sortAsc) || (this.count = -1)
                })), n = parseInt(e(r).attr("data-column"), 10), u) {
                    if (l.sortList = [], null !== l.sortForce) for (a = l.sortForce, o = 0; o < a.length; o++) a[o][0] !== n && l.sortList.push(a[o]);
                    if (d = r.order[r.count], 2 > d && (l.sortList.push([n, d]), r.colSpan > 1)) for (o = 1; o < r.colSpan; o++) l.sortList.push([n + o, d])
                } else {
                    if (l.sortAppend && l.sortList.length > 1) for (o = 0; o < l.sortAppend.length; o++) c = v.isValueInArray(l.sortAppend[o][0], l.sortList), c >= 0 && l.sortList.splice(c, 1);
                    if (v.isValueInArray(n, l.sortList) >= 0) for (o = 0; o < l.sortList.length; o++) c = l.sortList[o], d = l.$headers.filter('[data-column="' + c[0] + '"]:last')[0], c[0] === n && (c[1] = d.order[r.count], 2 === c[1] && (l.sortList.splice(o, 1), d.count = -1)); else if (d = r.order[r.count], 2 > d && (l.sortList.push([n, d]), r.colSpan > 1)) for (o = 1; o < r.colSpan; o++) l.sortList.push([n + o, d])
                }
                if (null !== l.sortAppend) for (a = l.sortAppend, o = 0; o < a.length; o++) a[o][0] !== n && l.sortList.push(a[o]);
                g.trigger("sortBegin", t), setTimeout(function () {
                    p(t), h(t), i(t), g.trigger("sortEnd", t)
                }, 1)
            }

            function h(e) {
                var t, a, n, o, i, d, c, l, u, p, g, m = 0, h = e.config, b = h.textSorter || "", y = h.sortList,
                    w = y.length, x = h.$tbodies.length;
                if (!h.serverSideSorting && !s(h.cache)) {
                    for (h.debug && (i = new Date), a = 0; x > a; a++) d = h.cache[a].colMax, c = h.cache[a].normalized, c.sort(function (r, s) {
                        for (t = 0; w > t; t++) {
                            if (o = y[t][0], l = y[t][1], m = 0 === l, h.sortStable && r[o] === s[o] && 1 === w) return r[h.columns].order - s[h.columns].order;
                            if (n = /n/i.test(f(h.parsers, o)), n && h.strings[o] ? (n = "boolean" == typeof h.string[h.strings[o]] ? (m ? 1 : -1) * (h.string[h.strings[o]] ? -1 : 1) : h.strings[o] ? h.string[h.strings[o]] || 0 : 0, u = h.numberSorter ? h.numberSorter(r[o], s[o], m, d[o], e) : v["sortNumeric" + (m ? "Asc" : "Desc")](r[o], s[o], n, d[o], o, e)) : (p = m ? r : s, g = m ? s : r, u = "function" == typeof b ? b(p[o], g[o], m, o, e) : "object" == typeof b && b.hasOwnProperty(o) ? b[o](p[o], g[o], m, o, e) : v["sortNatural" + (m ? "Asc" : "Desc")](r[o], s[o], o, e, h)), u) return u
                        }
                        return r[h.columns].order - s[h.columns].order
                    });
                    h.debug && r("Sorting on " + y.toString() + " and dir " + l + " time", i)
                }
            }

            function b(t, r) {
                t.table.isUpdating && t.$table.trigger("updateComplete", t.table), e.isFunction(r) && r(t.table)
            }

            function y(t, r, s) {
                var a = e.isArray(r) ? r : t.sortList, n = "undefined" == typeof r ? t.resort : r;
                n === !1 || t.serverSideSorting || t.table.isProcessing ? (b(t, s), v.applyWidget(t.table, !1)) : a.length ? t.$table.trigger("sorton", [a, function () {
                    b(t, s)
                }, !0]) : t.$table.trigger("sortReset", [function () {
                    b(t, s), v.applyWidget(t.table, !1)
                }])
            }

            function w(t) {
                var r = t.config, a = r.$table,
                    d = "sortReset update updateRows updateCell updateAll addRows updateComplete sorton appendCache updateCache applyWidgetId applyWidgets refreshWidgets destroy mouseup mouseleave ".split(" ").join(r.namespace + " ");
                a.unbind(d.replace(/\s+/g, " ")).bind("sortReset" + r.namespace, function (s, a) {
                    s.stopPropagation(), r.sortList = [], p(t), h(t), i(t), e.isFunction(a) && a(t)
                }).bind("updateAll" + r.namespace, function (e, s, a) {
                    e.stopPropagation(), t.isUpdating = !0, v.refreshWidgets(t, !0, !0), c(t), v.bindEvents(t, r.$headers, !0), w(t), l(t, s, a)
                }).bind("update" + r.namespace + " updateRows" + r.namespace, function (e, r, s) {
                    e.stopPropagation(), t.isUpdating = !0, u(t), l(t, r, s)
                }).bind("updateCell" + r.namespace, function (s, n, o, i) {
                    s.stopPropagation(), t.isUpdating = !0, a.find(r.selectorRemove).remove();
                    var d, c, l, u, p = r.$tbodies, g = e(n),
                        f = p.index(e.fn.closest ? g.closest("tbody") : g.parents("tbody").filter(":first")),
                        m = e.fn.closest ? g.closest("tr") : g.parents("tr").filter(":first");
                    n = g[0], p.length && f >= 0 && (l = p.eq(f).find("tr").index(m), u = g.index(), r.cache[f].normalized[l][r.columns].$row = m, c = "undefined" == typeof r.extractors[u].id ? v.getElementText(r, n, u) : r.extractors[u].format(v.getElementText(r, n, u), t, n, u), d = "no-parser" === r.parsers[u].id ? "" : r.parsers[u].format(c, t, n, u), r.cache[f].normalized[l][u] = r.ignoreCase && "string" == typeof d ? d.toLowerCase() : d, "numeric" === (r.parsers[u].type || "").toLowerCase() && (r.cache[f].colMax[u] = Math.max(Math.abs(d) || 0, r.cache[f].colMax[u] || 0)), d = "undefined" !== o ? o : r.resort, d !== !1 ? y(r, d, i) : (e.isFunction(i) && i(t), r.$table.trigger("updateComplete", r.table)))
                }).bind("addRows" + r.namespace, function (a, o, i, d) {
                    if (a.stopPropagation(), t.isUpdating = !0, s(r.cache)) u(t), l(t, i, d); else {
                        o = e(o).attr("role", "row");
                        var c, p, g, f, m, h, b, w = o.filter("tr").length,
                            x = r.$tbodies.index(o.parents("tbody").filter(":first"));
                        for (r.parsers && r.parsers.length || n(t), c = 0; w > c; c++) {
                            for (g = o[c].cells.length, b = [], h = {
                                child: [],
                                $row: o.eq(c),
                                order: r.cache[x].normalized.length
                            }, p = 0; g > p; p++) f = "undefined" == typeof r.extractors[p].id ? v.getElementText(r, o[c].cells[p], p) : r.extractors[p].format(v.getElementText(r, o[c].cells[p], p), t, o[c].cells[p], p), m = "no-parser" === r.parsers[p].id ? "" : r.parsers[p].format(f, t, o[c].cells[p], p), b[p] = r.ignoreCase && "string" == typeof m ? m.toLowerCase() : m, "numeric" === (r.parsers[p].type || "").toLowerCase() && (r.cache[x].colMax[p] = Math.max(Math.abs(b[p]) || 0, r.cache[x].colMax[p] || 0));
                            b.push(h), r.cache[x].normalized.push(b)
                        }
                        y(r, i, d)
                    }
                }).bind("updateComplete" + r.namespace, function () {
                    t.isUpdating = !1
                }).bind("sorton" + r.namespace, function (r, n, d, c) {
                    var l = t.config;
                    r.stopPropagation(), a.trigger("sortStart", this), g(t, n), p(t), l.delayInit && s(l.cache) && o(t), a.trigger("sortBegin", this), h(t), i(t, c), a.trigger("sortEnd", this), v.applyWidget(t), e.isFunction(d) && d(t)
                }).bind("appendCache" + r.namespace, function (r, s, a) {
                    r.stopPropagation(), i(t, a), e.isFunction(s) && s(t)
                }).bind("updateCache" + r.namespace, function (s, a) {
                    r.parsers && r.parsers.length || n(t), o(t), e.isFunction(a) && a(t)
                }).bind("applyWidgetId" + r.namespace, function (e, s) {
                    e.stopPropagation(), v.getWidgetById(s).format(t, r, r.widgetOptions)
                }).bind("applyWidgets" + r.namespace, function (e, r) {
                    e.stopPropagation(), v.applyWidget(t, r)
                }).bind("refreshWidgets" + r.namespace, function (e, r, s) {
                    e.stopPropagation(), v.refreshWidgets(t, r, s)
                }).bind("destroy" + r.namespace, function (e, r, s) {
                    e.stopPropagation(), v.destroy(t, r, s)
                }).bind("resetToLoadState" + r.namespace, function () {
                    v.removeWidget(t, !0, !1), r = e.extend(!0, v.defaults, r.originalSettings), t.hasInitialized = !1, v.setup(t, r)
                })
            }

            var v = this;
            v.version = "{{version}}", v.parsers = [], v.widgets = [], v.defaults = {
                theme: "default",
                widthFixed: !1,
                showProcessing: !1,
                headerTemplate: "{content}",
                onRenderTemplate: null,
                onRenderHeader: null,
                cancelSelection: !0,
                tabIndex: !0,
                dateFormat: "mmddyyyy",
                sortMultiSortKey: "shiftKey",
                sortResetKey: "ctrlKey",
                usNumberFormat: !0,
                delayInit: !1,
                serverSideSorting: !1,
                resort: !0,
                headers: {},
                ignoreCase: !0,
                sortForce: null,
                sortList: [],
                sortAppend: null,
                sortStable: !1,
                sortInitialOrder: "asc",
                sortLocaleCompare: !1,
                sortReset: !1,
                sortRestart: !1,
                emptyTo: "bottom",
                stringTo: "max",
                textExtraction: "basic",
                textAttribute: "data-text",
                textSorter: null,
                numberSorter: null,
                widgets: [],
                widgetOptions: {zebra: ["even", "odd"]},
                initWidgets: !0,
                widgetClass: "widget-{name}",
                initialized: null,
                tableClass: "",
                cssAsc: "",
                cssDesc: "",
                cssNone: "",
                cssHeader: "",
                cssHeaderRow: "",
                cssProcessing: "",
                cssChildRow: "tablesorter-childRow",
                cssIcon: "tablesorter-icon",
                cssIconNone: "",
                cssIconAsc: "",
                cssIconDesc: "",
                cssInfoBlock: "tablesorter-infoOnly",
                cssNoSort: "tablesorter-noSort",
                cssIgnoreRow: "tablesorter-ignoreRow",
                selectorHeaders: "> thead th, > thead td",
                selectorSort: "th, td",
                selectorRemove: ".remove-me",
                debug: !1,
                headerList: [],
                empties: {},
                strings: {},
                parsers: []
            }, v.css = {
                table: "tablesorter",
                cssHasChild: "tablesorter-hasChildRow",
                childRow: "tablesorter-childRow",
                colgroup: "tablesorter-colgroup",
                header: "tablesorter-header",
                headerRow: "tablesorter-headerRow",
                headerIn: "tablesorter-header-inner",
                icon: "tablesorter-icon",
                processing: "tablesorter-processing",
                sortAsc: "tablesorter-headerAsc",
                sortDesc: "tablesorter-headerDesc",
                sortNone: "tablesorter-headerUnSorted"
            }, v.language = {
                sortAsc: "Ascending sort applied, ",
                sortDesc: "Descending sort applied, ",
                sortNone: "No sort applied, ",
                nextAsc: "activate to apply an ascending sort",
                nextDesc: "activate to apply a descending sort",
                nextNone: "activate to remove the sort"
            }, v.log = t, v.benchmark = r, v.getElementText = function (t, r, s) {
                if (!r) return "";
                var a, n = t.textExtraction || "", o = r.jquery ? r : e(r);
                return e.trim("string" == typeof n ? ("basic" === n ? o.attr(t.textAttribute) || r.textContent : r.textContent) || o.text() || "" : "function" == typeof n ? n(o[0], t.table, s) : "function" == typeof (a = v.getColumnData(t.table, n, s)) ? a(o[0], t.table, s) : o[0].textContent || o.text() || "")
            }, v.construct = function (t) {
                return this.each(function () {
                    var r = this, s = e.extend(!0, {}, v.defaults, t);
                    s.originalSettings = t, !r.hasInitialized && v.buildTable && "TABLE" !== this.tagName ? v.buildTable(r, s) : v.setup(r, s)
                })
            }, v.setup = function (r, s) {
                if (!r || !r.tHead || 0 === r.tBodies.length || r.hasInitialized === !0) return s.debug ? t("ERROR: stopping initialization! No table, thead, tbody or tablesorter has already been initialized") : "";
                var a = "", i = e(r), d = e.metadata;
                r.hasInitialized = !1, r.isProcessing = !0, r.config = s, e.data(r, "tablesorter", s), s.debug && e.data(r, "startoveralltimer", new Date), s.supportsDataObject = function (e) {
                    return e[0] = parseInt(e[0], 10), e[0] > 1 || 1 === e[0] && parseInt(e[1], 10) >= 4
                }(e.fn.jquery.split(".")), s.string = {
                    max: 1,
                    min: -1,
                    emptymin: 1,
                    emptymax: -1,
                    zero: 0,
                    none: 0,
                    "null": 0,
                    top: !0,
                    bottom: !1
                }, s.emptyTo = s.emptyTo.toLowerCase(), s.stringTo = s.stringTo.toLowerCase(), /tablesorter\-/.test(i.attr("class")) || (a = "" !== s.theme ? " tablesorter-" + s.theme : ""), s.table = r, s.$table = i.addClass(v.css.table + " " + s.tableClass + a).attr("role", "grid"), s.$headers = i.find(s.selectorHeaders), s.namespace = s.namespace ? "." + s.namespace.replace(/\W/g, "") : ".tablesorter" + Math.random().toString(16).slice(2), s.$table.children().children("tr").attr("role", "row"), s.$tbodies = i.children("tbody:not(." + s.cssInfoBlock + ")").attr({
                    "aria-live": "polite",
                    "aria-relevant": "all"
                }), s.$table.children("caption").length && (a = s.$table.children("caption")[0], a.id || (a.id = s.namespace.slice(1) + "caption"), s.$table.attr("aria-labelledby", a.id)), s.widgetInit = {}, s.textExtraction = s.$table.attr("data-text-extraction") || s.textExtraction || "basic", c(r), v.fixColumnWidth(r), n(r), s.totalRows = 0, s.delayInit || o(r), v.bindEvents(r, s.$headers, !0), w(r), s.supportsDataObject && "undefined" != typeof i.data().sortlist ? s.sortList = i.data().sortlist : d && i.metadata() && i.metadata().sortlist && (s.sortList = i.metadata().sortlist), v.applyWidget(r, !0), s.sortList.length > 0 ? i.trigger("sorton", [s.sortList, {}, !s.initWidgets, !0]) : (p(r), s.initWidgets && v.applyWidget(r, !1)), s.showProcessing && i.unbind("sortBegin" + s.namespace + " sortEnd" + s.namespace).bind("sortBegin" + s.namespace + " sortEnd" + s.namespace, function (e) {
                    clearTimeout(s.processTimer), v.isProcessing(r), "sortBegin" === e.type && (s.processTimer = setTimeout(function () {
                        v.isProcessing(r, !0)
                    }, 500))
                }), r.hasInitialized = !0, r.isProcessing = !1, s.debug && v.benchmark("Overall initialization time", e.data(r, "startoveralltimer")), i.trigger("tablesorter-initialized", r), "function" == typeof s.initialized && s.initialized(r)
            }, v.fixColumnWidth = function (t) {
                t = e(t)[0];
                var r, s, a = t.config, n = a.$table.children("colgroup");
                n.length && n.hasClass(v.css.colgroup) && n.remove(), a.widthFixed && 0 === a.$table.children("colgroup").length && (n = e('<colgroup class="' + v.css.colgroup + '">'), r = a.$table.width(), a.$tbodies.find("tr:first").children(":visible").each(function () {
                    s = parseInt(e(this).width() / r * 1e3, 10) / 10 + "%", n.append(e("<col>").css("width", s))
                }), a.$table.prepend(n))
            }, v.getColumnData = function (t, r, s, a, n) {
                if ("undefined" != typeof r && null !== r) {
                    t = e(t)[0];
                    var o, i, d = t.config, c = n || d.$headers;
                    if (r[s]) return a ? r[s] : r[c.index(c.filter('[data-column="' + s + '"]:last'))];
                    for (i in r) if ("string" == typeof i && (o = c.filter('[data-column="' + s + '"]:last').filter(i).add(c.filter('[data-column="' + s + '"]:last').find(i)), o.length)) return r[i]
                }
            }, v.computeColumnIndex = function (t) {
                var r, s, a, n, o, i, d, c, l, u, p, g, f, m = [], h = {}, b = 0;
                for (r = 0; r < t.length; r++) for (d = t[r].cells, s = 0; s < d.length; s++) {
                    for (i = d[s], o = e(i), c = i.parentNode.rowIndex, l = c + "-" + o.index(), u = i.rowSpan || 1, p = i.colSpan || 1, "undefined" == typeof m[c] && (m[c] = []), a = 0; a < m[c].length + 1; a++) if ("undefined" == typeof m[c][a]) {
                        g = a;
                        break
                    }
                    for (h[l] = g, b = Math.max(g, b), o.attr({"data-column": g}), a = c; c + u > a; a++) for ("undefined" == typeof m[a] && (m[a] = []), f = m[a], n = g; g + p > n; n++) f[n] = "x"
                }
                return b + 1
            }, v.isProcessing = function (t, r, s) {
                t = e(t);
                var a = t[0].config, n = s || t.find("." + v.css.header);
                r ? ("undefined" != typeof s && a.sortList.length > 0 && (n = n.filter(function () {
                    return this.sortDisabled ? !1 : v.isValueInArray(parseFloat(e(this).attr("data-column")), a.sortList) >= 0
                })), t.add(n).addClass(v.css.processing + " " + a.cssProcessing)) : t.add(n).removeClass(v.css.processing + " " + a.cssProcessing)
            }, v.processTbody = function (t, r, s) {
                t = e(t)[0];
                var a;
                return s ? (t.isProcessing = !0, r.before('<span class="tablesorter-savemyplace"/>'), a = e.fn.detach ? r.detach() : r.remove()) : (a = e(t).find("span.tablesorter-savemyplace"), r.insertAfter(a), a.remove(), void (t.isProcessing = !1))
            }, v.clearTableBody = function (t) {
                e(t)[0].config.$tbodies.children().detach()
            }, v.bindEvents = function (t, r, a) {
                t = e(t)[0];
                var n, i = t.config;
                a !== !0 && (i.$extraHeaders = i.$extraHeaders ? i.$extraHeaders.add(r) : r), r.find(i.selectorSort).add(r.filter(i.selectorSort)).unbind("mousedown mouseup sort keyup ".split(" ").join(i.namespace + " ").replace(/\s+/g, " ")).bind("mousedown mouseup sort keyup ".split(" ").join(i.namespace + " "), function (a, d) {
                    var c, l = e(a.target), u = a.type;
                    if (!(1 !== (a.which || a.button) && !/sort|keyup/.test(u) || "keyup" === u && 13 !== a.which || "mouseup" === u && d !== !0 && (new Date).getTime() - n > 250)) {
                        if ("mousedown" === u) return void (n = (new Date).getTime());
                        if (c = e.fn.closest ? l.closest("td,th") : l.parents("td,th").filter(":first"), /(input|select|button|textarea)/i.test(a.target.tagName) || l.hasClass(i.cssNoSort) || l.parents("." + i.cssNoSort).length > 0 || l.parents("button").length > 0) return !i.cancelSelection;
                        i.delayInit && s(i.cache) && o(t), c = e.fn.closest ? e(this).closest("th, td")[0] : /TH|TD/.test(this.tagName) ? this : e(this).parents("th, td")[0], c = i.$headers[r.index(c)], c.sortDisabled || m(t, c, a)
                    }
                }), i.cancelSelection && r.attr("unselectable", "on").bind("selectstart", !1).css({
                    "user-select": "none",
                    MozUserSelect: "none"
                })
            }, v.restoreHeaders = function (t) {
                var r, s = e(t)[0].config;
                s.$table.find(s.selectorHeaders).each(function (t) {
                    r = e(this), r.find("." + v.css.headerIn).length && r.html(s.headerContent[t])
                })
            }, v.destroy = function (t, r, s) {
                if (t = e(t)[0], t.hasInitialized) {
                    v.removeWidget(t, !0, !1);
                    var a, n = e(t), o = t.config, i = n.find("thead:first"),
                        d = i.find("tr." + v.css.headerRow).removeClass(v.css.headerRow + " " + o.cssHeaderRow),
                        c = n.find("tfoot:first > tr").children("th, td");
                    r === !1 && e.inArray("uitheme", o.widgets) >= 0 && (n.trigger("applyWidgetId", ["uitheme"]), n.trigger("applyWidgetId", ["zebra"])), i.find("tr").not(d).remove(), a = "sortReset update updateAll updateRows updateCell addRows updateComplete sorton appendCache updateCache " + "applyWidgetId applyWidgets refreshWidgets destroy mouseup mouseleave keypress sortBegin sortEnd resetToLoadState ".split(" ").join(o.namespace + " "), n.removeData("tablesorter").unbind(a.replace(/\s+/g, " ")), o.$headers.add(c).removeClass([v.css.header, o.cssHeader, o.cssAsc, o.cssDesc, v.css.sortAsc, v.css.sortDesc, v.css.sortNone].join(" ")).removeAttr("data-column").removeAttr("aria-label").attr("aria-disabled", "true"), d.find(o.selectorSort).unbind("mousedown mouseup keypress ".split(" ").join(o.namespace + " ").replace(/\s+/g, " ")), v.restoreHeaders(t), n.toggleClass(v.css.table + " " + o.tableClass + " tablesorter-" + o.theme, r === !1), t.hasInitialized = !1, delete t.config.cache, "function" == typeof s && s(t)
                }
            }, v.regex = {
                chunk: /(^([+\-]?(?:0|[1-9]\d*)(?:\.\d*)?(?:[eE][+\-]?\d+)?)?$|^0x[0-9a-f]+$|\d+)/gi,
                chunks: /(^\\0|\\0$)/,
                hex: /^0x[0-9a-f]+$/i
            }, v.sortNatural = function (e, t) {
                if (e === t) return 0;
                var r, s, a, n, o, i, d, c, l = v.regex;
                if (l.hex.test(t)) {
                    if (s = parseInt(e.match(l.hex), 16), n = parseInt(t.match(l.hex), 16), n > s) return -1;
                    if (s > n) return 1
                }
                for (r = e.replace(l.chunk, "\\0$1\\0").replace(l.chunks, "").split("\\0"), a = t.replace(l.chunk, "\\0$1\\0").replace(l.chunks, "").split("\\0"), c = Math.max(r.length, a.length), d = 0; c > d; d++) {
                    if (o = isNaN(r[d]) ? r[d] || 0 : parseFloat(r[d]) || 0, i = isNaN(a[d]) ? a[d] || 0 : parseFloat(a[d]) || 0, isNaN(o) !== isNaN(i)) return isNaN(o) ? 1 : -1;
                    if (typeof o != typeof i && (o += "", i += ""), i > o) return -1;
                    if (o > i) return 1
                }
                return 0
            }, v.sortNaturalAsc = function (e, t, r, s, a) {
                if (e === t) return 0;
                var n = a.string[a.empties[r] || a.emptyTo];
                return "" === e && 0 !== n ? "boolean" == typeof n ? n ? -1 : 1 : -n || -1 : "" === t && 0 !== n ? "boolean" == typeof n ? n ? 1 : -1 : n || 1 : v.sortNatural(e, t)
            }, v.sortNaturalDesc = function (e, t, r, s, a) {
                if (e === t) return 0;
                var n = a.string[a.empties[r] || a.emptyTo];
                return "" === e && 0 !== n ? "boolean" == typeof n ? n ? -1 : 1 : n || 1 : "" === t && 0 !== n ? "boolean" == typeof n ? n ? 1 : -1 : -n || -1 : v.sortNatural(t, e)
            }, v.sortText = function (e, t) {
                return e > t ? 1 : t > e ? -1 : 0
            }, v.getTextValue = function (e, t, r) {
                if (r) {
                    var s, a = e ? e.length : 0, n = r + t;
                    for (s = 0; a > s; s++) n += e.charCodeAt(s);
                    return t * n
                }
                return 0
            }, v.sortNumericAsc = function (e, t, r, s, a, n) {
                if (e === t) return 0;
                var o = n.config, i = o.string[o.empties[a] || o.emptyTo];
                return "" === e && 0 !== i ? "boolean" == typeof i ? i ? -1 : 1 : -i || -1 : "" === t && 0 !== i ? "boolean" == typeof i ? i ? 1 : -1 : i || 1 : (isNaN(e) && (e = v.getTextValue(e, r, s)), isNaN(t) && (t = v.getTextValue(t, r, s)), e - t)
            }, v.sortNumericDesc = function (e, t, r, s, a, n) {
                if (e === t) return 0;
                var o = n.config, i = o.string[o.empties[a] || o.emptyTo];
                return "" === e && 0 !== i ? "boolean" == typeof i ? i ? -1 : 1 : i || 1 : "" === t && 0 !== i ? "boolean" == typeof i ? i ? 1 : -1 : -i || -1 : (isNaN(e) && (e = v.getTextValue(e, r, s)), isNaN(t) && (t = v.getTextValue(t, r, s)), t - e)
            }, v.sortNumeric = function (e, t) {
                return e - t
            }, v.characterEquivalents = {
                a: "áàâãäąå",
                A: "ÁÀÂÃÄĄÅ",
                c: "çćč",
                C: "ÇĆČ",
                e: "éèêëěę",
                E: "ÉÈÊËĚĘ",
                i: "íìİîïı",
                I: "ÍÌİÎÏ",
                o: "óòôõö",
                O: "ÓÒÔÕÖ",
                ss: "ß",
                SS: "ẞ",
                u: "úùûüů",
                U: "ÚÙÛÜŮ"
            }, v.replaceAccents = function (e) {
                var t, r = "[", s = v.characterEquivalents;
                if (!v.characterRegex) {
                    v.characterRegexArray = {};
                    for (t in s) "string" == typeof t && (r += s[t], v.characterRegexArray[t] = new RegExp("[" + s[t] + "]", "g"));
                    v.characterRegex = new RegExp(r + "]")
                }
                if (v.characterRegex.test(e)) for (t in s) "string" == typeof t && (e = e.replace(v.characterRegexArray[t], t));
                return e
            }, v.isValueInArray = function (e, t) {
                var r, s = t.length;
                for (r = 0; s > r; r++) if (t[r][0] === e) return r;
                return -1
            }, v.addParser = function (e) {
                var t, r = v.parsers.length, s = !0;
                for (t = 0; r > t; t++) v.parsers[t].id.toLowerCase() === e.id.toLowerCase() && (s = !1);
                s && v.parsers.push(e)
            }, v.getParserById = function (e) {
                if ("false" == e) return !1;
                var t, r = v.parsers.length;
                for (t = 0; r > t; t++) if (v.parsers[t].id.toLowerCase() === e.toString().toLowerCase()) return v.parsers[t];
                return !1
            }, v.addWidget = function (e) {
                v.widgets.push(e)
            }, v.hasWidget = function (t, r) {
                return t = e(t), t.length && t[0].config && t[0].config.widgetInit[r] || !1
            }, v.getWidgetById = function (e) {
                var t, r, s = v.widgets.length;
                for (t = 0; s > t; t++) if (r = v.widgets[t], r && r.hasOwnProperty("id") && r.id.toLowerCase() === e.toLowerCase()) return r
            }, v.applyWidget = function (t, s, a) {
                t = e(t)[0];
                var n, o, i, d, c = t.config, l = c.widgetOptions, u = " " + c.table.className + " ", p = [];
                s !== !1 && t.hasInitialized && (t.isApplyingWidgets || t.isUpdating) || (c.debug && (n = new Date), d = new RegExp("\\s" + c.widgetClass.replace(/\{name\}/i, "([\\w-]+)") + "\\s", "g"), u.match(d) && (i = u.match(d), i && e.each(i, function (e, t) {
                    c.widgets.push(t.replace(d, "$1"))
                })), c.widgets.length && (t.isApplyingWidgets = !0, c.widgets = e.grep(c.widgets, function (t, r) {
                    return e.inArray(t, c.widgets) === r
                }), e.each(c.widgets || [], function (e, t) {
                    d = v.getWidgetById(t), d && d.id && (d.priority || (d.priority = 10), p[e] = d)
                }), p.sort(function (e, t) {
                    return e.priority < t.priority ? -1 : e.priority === t.priority ? 0 : 1
                }), e.each(p, function (r, a) {
                    a && ((s || !c.widgetInit[a.id]) && (c.widgetInit[a.id] = !0, a.hasOwnProperty("options") && (l = t.config.widgetOptions = e.extend(!0, {}, a.options, l)), a.hasOwnProperty("init") && (c.debug && (o = new Date), a.init(t, a, c, l), c.debug && v.benchmark("Initializing " + a.id + " widget", o))), !s && a.hasOwnProperty("format") && (c.debug && (o = new Date), a.format(t, c, l, !1), c.debug && v.benchmark((s ? "Initializing " : "Applying ") + a.id + " widget", o)))
                }), s || "function" != typeof a || a(t)), setTimeout(function () {
                    t.isApplyingWidgets = !1, e.data(t, "lastWidgetApplication", new Date)
                }, 0), c.debug && (i = c.widgets.length, r("Completed " + (s === !0 ? "initializing " : "applying ") + i + " widget" + (1 !== i ? "s" : ""), n)))
            }, v.removeWidget = function (r, s, a) {
                r = e(r)[0], s === !0 ? (s = [], e.each(v.widgets, function (e, t) {
                    t && t.id && s.push(t.id)
                })) : s = (e.isArray(s) ? s.join(",") : s || "").toLowerCase().split(/[\s,]+/);
                var n, o, i, d = r.config, c = s.length;
                for (n = 0; c > n; n++) o = v.getWidgetById(s[n]), i = e.inArray(s[n], d.widgets), o && "remove" in o && (d.debug && i >= 0 && t('Removing "' + s[n] + '" widget'), o.remove(r, d, d.widgetOptions, a), d.widgetInit[s[n]] = !1), i >= 0 && a !== !0 && d.widgets.splice(i, 1)
            }, v.refreshWidgets = function (t, r, s) {
                t = e(t)[0];
                var a = t.config, n = a.widgets, o = [], i = function (t) {
                    e(t).trigger("refreshComplete")
                };
                e.each(v.widgets, function (t, s) {
                    s && s.id && (r || e.inArray(s.id, n) < 0) && o.push(s.id)
                }), v.removeWidget(t, o.join(","), !0), s !== !0 ? (v.applyWidget(t, r || !1, i), r && v.applyWidget(t, !1, i)) : i(t)
            }, v.getData = function (t, r, s) {
                var a, n, o = "", i = e(t);
                return i.length ? (a = e.metadata ? i.metadata() : !1, n = " " + (i.attr("class") || ""), "undefined" != typeof i.data(s) || "undefined" != typeof i.data(s.toLowerCase()) ? o += i.data(s) || i.data(s.toLowerCase()) : a && "undefined" != typeof a[s] ? o += a[s] : r && "undefined" != typeof r[s] ? o += r[s] : " " !== n && n.match(" " + s + "-") && (o = n.match(new RegExp("\\s" + s + "-([\\w-]+)"))[1] || ""), e.trim(o)) : ""
            }, v.formatFloat = function (t, r) {
                if ("string" != typeof t || "" === t) return t;
                var s, a = r && r.config ? r.config.usNumberFormat !== !1 : "undefined" != typeof r ? r : !0;
                return t = a ? t.replace(/,/g, "") : t.replace(/[\s|\.]/g, "").replace(/,/g, "."), /^\s*\([.\d]+\)/.test(t) && (t = t.replace(/^\s*\(([.\d]+)\)/, "-$1")), s = parseFloat(t), isNaN(s) ? e.trim(t) : s
            }, v.isDigit = function (e) {
                return isNaN(e) ? /^[\-+(]?\d+[)]?$/.test(e.toString().replace(/[,.'"\s]/g, "")) : !0
            }
        }
    });
    var t = e.tablesorter;
    return e.fn.extend({tablesorter: t.construct}), t.addParser({
        id: "no-parser", is: function () {
            return !1
        }, format: function () {
            return ""
        }, type: "text"
    }), t.addParser({
        id: "text", is: function () {
            return !0
        }, format: function (r, s) {
            var a = s.config;
            return r && (r = e.trim(a.ignoreCase ? r.toLocaleLowerCase() : r), r = a.sortLocaleCompare ? t.replaceAccents(r) : r), r
        }, type: "text"
    }), t.addParser({
        id: "digit", is: function (e) {
            return t.isDigit(e)
        }, format: function (r, s) {
            var a = t.formatFloat((r || "").replace(/[^\w,. \-()]/g, ""), s);
            return r && "number" == typeof a ? a : r ? e.trim(r && s.config.ignoreCase ? r.toLocaleLowerCase() : r) : r
        }, type: "numeric"
    }), t.addParser({
        id: "currency", is: function (e) {
            return /^\(?\d+[\u00a3$\u20ac\u00a4\u00a5\u00a2?.]|[\u00a3$\u20ac\u00a4\u00a5\u00a2?.]\d+\)?$/.test((e || "").replace(/[+\-,. ]/g, ""))
        }, format: function (r, s) {
            var a = t.formatFloat((r || "").replace(/[^\w,. \-()]/g, ""), s);
            return r && "number" == typeof a ? a : r ? e.trim(r && s.config.ignoreCase ? r.toLocaleLowerCase() : r) : r
        }, type: "numeric"
    }), t.addParser({
        id: "url", is: function (e) {
            return /^(https?|ftp|file):\/\//.test(e)
        }, format: function (t) {
            return t ? e.trim(t.replace(/(https?|ftp|file):\/\//, "")) : t
        }, parsed: !0, type: "text"
    }), t.addParser({
        id: "isoDate", is: function (e) {
            return /^\d{4}[\/\-]\d{1,2}[\/\-]\d{1,2}/.test(e)
        }, format: function (e) {
            var t = e ? new Date(e.replace(/-/g, "/")) : e;
            return t instanceof Date && isFinite(t) ? t.getTime() : e
        }, type: "numeric"
    }), t.addParser({
        id: "percent", is: function (e) {
            return /(\d\s*?%|%\s*?\d)/.test(e) && e.length < 15
        }, format: function (e, r) {
            return e ? t.formatFloat(e.replace(/%/g, ""), r) : e
        }, type: "numeric"
    }), t.addParser({
        id: "image", is: function (e, t, r, s) {
            return s.find("img").length > 0
        }, format: function (t, r, s) {
            return e(s).find("img").attr(r.config.imgAttr || "alt") || t
        }, parsed: !0, type: "text"
    }), t.addParser({
        id: "usLongDate", is: function (e) {
            return /^[A-Z]{3,10}\.?\s+\d{1,2},?\s+(\d{4})(\s+\d{1,2}:\d{2}(:\d{2})?(\s+[AP]M)?)?$/i.test(e) || /^\d{1,2}\s+[A-Z]{3,10}\s+\d{4}/i.test(e)
        }, format: function (e) {
            var t = e ? new Date(e.replace(/(\S)([AP]M)$/i, "$1 $2")) : e;
            return t instanceof Date && isFinite(t) ? t.getTime() : e
        }, type: "numeric"
    }), t.addParser({
        id: "shortDate", is: function (e) {
            return /(^\d{1,2}[\/\s]\d{1,2}[\/\s]\d{4})|(^\d{4}[\/\s]\d{1,2}[\/\s]\d{1,2})/.test((e || "").replace(/\s+/g, " ").replace(/[\-.,]/g, "/"))
        }, format: function (e, r, s, a) {
            if (e) {
                var n, o, i = r.config, d = i.$headers.filter('[data-column="' + a + '"]:last'),
                    c = d.length && d[0].dateFormat || t.getData(d, t.getColumnData(r, i.headers, a), "dateFormat") || i.dateFormat;
                return o = e.replace(/\s+/g, " ").replace(/[\-.,]/g, "/"), "mmddyyyy" === c ? o = o.replace(/(\d{1,2})[\/\s](\d{1,2})[\/\s](\d{4})/, "$3/$1/$2") : "ddmmyyyy" === c ? o = o.replace(/(\d{1,2})[\/\s](\d{1,2})[\/\s](\d{4})/, "$3/$2/$1") : "yyyymmdd" === c && (o = o.replace(/(\d{4})[\/\s](\d{1,2})[\/\s](\d{1,2})/, "$1/$2/$3")), n = new Date(o), n instanceof Date && isFinite(n) ? n.getTime() : e
            }
            return e
        }, type: "numeric"
    }), t.addParser({
        id: "time", is: function (e) {
            return /^(([0-2]?\d:[0-5]\d)|([0-1]?\d:[0-5]\d\s?([AP]M)))$/i.test(e)
        }, format: function (e) {
            var t = e ? new Date("2000/01/01 " + e.replace(/(\S)([AP]M)$/i, "$1 $2")) : e;
            return t instanceof Date && isFinite(t) ? t.getTime() : e
        }, type: "numeric"
    }), t.addParser({
        id: "metadata", is: function () {
            return !1
        }, format: function (t, r, s) {
            var a = r.config, n = a.parserMetadataName ? a.parserMetadataName : "sortValue";
            return e(s).metadata()[n]
        }, type: "numeric"
    }), t.addWidget({
        id: "zebra", priority: 90, format: function (t, r, s) {
            var a, n, o, i, d, c, l, u = new RegExp(r.cssChildRow, "i"), p = r.$tbodies;
            for (r.debug && (c = new Date), l = 0; l < p.length; l++) i = 0, a = p.eq(l), n = a.children("tr:visible").not(r.selectorRemove), n.each(function () {
                o = e(this), u.test(this.className) || i++, d = i % 2 === 0, o.removeClass(s.zebra[d ? 1 : 0]).addClass(s.zebra[d ? 0 : 1])
            })
        }, remove: function (e, r, s, a) {
            if (!a) {
                var n, o, i = r.$tbodies, d = (s.zebra || ["even", "odd"]).join(" ");
                for (n = 0; n < i.length; n++) o = t.processTbody(e, i.eq(n), !0), o.children().removeClass(d), t.processTbody(e, o, !1)
            }
        }
    }), t
});
(function ($) {
    $.extend({
        metadata: {
            defaults: {type: 'class', name: 'metadata', cre: /({.*})/, single: 'metadata'},
            setType: function (type, name) {
                this.defaults.type = type;
                this.defaults.name = name
            },
            get: function (elem, opts) {
                var settings = $.extend({}, this.defaults, opts);
                if (!settings.single.length) settings.single = 'metadata';
                var data = $.data(elem, settings.single);
                if (data) return data;
                data = "{}";
                if (settings.type == "class") {
                    var m = settings.cre.exec(elem.className);
                    if (m)
                        data = m[1]
                } else if (settings.type == "elem") {
                    if (!elem.getElementsByTagName)
                        return undefined;
                    var e = elem.getElementsByTagName(settings.name);
                    if (e.length)
                        data = $.trim(e[0].innerHTML);
                } else if (elem.getAttribute != undefined) {
                    var attr = elem.getAttribute(settings.name);
                    if (attr)
                        data = attr
                }
                if (data.indexOf('{') < 0)
                    data = "{" + data + "}";
                data = eval("(" + data + ")");
                $.data(elem, settings.single, data);
                return data
            }
        }
    });
    $.fn.metadata = function (opts) {
        return $.metadata.get(this[0], opts)
    }
})(jQuery);
!function (t, e, i) {
    "use strict";
    if ("undefined" == typeof t) throw new Error("ZUI requires jQuery");
    Number.isNaN || "function" != typeof isNaN || (Number.isNaN = isNaN), Number.parseInt || "function" != typeof parseInt || (Number.parseInt = parseInt), Number.parseFloat || "function" != typeof parseFloat || (Number.parseFloat = parseFloat), t.zui || (t.zui = function (e) {
        t.isPlainObject(e) && t.extend(t.zui, e)
    });
    var n = {all: -1, left: 0, middle: 1, right: 2}, o = 0;
    t.zui({
        uuid: function (t) {
            var e = 1e5 * (Date.now() - 1580890015292) + 10 * Math.floor(1e4 * Math.random()) + o++ % 10;
            return t ? e : e.toString(36)
        }, callEvent: function (t, e, n) {
            if ("function" == typeof t) {
                n !== i && (t = t.bind(n));
                var o = t(e);
                return e && (e.result = o), !(o !== i && !o)
            }
            return 1
        }, strCode: function (t) {
            var e = 0;
            if ("string" != typeof t && (t = String(t)), t && t.length) for (var i = 0; i < t.length; ++i) e += (i + 1) * t.charCodeAt(i);
            return e
        }, getMouseButtonCode: function (t) {
            return "number" != typeof t && (t = n[t]), t !== i && null !== t || (t = -1), t
        }, defaultLang: "en", clientLang: function () {
            var i, n = e.config;
            if ("undefined" != typeof n && n.clientLang && (i = n.clientLang), !i) {
                var o = t("html").attr("lang");
                i = o ? o : navigator.userLanguage || navigator.userLanguage || t.zui.defaultLang
            }
            return i.replace("-", "_").toLowerCase()
        }, langDataMap: {}, addLangData: function (e, i, n) {
            var o = {};
            n && i && e ? (o[i] = {}, o[i][e] = n) : e && i && !n ? (n = i, t.each(n, function (t) {
                o[t] = {}, o[t][e] = n[t]
            })) : !e || i || n || t.each(e, function (e) {
                var i = n[e];
                t.each(i, function (t) {
                    o[t] || (o[t] = {}), o[t][e] = i[t]
                })
            }), t.extend(!0, t.zui.langDataMap, o)
        }, getLangData: function (e, i, n) {
            if (!arguments.length) return t.extend({}, t.zui.langDataMap);
            if (1 === arguments.length) return t.extend({}, t.zui.langDataMap[e]);
            if (2 === arguments.length) {
                var o = t.zui.langDataMap[e];
                return o ? i ? o[i] : o : {}
            }
            if (3 === arguments.length) {
                i = i || t.zui.clientLang();
                var o = t.zui.langDataMap[e], a = o ? o[i] : {};
                return t.extend(!0, {}, n[i] || n.en || n.zh_cn, a)
            }
            return null
        }, lang: function () {
            return arguments.length && t.isPlainObject(arguments[arguments.length - 1]) ? t.zui.addLangData.apply(null, arguments) : t.zui.getLangData.apply(null, arguments)
        }, _scrollbarWidth: 0, getScrollbarSize: function () {
            var e = t.zui._scrollbarWidth;
            if (!e) {
                var i = document.createElement("div");
                i.className = "scrollbar-measure", document.body.appendChild(i), t.zui._scrollbarWidth = e = i.offsetWidth - i.clientWidth, document.body.removeChild(i)
            }
            return e
        }, checkBodyScrollbar: function () {
            return document.body.clientWidth >= e.innerWidth ? 0 : t.zui.getScrollbarSize()
        }, fixBodyScrollbar: function () {
            if (t.zui.checkBodyScrollbar()) {
                var e = t("body"), i = parseInt(e.css("padding-right") || 0, 10);
                return t.zui._scrollbarWidth && e.css({
                    paddingRight: i + t.zui._scrollbarWidth,
                    overflowY: "hidden"
                }), !0
            }
        }, resetBodyScrollbar: function () {
            t("body").css({paddingRight: "", overflowY: ""})
        }
    }), t.fn.callEvent = function (e, n, o) {
        var a = t(this), s = e.indexOf(".zui."), r = s < 0 ? e : e.substring(0, s), l = t.Event(r, n);
        if (o === i && s > 0 && (o = a.data(e.substring(s + 1))), o && o.options) {
            var c = o.options[r];
            "function" == typeof c && (l.result = t.zui.callEvent(c, l, o))
        }
        return a.trigger(l), l
    }, t.fn.callComEvent = function (t, e, n) {
        n === i || Array.isArray(n) || (n = [n]);
        var o, a = this;
        a.trigger(e, n);
        var s = t.options[e];
        return s && (o = s.apply(t, n)), o
    }
}(jQuery, window, void 0), function () {
    "use strict";

    function t(t, e) {
        return i && !e ? requestAnimationFrame(t) : setTimeout(t, e || 0)
    }

    function e(t) {
        return i ? cancelAnimationFrame(t) : void clearTimeout(t)
    }

    var i = "function" == typeof window.requestAnimationFrame;
    $.zui({asap: t, clearAsap: e})
}(), function (t) {
    "use strict";
    t.fn.fixOlPd = function (e) {
        return e = e || 10, this.each(function () {
            var i = t(this);
            i.css("paddingLeft", Math.ceil(Math.log10(i.children().length)) * e + 10)
        })
    }, t(function () {
        t(".ol-pd-fix,.article ol").fixOlPd()
    })
}(jQuery), +function (t) {
    "use strict";
    var e = '[data-dismiss="alert"]', i = "zui.alert", n = function (i) {
        t(i).on("click", e, this.close)
    };
    n.prototype.close = function (e) {
        function n() {
            s.trigger("closed." + i).remove()
        }

        var o = t(this), a = o.attr("data-target");
        a || (a = o.attr("href"), a = a && a.replace(/.*(?=#[^\s]*$)/, ""));
        var s = t(a);
        e && e.preventDefault(), s.length || (s = o.hasClass("alert") ? o : o.parent()), s.trigger(e = t.Event("close." + i)), e.isDefaultPrevented() || (s.removeClass("in"), t.support.transition && s.hasClass("fade") ? s.one(t.support.transition.end, n).emulateTransitionEnd(150) : n())
    };
    var o = t.fn.alert;
    t.fn.alert = function (e) {
        return this.each(function () {
            var o = t(this), a = o.data(i);
            a || o.data(i, a = new n(this)), "string" == typeof e && a[e].call(o)
        })
    }, t.fn.alert.Constructor = n, t.fn.alert.noConflict = function () {
        return t.fn.alert = o, this
    }, t(document).on("click." + i + ".data-api", e, n.prototype.close)
}(window.jQuery), function (t, e) {
    "use strict";
    var i = "zui.pager", n = {page: 1, recTotal: 0, recPerPage: 10}, o = {
        zh_cn: {
            pageOfText: "第 {0} 页",
            prev: "上一页",
            next: "下一页",
            first: "第一页",
            last: "最后一页",
            "goto": "跳转",
            pageOf: "第 <strong>{page}</strong> 页",
            totalPage: "共 <strong>{totalPage}</strong> 页",
            totalCount: "共 <strong>{recTotal}</strong> 项",
            pageSize: "每页 <strong>{recPerPage}</strong> 项",
            itemsRange: "第 <strong>{start}</strong> ~ <strong>{end}</strong> 项",
            pageOfTotal: "第 <strong>{page}</strong>/<strong>{totalPage}</strong> 页"
        },
        zh_tw: {
            pageOfText: "第 {0} 頁",
            prev: "上一頁",
            next: "下一頁",
            first: "第一頁",
            last: "最後一頁",
            "goto": "跳轉",
            pageOf: "第 <strong>{page}</strong> 頁",
            totalPage: "共 <strong>{totalPage}</strong> 頁",
            totalCount: "共 <strong>{recTotal}</strong> 項",
            pageSize: "每頁 <strong>{recPerPage}</strong> 項",
            itemsRange: "第 <strong>{start}</strong> ~ <strong>{end}</strong> 項",
            pageOfTotal: "第 <strong>{page}</strong>/<strong>{totalPage}</strong> 頁"
        },
        en: {
            pageOfText: "Page {0}",
            prev: "Prev",
            next: "Next",
            first: "First",
            last: "Last",
            "goto": "Goto",
            pageOf: "Page <strong>{page}</strong>",
            totalPage: "<strong>{totalPage}</strong> pages",
            totalCount: "Total: <strong>{recTotal}</strong> items",
            pageSize: "<strong>{recPerPage}</strong> per page",
            itemsRange: "From <strong>{start}</strong> to <strong>{end}</strong>",
            pageOfTotal: "Page <strong>{page}</strong> of <strong>{totalPage}</strong>"
        }
    }, a = function (e, n) {
        var s = this;
        s.name = i, s.$ = t(e), n = s.options = t.extend({}, a.DEFAULTS, this.$.data(), n), s.langName = n.lang || t.zui.clientLang(), s.lang = t.zui.getLangData(i, s.langName, o), s.state = {}, s.set(n.page, n.recTotal, n.recPerPage, !0), s.$.on("click", ".pager-goto-btn", function () {
            var e = t(this).closest(".pager-goto"), i = parseInt(e.find(".pager-goto-input").val());
            NaN !== i && s.set(i)
        }).on("click", ".pager-item", function () {
            var e = t(this).data("page");
            "number" == typeof e && e > 0 && s.set(e)
        }).on("click", ".pager-size-menu [data-size]", function () {
            var e = t(this).data("size");
            "number" == typeof e && e > 0 && s.set(-1, -1, e)
        })
    };
    a.prototype.set = function (e, i, o, a) {
        var s = this;
        "object" == typeof e && null !== e && (o = e.recPerPage, i = e.recTotal, e = e.page);
        var r = s.state;
        r || (r = t.extend({}, n));
        var l = t.extend({}, r);
        return "number" == typeof o && o > 0 && (r.recPerPage = o), "number" == typeof i && i >= 0 && (r.recTotal = i), "number" == typeof e && e >= 0 && (r.page = e), r.totalPage = r.recTotal && r.recPerPage ? Math.ceil(r.recTotal / r.recPerPage) : 1, r.page = Math.max(0, Math.min(r.page, r.totalPage)), r.pageRecCount = r.recTotal, r.page && r.recTotal && (r.page < r.totalPage ? r.pageRecCount = r.recPerPage : r.page > 1 && (r.pageRecCount = r.recTotal - r.recPerPage * (r.page - 1))), r.skip = r.page > 1 ? (r.page - 1) * r.recPerPage : 0, r.start = r.skip + 1, r.end = r.skip + r.pageRecCount, r.prev = r.page > 1 ? r.page - 1 : 0, r.next = r.page < r.totalPage ? r.page + 1 : 0, s.state = r, a || l.page === r.page && l.recTotal === r.recTotal && l.recPerPage === r.recPerPage || s.$.callComEvent(s, "onPageChange", [r, l]), s.render()
    }, a.prototype.createLinkItem = function (i, n, o) {
        var a = this;
        n === e && (n = i);
        var s = t('<a title="' + a.lang.pageOfText.format(i) + '" class="pager-item" data-page="' + i + '"/>').attr("href", i ? a.createLink(i, a.state) : "###").html(n);
        return o || (s = t("<li />").append(s).toggleClass("active", i === a.state.page).toggleClass("disabled", !i || i === a.state.page)), s
    }, a.prototype.createNavItems = function (t) {
        var i = this, n = i.$, o = i.state, a = o.totalPage, s = o.page, r = function (t, o) {
            if (t === !1) return void n.append(i.createLinkItem(0, o || i.options.navEllipsisItem));
            o === e && (o = t);
            for (var a = t; a <= o; ++a) n.append(i.createLinkItem(a))
        };
        t === e && (t = i.options.maxNavCount || 10), r(1), a > 1 && (a <= t ? r(2, a) : s < t - 2 ? (r(2, t - 2), r(!1), r(a)) : s > a - t + 2 ? (r(!1), r(a - t + 2, a)) : (r(!1), r(s - Math.ceil((t - 4) / 2), s + Math.floor((t - 4) / 2)), r(!1), r(a)))
    }, a.prototype.createGoto = function () {
        var e = this, i = this.state,
            n = t('<div class="input-group pager-goto" style="width: ' + (35 + 9 * (i.page + "").length + 25 + 12 * e.lang["goto"].length) + 'px"><input value="' + i.page + '" type="number" min="1" max="' + i.totalPage + '" placeholder="' + i.page + '" class="form-control pager-goto-input"><span class="input-group-btn"><button class="btn pager-goto-btn" type="button">' + e.lang["goto"] + "</button></span></div>");
        return n
    }, a.prototype.createSizeMenu = function () {
        var e = this, i = this.state, n = t('<ul class="dropdown-menu"></ul>'), o = e.options.pageSizeOptions;
        "string" == typeof o && (o = o.split(","));
        for (var a = 0; a < o.length; ++a) {
            var s = o[a];
            "string" == typeof s && (s = parseInt(s));
            var r = t('<li><a href="###" data-size="' + s + '">' + s + "</a></li>").toggleClass("active", s === i.recPerPage);
            n.append(r)
        }
        return t('<div class="btn-group pager-size-menu"><button type="button" class="btn dropdown-toggle" data-toggle="dropdown">' + e.lang.pageSize.format(i) + ' <span class="caret"></span></button></div>').addClass(e.options.menuDirection).append(n)
    }, a.prototype.createElement = function (e, i, n) {
        var o = this, a = o.createLinkItem.bind(o), s = o.lang;
        switch (e) {
            case"prev":
                return a(n.prev, s.prev);
            case"prev_icon":
                return a(n.prev, '<i class="icon ' + o.options.prevIcon + '"></i>');
            case"next":
                return a(n.next, s.next);
            case"next_icon":
                return a(n.next, '<i class="icon ' + o.options.nextIcon + '"></i>');
            case"first":
                return a(1, s.first);
            case"first_icon":
                return a(1, '<i class="icon ' + o.options.firstIcon + '"></i>');
            case"last":
                return a(n.totalPage, s.last);
            case"last_icon":
                return a(n.totalPage, '<i class="icon ' + o.options.lastIcon + '"></i>');
            case"space":
            case"|":
                return t('<li class="space" />');
            case"nav":
            case"pages":
                return void o.createNavItems();
            case"total_text":
                return t(('<div class="pager-label">' + s.totalCount + "</div>").format(n));
            case"page_text":
                return t(('<div class="pager-label">' + s.pageOf + "</div>").format(n));
            case"total_page_text":
                return t(('<div class="pager-label">' + s.totalPage + "</div>").format(n));
            case"page_of_total_text":
                return t(('<div class="pager-label">' + s.pageOfTotal + "</div>").format(n));
            case"page_size_text":
                return t(('<div class="pager-label">' + s.pageSize + "</div>").format(n));
            case"items_range_text":
                return t(('<div class="pager-label">' + s.itemsRange + "</div>").format(n));
            case"goto":
                return o.createGoto();
            case"size_menu":
                return o.createSizeMenu();
            default:
                return t("<li/>").html(e.format(n))
        }
    }, a.prototype.createLink = function (i, n) {
        i === e && (i = this.state.page), n === e && (n = this.state);
        var o = this.options.linkCreator;
        return "string" == typeof o ? o.format(t.extend({}, n, {page: i})) : "function" == typeof o ? o(i, n) : "#page=" + i
    }, a.prototype.render = function (e) {
        var i = this, n = i.state, o = i.options.elementCreator || i.createElement, a = t.isPlainObject(o);
        e = e || i.elements || i.options.elements, "string" == typeof e && (e = e.split(",")), i.elements = e, i.$.empty();
        for (var s = 0; s < e.length; ++s) {
            var r = t.trim(e[s]), l = a ? o[r] || o : o, c = l.call(i, r, i.$, n);
            c === !1 && (c = i.createElement(r, i.$, n)), c instanceof t && ("LI" !== c[0].tagName && (c = t("<li/>").append(c)), i.$.append(c))
        }
        var h = null;
        return i.$.children("li").each(function () {
            var e = t(this), i = !!e.children(".pager-item").length;
            h ? h.toggleClass("pager-item-right", !i) : i && e.addClass("pager-item-left"), h = i ? e : null
        }), h && h.addClass("pager-item-right"), i.$.callComEvent(i, "onRender", [n]), i
    }, a.DEFAULTS = t.extend({
        elements: ["first_icon", "prev_icon", "pages", "next_icon", "last_icon", "page_of_total_text", "items_range_text", "total_text"],
        prevIcon: "icon-double-angle-left",
        nextIcon: "icon-double-angle-right",
        firstIcon: "icon-step-backward",
        lastIcon: "icon-step-forward",
        navEllipsisItem: '<i class="icon icon-ellipsis-h"></i>',
        maxNavCount: 10,
        menuDirection: "dropdown",
        pageSizeOptions: [10, 20, 30, 50, 100]
    }, n), t.fn.pager = function (e) {
        return this.each(function () {
            var n = t(this), o = n.data(i), s = "object" == typeof e && e;
            o || n.data(i, o = new a(this, s)), "string" == typeof e && o[e]()
        })
    }, a.NAME = i, a.LANG = o, t.fn.pager.Constructor = a, t(function () {
        t('[data-ride="pager"]').pager()
    })
}(jQuery, void 0), +function (t) {
    "use strict";
    var e = "zui.tab", i = function (e) {
        this.element = t(e)
    };
    i.prototype.show = function () {
        var i = this.element, n = i.closest("ul:not(.dropdown-menu)"), o = i.attr("data-target") || i.attr("data-tab");
        if (o || (o = i.attr("href"), o = o && o.replace(/.*(?=#[^\s]*$)/, "")), !i.parent("li").hasClass("active")) {
            var a = n.find(".active:last a")[0], s = t.Event("show." + e, {relatedTarget: a});
            if (i.trigger(s), !s.isDefaultPrevented()) {
                var r = t(o);
                this.activate(i.parent("li"), n), this.activate(r, r.parent(), function () {
                    i.trigger({type: "shown." + e, relatedTarget: a})
                })
            }
        }
    }, i.prototype.activate = function (e, i, n) {
        function o() {
            a.removeClass("active").find("> .dropdown-menu > .active").removeClass("active"), e.addClass("active"), s ? (e[0].offsetWidth, e.addClass("in")) : e.removeClass("fade"), e.parent(".dropdown-menu") && e.closest("li.dropdown").addClass("active"), n && n()
        }

        var a = i.find("> .active"), s = n && t.support.transition && a.hasClass("fade");
        s ? a.one(t.support.transition.end, o).emulateTransitionEnd(150) : o(), a.removeClass("in")
    };
    var n = t.fn.tab;
    t.fn.tab = function (n) {
        return this.each(function () {
            var o = t(this), a = o.data(e);
            a || o.data(e, a = new i(this)), "string" == typeof n && a[n]()
        })
    }, t.fn.tab.Constructor = i, t.fn.tab.noConflict = function () {
        return t.fn.tab = n, this
    }, t(document).on("click.zui.tab.data-api", '[data-toggle="tab"], [data-tab]', function (e) {
        e.preventDefault(), t(this).tab("show")
    })
}(window.jQuery), +function (t) {
    "use strict";

    function e() {
        var t = document.createElement("bootstrap"), e = {
            WebkitTransition: "webkitTransitionEnd",
            MozTransition: "transitionend",
            OTransition: "oTransitionEnd otransitionend",
            transition: "transitionend"
        };
        for (var i in e) if (void 0 !== t.style[i]) return {end: e[i]};
        return !1
    }

    t.fn.emulateTransitionEnd = function (e) {
        var i = !1, n = this;
        t(this).one("bsTransitionEnd", function () {
            i = !0
        });
        var o = function () {
            i || t(n).trigger(t.support.transition.end)
        };
        return setTimeout(o, e), this
    }, t(function () {
        t.support.transition = e(), t.support.transition && (t.event.special.bsTransitionEnd = {
            bindType: t.support.transition.end,
            delegateType: t.support.transition.end,
            handle: function (e) {
                if (t(e.target).is(this)) return e.handleObj.handler.apply(this, arguments)
            }
        })
    })
}(jQuery), +function (t) {
    "use strict";
    var e = "zui.collapse", i = function (e, n) {
        this.$element = t(e), this.options = t.extend({}, i.DEFAULTS, n), this.transitioning = null, this.options.parent && (this.$parent = t(this.options.parent)), this.options.toggle && this.toggle()
    };
    i.DEFAULTS = {toggle: !0}, i.prototype.dimension = function () {
        var t = this.$element.hasClass("width");
        return t ? "width" : "height"
    }, i.prototype.show = function () {
        if (!this.transitioning && !this.$element.hasClass("in")) {
            var i = t.Event("show." + e);
            if (this.$element.trigger(i), !i.isDefaultPrevented()) {
                var n = this.$parent && this.$parent.find(".in");
                if (n && n.length) {
                    var o = n.data(e);
                    if (o && o.transitioning) return;
                    n.collapse("hide"), o || n.data(e, null)
                }
                var a = this.dimension();
                this.$element.removeClass("collapse").addClass("collapsing")[a](0), this.transitioning = 1;
                var s = function () {
                    this.$element.removeClass("collapsing").addClass("in")[a]("auto"), this.transitioning = 0, this.$element.trigger("shown." + e)
                };
                if (!t.support.transition) return s.call(this);
                var r = t.camelCase(["scroll", a].join("-"));
                this.$element.one(t.support.transition.end, s.bind(this)).emulateTransitionEnd(350)[a](this.$element[0][r])
            }
        }
    }, i.prototype.hide = function () {
        if (!this.transitioning && this.$element.hasClass("in")) {
            var i = t.Event("hide." + e);
            if (this.$element.trigger(i), !i.isDefaultPrevented()) {
                var n = this.dimension();
                this.$element[n](this.$element[n]())[0].offsetHeight, this.$element.addClass("collapsing").removeClass("collapse").removeClass("in"), this.transitioning = 1;
                var o = function () {
                    this.transitioning = 0, this.$element.trigger("hidden." + e).removeClass("collapsing").addClass("collapse")
                };
                return t.support.transition ? void this.$element[n](0).one(t.support.transition.end, o.bind(this)).emulateTransitionEnd(350) : o.call(this)
            }
        }
    }, i.prototype.toggle = function () {
        this[this.$element.hasClass("in") ? "hide" : "show"]()
    };
    var n = t.fn.collapse;
    t.fn.collapse = function (n) {
        return this.each(function () {
            var o = t(this), a = o.data(e), s = t.extend({}, i.DEFAULTS, o.data(), "object" == typeof n && n);
            a || o.data(e, a = new i(this, s)), "string" == typeof n && a[n]()
        })
    }, t.fn.collapse.Constructor = i, t.fn.collapse.noConflict = function () {
        return t.fn.collapse = n, this
    }, t(document).on("click." + e + ".data-api", "[data-toggle=collapse]", function (i) {
        var n, o = t(this),
            a = o.attr("data-target") || i.preventDefault() || (n = o.attr("href")) && n.replace(/.*(?=#[^\s]+$)/, ""),
            s = t(a), r = s.data(e), l = r ? "toggle" : o.data(), c = o.attr("data-parent"), h = c && t(c);
        r && r.transitioning || (h && h.find('[data-toggle=collapse][data-parent="' + c + '"]').not(o).addClass("collapsed"), o[s.hasClass("in") ? "addClass" : "removeClass"]("collapsed")), s.collapse(l)
    })
}(window.jQuery), function (t, e) {
    "use strict";
    var i = 1200, n = 992, o = 768, a = e(t), s = function () {
        var t = a.width();
        e("html").toggleClass("screen-desktop", t >= n && t < i).toggleClass("screen-desktop-wide", t >= i).toggleClass("screen-tablet", t >= o && t < n).toggleClass("screen-phone", t < o).toggleClass("device-mobile", t < n).toggleClass("device-desktop", t >= n)
    }, r = "", l = navigator.userAgent;
    l.match(/(iPad|iPhone|iPod)/i) ? r += " os-ios" : l.match(/android/i) ? r += " os-android" : l.match(/Win/i) ? r += " os-windows" : l.match(/Mac/i) ? r += " os-mac" : l.match(/Linux/i) ? r += " os-linux" : l.match(/X11/i) && (r += " os-unix"), "ontouchstart" in document.documentElement && (r += " is-touchable"), e("html").addClass(r), a.resize(s), s()
}(window, jQuery), function (t) {
    "use strict";
    var e = {
        zh_cn: '您的浏览器版本过低，无法体验所有功能，建议升级或者更换浏览器。 <a href="https://browsehappy.com/" target="_blank" class="alert-link">了解更多...</a>',
        zh_tw: '您的瀏覽器版本過低，無法體驗所有功能，建議升級或者更换瀏覽器。<a href="https://browsehappy.com/" target="_blank" class="alert-link">了解更多...</a>',
        en: 'Your browser is too old, it has been unable to experience the colorful internet. We strongly recommend that you upgrade a better one. <a href="https://browsehappy.com/" target="_blank" class="alert-link">Learn more...</a>'
    }, i = function () {
        for (var t = !1, e = 11; e > 5; e--) if (this.isIE(e)) {
            t = e;
            break
        }
        this.ie = t, this.cssHelper()
    };
    i.prototype.cssHelper = function () {
        var e = this.ie, i = t("html");
        i.toggleClass("ie", e).removeClass("ie-6 ie-7 ie-8 ie-9 ie-10"), e && i.addClass("ie-" + e).toggleClass("gt-ie-7 gte-ie-8 support-ie", e >= 8).toggleClass("lte-ie-7 lt-ie-8 outdated-ie", e < 8).toggleClass("gt-ie-8 gte-ie-9", e >= 9).toggleClass("lte-ie-8 lt-ie-9", e < 9).toggleClass("gt-ie-9 gte-ie-10", e >= 10).toggleClass("lte-ie-9 lt-ie-10", e < 10).toggleClass("gt-ie-10 gte-ie-11", e >= 11).toggleClass("lte-ie-10 lt-ie-11", e < 11)
    }, i.prototype.tip = function (i) {
        var n = t("#browseHappyTip");
        n.length || (n = t('<div id="browseHappyTip" class="alert alert-dismissable alert-danger-inverse alert-block" style="position: relative; z-index: 99999"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><div class="container"><div class="content text-center"></div></div></div>'), n.prependTo("body")), i || (i = t.zui.getLangData("zui.browser", t.zui.clientLang(), e), "object" == typeof i && (i = i.tip)), n.find(".content").html(i)
    }, i.prototype.isIE = function (t) {
        if (11 === t) return this.isIE11();
        if (10 === t) return this.isIE10();
        if (!t && (this.isIE11() || this.isIE10())) return !0;
        var e = document.createElement("b");
        return e.innerHTML = "<!--[if IE " + (t || "") + "]><i></i><![endif]-->", 1 === e.getElementsByTagName("i").length
    }, i.prototype.isIE10 = function () {
        return navigator.appVersion.indexOf("MSIE 10") !== -1
    }, i.prototype.isIE11 = function () {
        var t = navigator.userAgent;
        return t.indexOf("Trident") !== -1 && t.indexOf("rv:11") !== -1
    }, t.zui({browser: new i}), t(function () {
        t("body").hasClass("disabled-browser-tip") || t.zui.browser.ie && t.zui.browser.ie < 8 && t.zui.browser.tip()
    })
}(jQuery), function (t) {
    "use strict";
    var e = 864e5, i = function (t) {
        return t instanceof Date || ("number" == typeof t && t < 1e10 && (t *= 1e3), t = new Date(t)), t
    }, n = function (t) {
        return i(t).getTime()
    }, o = function (t, e) {
        t = i(t), void 0 === e && (e = "yyyy-MM-dd hh:mm:ss");
        var n = {
            "M+": t.getMonth() + 1,
            "d+": t.getDate(),
            "h+": t.getHours(),
            "m+": t.getMinutes(),
            "s+": t.getSeconds(),
            "q+": Math.floor((t.getMonth() + 3) / 3),
            "S+": t.getMilliseconds()
        };
        /(y+)/i.test(e) && (e = e.replace(RegExp.$1, (t.getFullYear() + "").substr(4 - RegExp.$1.length)));
        for (var o in n) new RegExp("(" + o + ")").test(e) && (e = e.replace(RegExp.$1, 1 == RegExp.$1.length ? n[o] : ("00" + n[o]).substr(("" + n[o]).length)));
        return e
    }, a = function (t, e) {
        return t.setTime(t.getTime() + e), t
    }, s = function (t, i) {
        return a(t, i * e)
    }, r = function (t) {
        return new Date(i(t).getTime())
    }, l = function (t) {
        return t % 4 === 0 && t % 100 !== 0 || t % 400 === 0
    }, c = function (t, e) {
        return [31, l(t) ? 29 : 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31][e]
    }, h = function (t) {
        return c(t.getFullYear(), t.getMonth())
    }, d = function (t) {
        return t.setHours(0), t.setMinutes(0), t.setSeconds(0), t.setMilliseconds(0), t
    }, u = function (t, e) {
        var i = t.getDate();
        return t.setDate(1), t.setMonth(t.getMonth() + e), t.setDate(Math.min(i, h(t))), t
    }, p = function (t, e) {
        e = e || 1;
        for (var i = new Date(t.getTime()); i.getDay() != e;) i = s(i, -1);
        return d(i)
    }, f = function (t, e) {
        return t.toDateString() === e.toDateString()
    }, g = function (t, e) {
        var i = p(t), n = s(r(i), 7);
        return e >= i && e < n
    }, m = function (t, e) {
        return t.getFullYear() === e.getFullYear()
    }, v = {
        formatDate: o,
        createDate: i,
        date: {
            ONEDAY_TICKS: e,
            create: i,
            getTimestamp: n,
            format: o,
            addMilliseconds: a,
            addDays: s,
            cloneDate: r,
            isLeapYear: l,
            getDaysInMonth: c,
            getDaysOfThisMonth: h,
            clearTime: d,
            addMonths: u,
            getLastWeekday: p,
            isSameDay: f,
            isSameWeek: g,
            isSameYear: m
        }
    };
    t.$ && t.$.zui ? $.zui(v) : t.dateHelper = v.date, t.noDatePrototypeHelper || (Date.ONEDAY_TICKS = e, Date.prototype.format || (Date.prototype.format = function (t) {
        return o(this, t)
    }), Date.prototype.addMilliseconds || (Date.prototype.addMilliseconds = function (t) {
        return a(this, t)
    }), Date.prototype.addDays || (Date.prototype.addDays = function (t) {
        return s(this, t)
    }), Date.prototype.clone || (Date.prototype.clone = function () {
        return r(this)
    }), Date.isLeapYear || (Date.isLeapYear = function (t) {
        return l(t)
    }), Date.getDaysInMonth || (Date.getDaysInMonth = function (t, e) {
        return c(t, e)
    }), Date.prototype.isLeapYear || (Date.prototype.isLeapYear = function () {
        return l(this.getFullYear())
    }), Date.prototype.clearTime || (Date.prototype.clearTime = function () {
        return d(this)
    }), Date.prototype.getDaysInMonth || (Date.prototype.getDaysInMonth = function () {
        return h(this)
    }), Date.prototype.addMonths || (Date.prototype.addMonths = function (t) {
        return u(this, t)
    }), Date.prototype.getLastWeekday || (Date.prototype.getLastWeekday = function (t) {
        return p(this, t)
    }), Date.prototype.isSameDay || (Date.prototype.isSameDay = function (t) {
        return f(t, this)
    }), Date.prototype.isSameWeek || (Date.prototype.isSameWeek = function (t) {
        return g(t, this)
    }), Date.prototype.isSameYear || (Date.prototype.isSameYear = function (t) {
        return m(this, t)
    }), Date.create || (Date.create = function (t) {
        return i(t)
    }), Date.timestamp || (Date.timestamp = function (t) {
        return n(t)
    }))
}(window), function () {
    "use strict";
    var t = function (t, e) {
        if (arguments.length > 1) {
            var i;
            if (2 == arguments.length && "object" == typeof e) for (var n in e) void 0 !== e[n] && (i = new RegExp("({" + n + "})", "g"), t = t.replace(i, e[n])); else for (var o = 1; o < arguments.length; o++) void 0 !== arguments[o] && (i = new RegExp("({[" + (o - 1) + "]})", "g"), t = t.replace(i, arguments[o]))
        }
        return t
    }, e = function (t) {
        if (null !== t) {
            var e, i;
            return i = /\d*/i, e = t.match(i), e == t
        }
        return !1
    }, i = {formatString: t, string: {format: t, isNum: e}};
    window.$ && window.$.zui ? $.zui(i) : window.stringHelper = i.string, window.noStringPrototypeHelper || (String.prototype.format || (String.prototype.format = function () {
        var e = [].slice.call(arguments);
        return e.unshift(this), t.apply(this, e)
    }), String.prototype.isNum || (String.prototype.isNum = function () {
        return e(this)
    }), String.prototype.endsWith || (String.prototype.endsWith = function (t, e) {
        return (void 0 === e || e > this.length) && (e = this.length), this.substring(e - t.length, e) === t
    }), String.prototype.startsWith || Object.defineProperty(String.prototype, "startsWith", {
        value: function (t, e) {
            return e = !e || e < 0 ? 0 : +e, this.substring(e, e + t.length) === t
        }
    }), String.prototype.includes || (String.prototype.includes = function () {
        return String.prototype.indexOf.apply(this, arguments) !== -1
    }))
}(), function (t, e, i) {
    "$:nomunge";

    function n() {
        o = e[r](function () {
            a.each(function () {
                var e = t(this), i = e.width(), n = e.height(), o = t.data(this, c);
                i === o.w && n === o.h || e.trigger(l, [o.w = i, o.h = n])
            }), n()
        }, s[h])
    }

    var o, a = t([]), s = t.resize = t.extend(t.resize, {}), r = "setTimeout", l = "resize", c = l + "-special-event",
        h = "delay", d = "throttleWindow";
    s[h] = 250, s[d] = !0, t.event.special[l] = {
        setup: function () {
            if (!s[d] && this[r]) return !1;
            var e = t(this);
            a = a.add(e), t.data(this, c, {w: e.width(), h: e.height()}), 1 === a.length && n()
        }, teardown: function () {
            if (!s[d] && this[r]) return !1;
            var e = t(this);
            a = a.not(e), e.removeData(c), a.length || clearTimeout(o)
        }, add: function (e) {
            function n(e, n, a) {
                var s = t(this), r = t.data(this, c) || {};
                r.w = n !== i ? n : s.width(), r.h = a !== i ? a : s.height(), o.apply(this, arguments)
            }

            if (!s[d] && this[r]) return !1;
            var o;
            return "function" == typeof e ? (o = e, n) : (o = e.handler, void (e.handler = n))
        }
    }
}(jQuery, this), function (t) {
    "function" == typeof define && define.amd ? define(["jquery"], t) : t("object" == typeof exports ? require("jquery") : jQuery)
}(function (t) {
    function e(t) {
        return r.raw ? t : encodeURIComponent(t)
    }

    function i(t) {
        return r.raw ? t : decodeURIComponent(t)
    }

    function n(t) {
        return e(r.json ? JSON.stringify(t) : String(t))
    }

    function o(t) {
        0 === t.indexOf('"') && (t = t.slice(1, -1).replace(/\\"/g, '"').replace(/\\\\/g, "\\"));
        try {
            return t = decodeURIComponent(t.replace(s, " ")), r.json ? JSON.parse(t) : t
        } catch (e) {
        }
    }

    function a(t, e) {
        var i = r.raw ? t : o(t);
        return "function" == typeof e ? e(i) : i
    }

    var s = /\+/g, r = t.cookie = function (o, s, l) {
        if (void 0 !== s && "function" != typeof s) {
            if (l = t.extend({}, r.defaults, l), "number" == typeof l.expires) {
                var c = l.expires, h = l.expires = new Date;
                h.setTime(+h + 864e5 * c)
            }
            return document.cookie = [e(o), "=", n(s), l.expires ? "; expires=" + l.expires.toUTCString() : "", l.path ? "; path=" + l.path : "", l.domain ? "; domain=" + l.domain : "", l.secure ? "; secure" : ""].join("")
        }
        for (var d = o ? void 0 : {}, u = document.cookie ? document.cookie.split("; ") : [], p = 0, f = u.length; p < f; p++) {
            var g = u[p].split("="), m = i(g.shift()), v = g.join("=");
            if (o && o === m) {
                d = a(v, s);
                break
            }
            o || void 0 === (v = a(v)) || (d[m] = v)
        }
        return d
    };
    r.defaults = {}, t.removeCookie = function (e, i) {
        return void 0 !== t.cookie(e) && (t.cookie(e, "", t.extend({}, i, {expires: -1})), !t.cookie(e))
    }
}), function (t, e) {
    "use strict";
    var i, n, o = "localStorage", a = "page_" + t.location.pathname + t.location.search, s = function () {
        this.silence = !0;
        try {
            o in t && t[o] && t[o].setItem && (this.enable = !0, i = t[o])
        } catch (s) {
        }
        this.enable || (n = {}, i = {
            getLength: function () {
                var t = 0;
                return e.each(n, function () {
                    t++
                }), t
            }, key: function (t) {
                var i, o = 0;
                return e.each(n, function (e) {
                    return o === t ? (i = e, !1) : void o++
                }), i
            }, removeItem: function (t) {
                delete n[t]
            }, getItem: function (t) {
                return n[t]
            }, setItem: function (t, e) {
                n[t] = e
            }, clear: function () {
                n = {}
            }
        }), this.storage = i, this.page = this.get(a, {})
    };
    s.prototype.pageSave = function () {
        if (e.isEmptyObject(this.page)) this.remove(a); else {
            var t, i = [];
            for (t in this.page) {
                var n = this.page[t];
                null === n && i.push(t)
            }
            for (t = i.length - 1; t >= 0; t--) delete this.page[i[t]];
            this.set(a, this.page)
        }
    }, s.prototype.pageRemove = function (t) {
        "undefined" != typeof this.page[t] && (this.page[t] = null, this.pageSave())
    }, s.prototype.pageClear = function () {
        this.page = {}, this.pageSave()
    }, s.prototype.pageGet = function (t, e) {
        var i = this.page[t];
        return void 0 === e || null !== i && void 0 !== i ? i : e
    }, s.prototype.pageSet = function (t, i) {
        e.isPlainObject(t) ? e.extend(!0, this.page, t) : this.page[this.serialize(t)] = i, this.pageSave()
    }, s.prototype.check = function () {
        if (!this.enable && !this.silence) throw new Error("Browser not support localStorage or enable status been set true.");
        return this.enable
    }, s.prototype.length = function () {
        return this.check() ? i.getLength ? i.getLength() : i.length : 0
    }, s.prototype.removeItem = function (t) {
        return i.removeItem(t), this
    }, s.prototype.remove = function (t) {
        return this.removeItem(t)
    }, s.prototype.getItem = function (t) {
        return i.getItem(t)
    }, s.prototype.get = function (t, e) {
        var i = this.deserialize(this.getItem(t));
        return "undefined" != typeof i && null !== i || "undefined" == typeof e ? i : e
    }, s.prototype.key = function (t) {
        return i.key(t)
    }, s.prototype.setItem = function (t, e) {
        return i.setItem(t, e), this
    }, s.prototype.set = function (t, e) {
        return void 0 === e ? this.remove(t) : (this.setItem(t, this.serialize(e)), this)
    }, s.prototype.clear = function () {
        return i.clear(), this
    }, s.prototype.forEach = function (t) {
        for (var e = this.length(), n = e - 1; n >= 0; n--) {
            var o = i.key(n);
            t(o, this.get(o))
        }
        return this
    }, s.prototype.getAll = function () {
        var t = {};
        return this.forEach(function (e, i) {
            t[e] = i
        }), t
    }, s.prototype.serialize = function (t) {
        return "string" == typeof t ? t : JSON.stringify(t)
    }, s.prototype.deserialize = function (t) {
        if ("string" == typeof t) try {
            return JSON.parse(t)
        } catch (e) {
            return t || void 0
        }
    }, e.zui({store: new s})
}(window, jQuery), function (t) {
    "use strict";
    var e = "zui.searchBox", i = function (e, n) {
        var o = this;
        o.name = name, o.$ = t(e), o.options = n = t.extend({}, i.DEFAULTS, o.$.data(), n);
        var a = o.$.is(n.inputSelector) ? o.$ : o.$.find(n.inputSelector);
        if (a.length) {
            var s = function () {
                o.changeTimer && (clearTimeout(o.changeTimer), o.changeTimer = null)
            }, r = function () {
                s();
                var t = o.getSearch();
                if (t !== o.lastValue) {
                    var e = "" === t;
                    a.toggleClass("empty", e), o.$.callComEvent(o, "onSearchChange", [t, e]), o.lastValue = t
                }
            };
            o.$input = a = a.first(), a.on(n.listenEvent, function (t) {
                o.changeTimer = setTimeout(function () {
                    r()
                }, n.changeDelay)
            }).on("focus", function (t) {
                a.addClass("focus"), o.$.callComEvent(o, "onFocus", [t])
            }).on("blur", function (t) {
                a.removeClass("focus"), o.$.callComEvent(o, "onBlur", [t])
            }).on("keydown", function (t) {
                var e = 0, i = t.which;
                27 === i && n.escToClear ? (this.setSearch("", !0), r(), e = 1) : 13 === i && n.onPressEnter && (r(), o.$.callComEvent(o, "onPressEnter", [t]));
                var a = o.$.callComEvent(o, "onKeyDown", [t]);
                a === !1 && (e = 1), e && t.preventDefault()
            }), o.$.on("click", ".search-clear-btn", function (t) {
                o.setSearch("", !0), r(), o.focus(), t.preventDefault()
            }), r()
        } else console.error("ZUI: search box init error, cannot find search box input element.")
    };
    i.DEFAULTS = {
        inputSelector: 'input[type="search"],input[type="text"]',
        listenEvent: "change input paste",
        changeDelay: 500
    }, i.prototype.getSearch = function () {
        return this.$input && t.trim(this.$input.val())
    }, i.prototype.setSearch = function (t, e) {
        var i = this.$input;
        i && (i.val(t), e || i.trigger("change"))
    }, i.prototype.focus = function () {
        this.$input && this.$input.focus()
    }, t.fn.searchBox = function (n) {
        return this.each(function () {
            var o = t(this), a = o.data(e), s = "object" == typeof n && n;
            a || o.data(e, a = new i(this, s)), "string" == typeof n && a[n]()
        })
    }, i.NAME = e, t.fn.searchBox.Constructor = i
}(jQuery), function (t, e) {
    "use strict";
    var i = "zui.draggable", n = {container: "body", move: !0}, o = 0, a = function (e, i) {
        var a = this;
        a.$ = t(e), a.id = o++, a.options = t.extend({}, n, a.$.data(), i), a.init()
    };
    a.DEFAULTS = n, a.NAME = i, a.prototype.init = function () {
        var n, o, a, s, r, l = this, c = l.$, h = "before", d = "drag", u = "finish", p = "." + i + "." + l.id,
            f = "mousedown" + p, g = "mouseup" + p, m = "mousemove" + p, v = l.options, y = v.selector, b = v.handle,
            w = c, x = "function" == typeof v.move, C = function (t) {
                var e = t.pageX, i = t.pageY;
                r = !0;
                var o = {left: e - a.x, top: i - a.y};
                w.removeClass("drag-ready").addClass("dragging"), v.move && (x ? v.move(o, w) : w.css(o)), v[d] && v[d]({
                    event: t,
                    element: w,
                    startOffset: a,
                    pos: o,
                    offset: {x: e - n.x, y: i - n.y},
                    smallOffset: {x: e - s.x, y: i - s.y}
                }), s.x = e, s.y = i, v.stopPropagation && t.stopPropagation()
            }, _ = 0, k = function (e) {
                _ && (t.zui.clearAsap || clearTimeout)(_), _ = (t.zui.asap || setTimeout)(function () {
                    _ = 0, C(e)
                }, 0)
            }, T = function (i) {
                if (t(e).off(p), !r) return void w.removeClass("drag-ready");
                var o = {left: i.pageX - a.x, top: i.pageY - a.y};
                w.removeClass("drag-ready dragging"), v.move && (x ? v.move(o, w) : w.css(o)), v[u] && v[u]({
                    event: i,
                    element: w,
                    startOffset: a,
                    pos: o,
                    offset: {x: i.pageX - n.x, y: i.pageY - n.y},
                    smallOffset: {x: i.pageX - s.x, y: i.pageY - s.y}
                }), i.preventDefault(), v.stopPropagation && i.stopPropagation()
            }, S = function (i) {
                var l = t.zui.getMouseButtonCode(v.mouseButton);
                if (!(l > -1 && i.button !== l)) {
                    var c = t(this);
                    if (y && (w = b ? c.closest(y) : c), v[h]) {
                        var d = v[h]({event: i, element: w});
                        if (d === !1) return
                    }
                    var u = t(v.container), p = w.offset();
                    o = u.offset(), n = {x: i.pageX, y: i.pageY}, a = {
                        x: i.pageX - p.left + o.left,
                        y: i.pageY - p.top + o.top
                    }, s = t.extend({}, n), r = !1, w.addClass("drag-ready"), i.preventDefault(), v.stopPropagation && i.stopPropagation(), t(e).on(m, k).on(g, T)
                }
            };
        b ? c.on(f, b, S) : y ? c.on(f, y, S) : c.on(f, S)
    }, a.prototype.destroy = function () {
        var n = "." + i + "." + this.id;
        this.$.off(n), t(e).off(n), this.$.data(i, null)
    }, t.fn.draggable = function (e) {
        return this.each(function () {
            var n = t(this), o = n.data(i), s = "object" == typeof e && e;
            o || n.data(i, o = new a(this, s)), "string" == typeof e && o[e]()
        })
    }, t.fn.draggable.Constructor = a
}(jQuery, document), function (t, e, i) {
    "use strict";
    var n = "zui.droppable", o = {
        target: ".droppable-target",
        deviation: 5,
        sensorOffsetX: 0,
        sensorOffsetY: 0,
        dropToClass: "drop-to",
        dropTargetClass: "drop-target"
    }, a = 0, s = function (e, i) {
        var n = this;
        n.id = a++, n.$ = t(e), n.options = t.extend({}, o, n.$.data(), i), n.init()
    };
    s.DEFAULTS = o, s.NAME = n, s.prototype.trigger = function (e, i) {
        return t.zui.callEvent(this.options[e], i, this)
    }, s.prototype.init = function () {
        var o, a, s, r, l, c, h, d, u, p, f, g, m, v, y = this, b = y.$, w = y.options, x = w.deviation,
            C = "." + n + "." + y.id, _ = "mousedown" + C, k = "mouseup" + C, T = "mousemove" + C, S = w.selector,
            D = w.handle, M = w.flex, L = w.canMoveHere, z = w.dropToClass, P = w.noShadow, $ = b, I = !1;
        w.dropOnMouseleave && (k += " mouseleave" + C);
        var F = function (e) {
            if (I) {
                if (g = {left: e.pageX, top: e.pageY}, !r) {
                    if (i.abs(g.left - u.left) < x && i.abs(g.top - u.top) < x) return;
                    var n = o.css("position");
                    "absolute" != n && "relative" != n && "fixed" != n && (h = n, o.css("position", "relative")), r = P ? {} : $.clone().removeClass("drag-from").addClass("drag-shadow").css({
                        position: "absolute",
                        width: $.outerWidth(),
                        transition: "none"
                    }).appendTo(o), $.addClass("dragging"), a.addClass(w.dropTargetClass), y.trigger("start", {
                        event: e,
                        element: $,
                        shadowElement: P ? null : r,
                        targets: a,
                        mouseOffset: g
                    })
                }
                var d = {left: g.left - f.left, top: g.top - f.top}, v = {left: d.left - p.left, top: d.top - p.top};
                P || r.css(v);
                var b = !1;
                l = !1, M || a.removeClass(z);
                var C = null;
                if (a.each(function () {
                    var e = t(this), i = e.offset(), n = e.outerWidth(), o = e.outerHeight(),
                        a = i.left + w.sensorOffsetX, s = i.top + w.sensorOffsetY;
                    if (g.left > a && g.top > s && g.left < a + n && g.top < s + o && (C && C.removeClass(z), C = e, !w.nested)) return !1
                }), C) {
                    l = !0;
                    var _ = C.data("id");
                    $.data("id") == _ && $.closest(".kanban-lane").data("id") == C.closest(".kanban-lane").data("id") || (c = !1), (null === s || s.data("id") !== _ && !c) && (b = !0), s = C, M && a.removeClass(z), s.addClass(z)
                }
                M ? null !== s && s.length && (l = !0) : ($.toggleClass("drop-in", l), P || r.toggleClass("drop-in", l)), L && L($, s) === !1 || y.trigger("drag", {
                    event: e,
                    isIn: l,
                    target: s,
                    element: $,
                    isNew: b,
                    selfTarget: c,
                    clickOffset: f,
                    offset: d,
                    position: v,
                    mouseOffset: g,
                    lastMouseOffset: m
                }), t.extend(m, g), e.preventDefault()
            }
        }, A = 0, E = function (e) {
            A && (t.zui.clearAsap || clearTimeout)(A), A = (t.zui.asap || setTimeout)(function () {
                A = 0, F(e)
            }, 0)
        }, O = function (i) {
            if (t(e).off(C), clearTimeout(v), I) {
                if (I = !1, h && o.css("position", h), null === r) return $.removeClass("drag-from"), void y.trigger("always", {
                    target: s,
                    event: i,
                    cancel: !0
                });
                l || (s = null);
                var n = !0;
                g = i ? {left: i.pageX, top: i.pageY} : m;
                var d = {left: g.left - f.left, top: g.top - f.top}, u = {left: g.left - m.left, top: g.top - m.top};
                m.left = g.left, m.top = g.top;
                var b = {
                    event: i,
                    isIn: l,
                    target: s,
                    element: $,
                    isNew: !c && null !== s,
                    selfTarget: c,
                    offset: d,
                    mouseOffset: g,
                    position: {left: d.left - p.left, top: d.top - p.top},
                    lastMouseOffset: m,
                    moveOffset: u
                };
                n = y.trigger("beforeDrop", b), n && l && y.trigger("drop", b), a.removeClass(z).removeClass(w.dropTargetClass), $.removeClass("dragging").removeClass("drag-from"), P || r.remove(), r = null, y.trigger("finish", b), y.trigger("always", b), i && i.preventDefault()
            }
        }, R = function (i) {
            var n = t.zui.getMouseButtonCode(w.mouseButton);
            if (!(n > -1 && i.button !== n)) {
                var g = t(this);
                S && ($ = D ? g.closest(S) : g), $.hasClass("drag-shadow") || w.before && w.before({
                    event: i,
                    element: $
                }) === !1 || (I = !0, o = w.container ? "function" == typeof w.container ? w.container($, b) : t(w.container).first() : S ? b : t("body"), a = "function" == typeof w.target ? w.target($, b) : o.find(w.target), s = null, r = null, l = !1, c = !0, h = null, d = $.offset(), p = o.offset(), p.top = p.top - o.scrollTop(), p.left = p.left - o.scrollLeft(), u = {
                    left: i.pageX,
                    top: i.pageY
                }, m = t.extend({}, u), f = {
                    left: u.left - d.left,
                    top: u.top - d.top
                }, $.addClass("drag-from"), t(e).on(T, E).on(k, O), v = setTimeout(function () {
                    t(e).on(_, O)
                }, 10), i.preventDefault(), w.stopPropagation && i.stopPropagation())
            }
        };
        D ? b.on(_, D, R) : S ? b.on(_, S, R) : b.on(_, R)
    }, s.prototype.destroy = function () {
        var i = "." + n + "." + this.id;
        this.$.off(i), t(e).off(i), this.$.data(n, null)
    }, s.prototype.reset = function () {
        this.destroy(), this.init()
    }, t.fn.droppable = function (e) {
        return this.each(function () {
            var i = t(this), o = i.data(n), a = "object" == typeof e && e;
            o || i.data(n, o = new s(this, a)), "string" == typeof e && o[e]()
        })
    }, t.fn.droppable.Constructor = s
}(jQuery, document, Math), +function (t, e) {
    "use strict";

    function i(e, i, a) {
        return this.each(function () {
            var s = t(this), r = s.data(n), l = t.extend({}, o.DEFAULTS, s.data(), "object" == typeof e && e);
            r || s.data(n, r = new o(this, l)), "string" == typeof e ? r[e](i, a) : l.show && r.show(i, a)
        })
    }

    var n = "zui.modal", o = function (i, o) {
        var a = this;
        a.options = o, a.$body = t(document.body), a.$element = t(i), a.$backdrop = a.isShown = null, a.scrollbarWidth = 0, o.moveable === e && (a.options.moveable = a.$element.hasClass("modal-moveable")), o.remote && a.$element.find(".modal-content").load(o.remote, function () {
            a.$element.trigger("loaded." + n)
        }), o.scrollInside && t(window).on("resize." + n, function () {
            a.isShown && a.adjustPosition(e, 100)
        })
    };
    o.VERSION = "3.2.0", o.TRANSITION_DURATION = 300, o.BACKDROP_TRANSITION_DURATION = 150, o.DEFAULTS = {
        backdrop: !0,
        keyboard: !0,
        show: !0,
        position: "fit"
    };
    var a = function (e, i) {
        var n = t(window);
        i.left = Math.max(0, Math.min(i.left, n.width() - e.outerWidth())), i.top = Math.max(0, Math.min(i.top, n.height() - e.outerHeight())), e.css(i)
    };
    o.prototype.toggle = function (t, e) {
        return this.isShown ? this.hide() : this.show(t, e)
    }, o.prototype.adjustPosition = function (i, o) {
        var s = this;
        if (clearTimeout(s.reposTask), o) return void (s.reposTask = setTimeout(s.adjustPosition.bind(s, i, 0), o));
        var r = s.options;
        if (i === e && (i = r.position), i !== e && null !== i) {
            "function" == typeof i && (i = i(s));
            var l = s.$element.find(".modal-dialog"), c = t(window).height(),
                h = {maxHeight: "initial", overflow: "visible"}, d = l.find(".modal-body").css(h);
            if (r.scrollInside && d.length) {
                var u = r.headerHeight, p = r.footerHeight, f = l.find(".modal-header"), g = l.find(".modal-footer");
                "number" != typeof u && (u = f.length ? f.outerHeight() : "function" == typeof u ? u(f) : 0), "number" != typeof p && (p = g.length ? g.outerHeight() : "function" == typeof p ? p(g) : 0), h.maxHeight = c - u - p, h.overflow = d[0].scrollHeight > h.maxHeight ? "auto" : "visible", d.css(h)
            }
            var m = Math.max(0, (c - l.outerHeight()) / 2);
            if ("fit" === i ? i = {top: m > 50 ? Math.floor(2 * m / 3) : m} : "center" === i ? i = {top: m} : t.isPlainObject(i) || (i = {top: i}), l.hasClass("modal-moveable")) {
                var v = null, y = r.rememberPos;
                y && (y === !0 ? v = s.$element.data("modal-pos") : t.zui.store && (v = t.zui.store.pageGet(n + ".rememberPos." + y))), i = t.extend(i, {left: Math.max(0, (t(window).width() - l.outerWidth()) / 2)}, v), "inside" === r.moveable ? a(l, i) : l.css(i)
            } else l.css(i)
        }
    }, o.prototype.setMoveable = function () {
        t.fn.draggable || console.error("Moveable modal requires draggable.js.");
        var e = this, i = e.options, o = e.$element.find(".modal-dialog").removeClass("modal-dragged");
        o.toggleClass("modal-moveable", !!i.moveable), e.$element.data("modal-moveable-setup") || o.draggable({
            container: e.$element,
            handle: ".modal-header",
            before: function () {
                var t = o.css("margin-top");
                t && "0px" !== t && o.css("top", t).css("margin-top", "").addClass("modal-dragged")
            },
            finish: function (o) {
                var a = i.rememberPos;
                a && (e.$element.data("modal-pos", o.pos), t.zui.store && a !== !0 && t.zui.store.pageSet(n + ".rememberPos." + a, o.pos))
            },
            move: "inside" !== i.moveable || function (t) {
                a(o, t)
            }
        })
    }, o.prototype.show = function (e, i) {
        var a = this, s = t.Event("show." + n, {relatedTarget: e});
        a.$element.trigger(s), a.$element.toggleClass("modal-scroll-inside", !!a.options.scrollInside), a.isShown || s.isDefaultPrevented() || (a.isShown = !0, a.options.moveable && a.setMoveable(), a.options.backdrop !== !1 && (a.setScrollbar(), a.$body.addClass("modal-open")), a.escape(), a.$element.on("click.dismiss." + n, '[data-dismiss="modal"]', function (t) {
            a.hide(), t.stopPropagation()
        }), a.backdrop(function () {
            var s = t.support.transition && a.$element.hasClass("fade");
            a.$element.parent().length || a.$element.appendTo(a.$body), a.$element.show().scrollTop(0), s && a.$element[0].offsetWidth, a.$element.addClass("in").attr("aria-hidden", !1), a.adjustPosition(i), a.enforceFocus();
            var r = t.Event("shown." + n, {relatedTarget: e});
            s ? a.$element.find(".modal-dialog").one("bsTransitionEnd", function () {
                a.$element.trigger("focus").trigger(r)
            }).emulateTransitionEnd(o.TRANSITION_DURATION) : a.$element.trigger("focus").trigger(r)
        }))
    }, o.prototype.hide = function (e) {
        e && e.preventDefault && e.preventDefault();
        var i = this;
        e = t.Event("hide." + n), i.$element.trigger(e), i.isShown && !e.isDefaultPrevented() && (i.isShown = !1, i.options.backdrop !== !1 && (i.$body.removeClass("modal-open"), i.resetScrollbar()), i.escape(), t(document).off("focusin." + n), i.$element.removeClass("in").attr("aria-hidden", !0).off("click.dismiss." + n), t.support.transition && i.$element.hasClass("fade") ? i.$element.one("bsTransitionEnd", i.hideModal.bind(i)).emulateTransitionEnd(o.TRANSITION_DURATION) : i.hideModal())
    }, o.prototype.enforceFocus = function () {
        t(document).off("focusin." + n).on("focusin." + n, function (t) {
            this.$element[0] === t.target || this.$element.has(t.target).length || this.$element.trigger("focus")
        }.bind(this))
    }, o.prototype.escape = function () {
        this.isShown && this.options.keyboard ? t(document).on("keydown.dismiss." + n, function (i) {
            if (27 == i.which) {
                var o = t.Event("escaping." + n), a = this.$element.triggerHandler(o, "esc");
                if (a != e && !a) return;
                this.hide()
            }
        }.bind(this)) : this.isShown || t(document).off("keydown.dismiss." + n)
    }, o.prototype.hideModal = function () {
        var t = this;
        this.$element.hide(), this.backdrop(function () {
            t.$element.trigger("hidden." + n)
        })
    }, o.prototype.removeBackdrop = function () {
        this.$backdrop && this.$backdrop.remove(), this.$backdrop = null
    }, o.prototype.backdrop = function (e) {
        var i = this, a = this.$element.hasClass("fade") ? "fade" : "";
        if (this.isShown && this.options.backdrop) {
            var s = t.support.transition && a;
            if (this.$backdrop = t('<div class="modal-backdrop ' + a + '" />').appendTo(this.$body), this.$element.on("mousedown.dismiss." + n, function (t) {
                t.target === t.currentTarget && ("static" == this.options.backdrop ? this.$element[0].focus.call(this.$element[0]) : this.hide.call(this))
            }.bind(this)), s && this.$backdrop[0].offsetWidth, this.$backdrop.addClass("in"), !e) return;
            s ? this.$backdrop.one("bsTransitionEnd", e).emulateTransitionEnd(o.BACKDROP_TRANSITION_DURATION) : e()
        } else if (!this.isShown && this.$backdrop) {
            this.$backdrop.removeClass("in");
            var r = function () {
                i.removeBackdrop(), e && e()
            };
            t.support.transition && this.$element.hasClass("fade") ? this.$backdrop.one("bsTransitionEnd", r).emulateTransitionEnd(o.BACKDROP_TRANSITION_DURATION) : r()
        } else e && e()
    }, o.prototype.setScrollbar = function () {
        t.zui.fixBodyScrollbar() && this.options.onSetScrollbar && this.options.onSetScrollbar()
    }, o.prototype.resetScrollbar = function () {
        t.zui.resetBodyScrollbar(), this.options.onSetScrollbar && this.options.onSetScrollbar("")
    }, o.prototype.measureScrollbar = function () {
        var t = document.createElement("div");
        t.className = "modal-scrollbar-measure", this.$body.append(t);
        var e = t.offsetWidth - t.clientWidth;
        return this.$body[0].removeChild(t), e
    };
    var s = t.fn.modal;
    t.fn.modal = i, t.fn.modal.Constructor = o, t.fn.modal.noConflict = function () {
        return t.fn.modal = s, this
    }, t(document).on("click." + n + ".data-api", '[data-toggle="modal"]', function (e) {
        var o = t(this), a = o.attr("href"), s = null;
        try {
            s = t(o.attr("data-target") || a && a.replace(/.*(?=#[^\s]+$)/, ""))
        } catch (r) {
            return
        }
        if (s.length) {
            var l = s.data(n) ? "toggle" : t.extend({remote: !/#/.test(a) && a}, s.data(), o.data());
            o.is("a") && e.preventDefault(), s.one("show." + n, function (t) {
                t.isDefaultPrevented() || s.one("hidden." + n, function () {
                    o.is(":visible") && o.trigger("focus")
                })
            }), i.call(s, l, this, o.data("position"))
        }
    })
}(jQuery, void 0), function (t, e, i) {
    "use strict";
    if (!t.fn.modal) throw new Error("Modal trigger requires modal.js");
    var n = "zui.modaltrigger", o = "ajax", a = ".zui.modal", s = "string", r = function (e, i) {
        e = t.extend({}, r.DEFAULTS, t.ModalTriggerDefaults, i ? i.data() : null, e), this.isShown, this.$trigger = i, this.options = e, this.id = t.zui.uuid(), e.show && this.show()
    };
    r.DEFAULTS = {
        type: "custom",
        height: "auto",
        name: "triggerModal",
        fade: !0,
        position: "fit",
        showHeader: !0,
        delay: 0,
        backdrop: !0,
        keyboard: !0,
        waittime: 0,
        loadingIcon: "icon-spinner-indicator",
        scrollInside: !1
    }, r.prototype.initOptions = function (i) {
        if (i.url && (!i.type || i.type != o && "iframe" != i.type) && (i.type = o), i.remote) i.type = o, typeof i.remote === s && (i.url = i.remote); else if (i.iframe) i.type = "iframe", typeof i.iframe === s && (i.url = i.iframe); else if (i.custom && (i.type = "custom", typeof i.custom === s)) {
            var n;
            try {
                n = t(i.custom)
            } catch (a) {
            }
            n && n.length ? i.custom = n : "function" == typeof e[i.custom] && (i.custom = e[i.custom])
        }
        return i
    }, r.prototype.init = function (e) {
        var i = this, o = t("#" + e.name);
        o.length && (i.isShown || o.off(a), o.remove()), o = t('<div id="' + e.name + '" class="modal modal-trigger ' + (e.className || "") + '">' + ("string" == typeof e.loadingIcon && 0 === e.loadingIcon.indexOf("icon-") ? '<div class="icon icon-spin loader ' + e.loadingIcon + '"></div>' : e.loadingIcon) + '<div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button class="close" data-dismiss="modal">×</button><h4 class="modal-title"><i class="modal-icon"></i> <span class="modal-title-name"></span></h4></div><div class="modal-body"></div></div></div></div>').appendTo("body").data(n, i);
        var s = function (t, i, n) {
            n = n || e[t], "function" == typeof n && o.on(i + a, n)
        };
        s("onShow", "show"), s("shown", "shown"), s("onHide", "hide", function (t) {
            if ("iframe" === e.type && i.$iframeBody) {
                var n = i.$iframeBody.triggerHandler("modalhide" + a, [i]);
                n === !1 && t.preventDefault()
            }
            var o = e.onHide;
            if (o) return o(t)
        }), s("hidden", "hidden"), s("loaded", "loaded"), o.on("shown" + a, function () {
            i.isShown = !0
        }).on("hidden" + a, function () {
            i.isShown = !1
        }), this.$modal = o, this.$dialog = o.find(".modal-dialog"), e.mergeOptions && (this.options = e)
    }, r.prototype.show = function (i) {
        var a = this,
            l = t.extend({}, r.DEFAULTS, a.options, {url: a.$trigger ? a.$trigger.attr("href") || a.$trigger.attr("data-url") || a.$trigger.data("url") : a.options.url}, i),
            c = a.isShown;
        l = a.initOptions(l), c || a.init(l);
        var h = a.$modal, d = h.find(".modal-dialog"), u = l.custom,
            p = d.find(".modal-body").css("padding", "").toggleClass("load-indicator loading", !!c),
            f = d.find(".modal-header"), g = d.find(".modal-content");
        h.toggleClass("fade", l.fade).addClass(l.className).toggleClass("modal-loading", !c).toggleClass("modal-scroll-inside", !!l.scrollInside), d.toggleClass("modal-md", "md" === l.size).toggleClass("modal-sm", "sm" === l.size).toggleClass("modal-lg", "lg" === l.size).toggleClass("modal-fullscreen", "fullscreen" === l.size), f.toggle(l.showHeader), f.find(".modal-icon").attr("class", "modal-icon icon-" + l.icon), f.find(".modal-title-name").text(l.title || ""), l.size && "fullscreen" === l.size && (l.width = "", l.height = "");
        var m = function () {
            clearTimeout(this.resizeTask), this.resizeTask = setTimeout(function () {
                a.adjustPosition(l.position)
            }, 100)
        }, v = function (t, e) {
            return "undefined" == typeof t && (t = l.delay), setTimeout(function () {
                d = h.find(".modal-dialog"), l.width && "auto" != l.width && d.css("width", l.width), l.height && "auto" != l.height && (d.css("height", l.height), "iframe" === l.type && p.css("height", d.height() - f.outerHeight())), a.adjustPosition(l.position), h.removeClass("modal-loading").removeClass("modal-updating"), c && p.removeClass("loading"), "iframe" != l.type && (p = d.off("resize." + n).find(".modal-body").off("resize." + n), l.scrollInside && (p = p.children().off("resize." + n)), (p.length ? p : d).on("resize." + n, m)), e && e()
            }, t)
        };
        if ("custom" === l.type && u) if ("function" == typeof u) {
            var y = u({modal: h, options: l, modalTrigger: a, ready: v});
            typeof y === s && (p.html(y), v())
        } else u instanceof t ? (p.html(t("<div>").append(u.clone()).html()), v()) : (p.html(u), v()); else if (l.url) {
            var b = function () {
                var t = h.callComEvent(a, "broken");
                "string" == typeof t && p.html(t), v()
            };
            if (h.attr("ref", l.url), "iframe" === l.type) {
                h.addClass("modal-iframe"), this.firstLoad = !0;
                var w = "iframe-" + l.name;
                f.detach(), p.detach(), g.empty().append(f).append(p), p.css("padding", 0).html('<iframe id="' + w + '" name="' + w + '" src="' + l.url + '" frameborder="no"  allowfullscreen="true" mozallowfullscreen="true" webkitallowfullscreen="true"  allowtransparency="true" scrolling="auto" style="width: 100%; height: 100%; left: 0px;"></iframe>'), l.waittime > 0 && (a.waitTimeout = v(l.waittime, b));
                var x = document.getElementById(w);
                x.onload = x.onreadystatechange = function (i) {
                    var o = !!l.scrollInside;
                    if (a.firstLoad && h.addClass("modal-loading"), !this.readyState || "complete" == this.readyState) {
                        a.firstLoad = !1, l.waittime > 0 && clearTimeout(a.waitTimeout);
                        try {
                            h.attr("ref", x.contentWindow.location.href);
                            var s = e.frames[w];
                            s.modalWidthReset && (l.width = s.modalWidthReset);
                            var r = s.$;
                            if (r && "auto" === l.height && "fullscreen" != l.size) {
                                var c = r("body").addClass("body-modal").toggleClass("body-modal-scroll-inside", o);
                                a.$iframeBody = c, l.iframeBodyClass && c.addClass(l.iframeBodyClass);
                                var d = [], u = function (i) {
                                    h.removeClass("fade");
                                    var n = c.outerHeight();
                                    if (i === !0 && l.onlyIncreaseHeight && (n = Math.max(n, p.data("minModalHeight") || 0), p.data("minModalHeight", n)), o) {
                                        var a = l.headerHeight;
                                        "number" != typeof a ? a = f.outerHeight() : "function" == typeof a && (a = a(f));
                                        var s = t(e).height();
                                        n = Math.min(n, s - a)
                                    }
                                    for (d.length > 1 && n === d[0] && (n = Math.max(n, d[1])), d.push(n); d.length > 2;) d.shift();
                                    p.css("height", n), l.fade && h.addClass("fade"), v()
                                };
                                h.callComEvent(a, "loaded", {
                                    modalType: "iframe",
                                    jQuery: r
                                }), setTimeout(u, 100), c.off("resize." + n).on("resize." + n, u), o && t(e).off("resize." + n).on("resize." + n, u)
                            } else v();
                            var g = l.handleLinkInIframe;
                            g && r("body").on("click", "string" == typeof g ? g : "a[href]", function () {
                                t(this).is('[data-toggle="modal"]') || h.addClass("modal-updating")
                            }), l.iframeStyle && r("head").append("<style>" + l.iframeStyle + "</style>")
                        } catch (i) {
                            v()
                        }
                    }
                }
            } else t.ajax(t.extend({
                url: l.url, success: function (i) {
                    try {
                        var s = t(i);
                        s.filter(".modal-dialog").length ? d.parent().empty().append(s) : s.filter(".modal-content").length ? d.find(".modal-content").replaceWith(s) : p.wrapInner(s)
                    } catch (r) {
                        e.console && e.console.warn && console.warn("ZUI: Cannot recogernize remote content.", {
                            error: r,
                            data: i
                        }), h.html(i)
                    }
                    h.callComEvent(a, "loaded", {modalType: o}), v(), l.scrollInside && t(e).off("resize." + n).on("resize." + n, m)
                }, error: b
            }, l.ajaxOptions))
        }
        c || h.modal({
            show: "show",
            backdrop: l.backdrop,
            moveable: l.moveable,
            rememberPos: l.rememberPos,
            keyboard: l.keyboard,
            scrollInside: l.scrollInside
        })
    }, r.prototype.close = function (t, i) {
        var n = this;
        (t || i) && n.$modal.on("hidden" + a, function () {
            "function" == typeof t && t(), typeof i === s && i.length && !n.$modal.data("cancel-reload") && ("this" === i ? e.location.reload() : e.location = i)
        }), n.$modal.modal("hide")
    }, r.prototype.toggle = function (t) {
        this.isShown ? this.close() : this.show(t)
    }, r.prototype.adjustPosition = function (t) {
        t = t === i ? this.options.position : t, "function" == typeof t && (t = t(this)), this.$modal.modal("adjustPosition", t)
    }, t.zui({ModalTrigger: r, modalTrigger: new r}), t.fn.modalTrigger = function (e, i) {
        return t(this).each(function () {
            var o = t(this), a = o.data(n), l = t.extend({
                title: o.attr("title") || o.text(),
                url: o.attr("href"),
                type: o.hasClass("iframe") ? "iframe" : ""
            }, o.data(), t.isPlainObject(e) && e);
            return a ? void (typeof e == s ? a[e](i) : l.show && a.show(i)) : (o.data(n, a = new r(l, o)), void o.on((l.trigger || "click") + ".toggle." + n, function (e) {
                l = t.extend(l, {url: o.attr("href") || o.attr("data-url") || o.data("url") || l.url}), a.toggle(l), o.is("a") && e.preventDefault()
            }))
        })
    };
    var l = t.fn.modal;
    t.fn.modal = function (e, i) {
        return t(this).each(function () {
            var n = t(this);
            n.hasClass("modal") ? l.call(n, e, i) : n.modalTrigger(e, i)
        })
    }, t.fn.modal.bs = l;
    var c = function (e) {
        return e = t(e || ".modal.modal-trigger.in"), e && e instanceof t ? e : null
    }, h = function (i, o, a) {
        var s = i;
        if ("function" == typeof i) {
            var r = a;
            a = o, o = i, i = r
        }
        i = c(i), i && i.length ? i.each(function () {
            t(this).data(n).close(o, a)
        }) : t("body").hasClass("modal-open") || t(".modal.in").length || t("body").hasClass("body-modal") && e.parent.$.zui.closeModal(s, o, a)
    }, d = function (t, e) {
        e = c(e), e && e.length && e.modal("adjustPosition", t)
    }, u = function (e, i) {
        "string" == typeof e && (e = {url: e});
        var o = c(i);
        o && o.length && o.each(function () {
            t(this).data(n).show(e)
        })
    };
    t.zui({
        reloadModal: u,
        closeModal: h,
        ajustModalPosition: d,
        adjustModalPosition: d
    }), t(document).on("click." + n + ".data-api", '[data-toggle="modal"]', function (e) {
        var i = t(this), o = i.attr("href"), a = null;
        try {
            a = t(i.attr("data-target") || o && o.replace(/.*(?=#[^\s]+$)/, ""))
        } catch (s) {
        }
        a && a.length || (i.data(n) ? i.trigger(".toggle." + n) : i.modalTrigger({show: !0})), i.is("a") && e.preventDefault()
    }).on("click." + n + ".data-api", '[data-dismiss="modal"]', function () {
        t.zui.closeModal()
    })
}(window.jQuery, window, void 0), +function (t) {
    "use strict";
    var e = function (t, e) {
        this.type = null, this.options = null, this.enabled = null, this.timeout = null, this.hoverState = null, this.$element = null, this.init("tooltip", t, e)
    };
    e.DEFAULTS = {
        animation: !0,
        placement: "top",
        selector: !1,
        template: '<div class="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>',
        trigger: "hover focus",
        title: "",
        delay: 0,
        html: !1,
        container: !1
    }, e.prototype.init = function (e, i, n) {
        this.enabled = !0, this.type = e, this.$element = t(i), this.options = this.getOptions(n);
        for (var o = this.options.trigger.split(" "), a = o.length; a--;) {
            var s = o[a];
            if ("click" == s) this.$element.on("click." + this.type, this.options.selector, this.toggle.bind(this)); else if ("manual" != s) {
                var r = "hover" == s ? "mouseenter" : "focus", l = "hover" == s ? "mouseleave" : "blur";
                this.$element.on(r + "." + this.type, this.options.selector, this.enter.bind(this)), this.$element.on(l + "." + this.type, this.options.selector, this.leave.bind(this))
            }
        }
        this.options.selector ? this._options = t.extend({}, this.options, {
            trigger: "manual",
            selector: ""
        }) : this.fixTitle()
    }, e.prototype.getDefaults = function () {
        return e.DEFAULTS
    }, e.prototype.getOptions = function (e) {
        return e = t.extend({}, this.getDefaults(), this.$element.data(), e), e.delay && "number" == typeof e.delay && (e.delay = {
            show: e.delay,
            hide: e.delay
        }), e
    }, e.prototype.getDelegateOptions = function () {
        var e = {}, i = this.getDefaults();
        return this._options && t.each(this._options, function (t, n) {
            i[t] != n && (e[t] = n)
        }), e
    }, e.prototype.enter = function (e) {
        var i = e instanceof this.constructor ? e : t(e.currentTarget)[this.type](this.getDelegateOptions()).data("zui." + this.type);
        return clearTimeout(i.timeout), i.hoverState = "in", i.options.delay && i.options.delay.show ? void (i.timeout = setTimeout(function () {
            "in" == i.hoverState && i.show()
        }, i.options.delay.show)) : i.show()
    }, e.prototype.leave = function (e) {
        var i = e instanceof this.constructor ? e : t(e.currentTarget)[this.type](this.getDelegateOptions()).data("zui." + this.type);
        return clearTimeout(i.timeout), i.hoverState = "out", i.options.delay && i.options.delay.hide ? void (i.timeout = setTimeout(function () {
            "out" == i.hoverState && i.hide()
        }, i.options.delay.hide)) : i.hide()
    }, e.prototype.show = function (e) {
        var i = t.Event("show.zui." + this.type);
        if ((e || this.hasContent()) && this.enabled) {
            var n = this;
            if (n.$element.trigger(i), i.isDefaultPrevented()) return;
            var o = n.tip();
            n.setContent(e), n.options.animation && o.addClass("fade");
            var a = "function" == typeof n.options.placement ? n.options.placement.call(n, o[0], n.$element[0]) : n.options.placement,
                s = /\s?auto?\s?/i, r = s.test(a);
            r && (a = a.replace(s, "") || "top"), o.detach().css({
                top: 0,
                left: 0,
                display: "block"
            }).addClass(a), n.options.container ? o.appendTo(n.options.container) : o.insertAfter(n.$element);
            var l = n.getPosition(), c = o[0].offsetWidth, h = o[0].offsetHeight;
            if (r) {
                var d = n.$element.parent(), u = a, p = document.documentElement.scrollTop || document.body.scrollTop,
                    f = "body" == n.options.container ? window.innerWidth : d.outerWidth(),
                    g = "body" == n.options.container ? window.innerHeight : d.outerHeight(),
                    m = "body" == n.options.container ? 0 : d.offset().left;
                a = "bottom" == a && l.top + l.height + h - p > g ? "top" : "top" == a && l.top - p - h < 0 ? "bottom" : "right" == a && l.right + c > f ? "left" : "left" == a && l.left - c < m ? "right" : a, o.removeClass(u).addClass(a)
            }
            var v = n.getCalculatedOffset(a, l, c, h);
            n.applyPlacement(v, a);
            var y = function () {
                var t = n.hoverState;
                n.$element.trigger("shown.zui." + n.type), n.hoverState = null, "out" == t && n.leave(n)
            };
            t.support.transition && n.$tip.hasClass("fade") ? o.one("bsTransitionEnd", y).emulateTransitionEnd(150) : y()
        }
    }, e.prototype.applyPlacement = function (t, e) {
        var i, n = this.tip(), o = n[0].offsetWidth, a = n[0].offsetHeight, s = parseInt(n.css("margin-top"), 10),
            r = parseInt(n.css("margin-left"), 10);
        isNaN(s) && (s = 0), isNaN(r) && (r = 0), t.top = t.top + s, t.left = t.left + r, n.offset(t).addClass("in");
        var l = n[0].offsetWidth, c = n[0].offsetHeight;
        if ("top" == e && c != a && (i = !0, t.top = t.top + a - c), /bottom|top/.test(e)) {
            var h = 0;
            t.left < 0 && (h = t.left * -2, t.left = 0, n.offset(t), l = n[0].offsetWidth, c = n[0].offsetHeight), this.replaceArrow(h - o + l, l, "left")
        } else this.replaceArrow(c - a, c, "top");
        i && n.offset(t)
    }, e.prototype.replaceArrow = function (t, e, i) {
        this.arrow().css(i, t ? 50 * (1 - t / e) + "%" : "")
    }, e.prototype.setContent = function (t) {
        var e = this.tip(), i = t || this.getTitle();
        this.options.tipId && e.attr("id", this.options.tipId), this.options.tipClass && e.addClass(this.options.tipClass), e.find(".tooltip-inner")[this.options.html ? "html" : "text"](i), e.removeClass("fade in top bottom left right")
    }, e.prototype.hide = function () {
        function e() {
            "in" != i.hoverState && n.detach()
        }

        var i = this, n = this.tip(), o = t.Event("hide.zui." + this.type);
        if (this.$element.trigger(o), !o.isDefaultPrevented()) return n.removeClass("in"), t.support.transition && this.$tip.hasClass("fade") ? n.one(t.support.transition.end, e).emulateTransitionEnd(150) : e(), this.$element.trigger("hidden.zui." + this.type), this
    }, e.prototype.fixTitle = function () {
        var t = this.$element;
        (t.attr("title") || "string" != typeof t.attr("data-original-title")) && t.attr("data-original-title", t.attr("title") || "").attr("title", "")
    }, e.prototype.hasContent = function () {
        return this.getTitle()
    }, e.prototype.getPosition = function () {
        var e = this.$element[0];
        return t.extend({}, "function" == typeof e.getBoundingClientRect ? e.getBoundingClientRect() : {
            width: e.offsetWidth,
            height: e.offsetHeight
        }, this.$element.offset())
    }, e.prototype.getCalculatedOffset = function (t, e, i, n) {
        return "bottom" == t ? {
            top: e.top + e.height,
            left: e.left + e.width / 2 - i / 2
        } : "top" == t ? {
            top: e.top - n,
            left: e.left + e.width / 2 - i / 2
        } : "left" == t ? {top: e.top + e.height / 2 - n / 2, left: e.left - i} : {
            top: e.top + e.height / 2 - n / 2,
            left: e.left + e.width
        }
    }, e.prototype.getTitle = function () {
        var t, e = this.$element, i = this.options;
        return t = e.attr("data-original-title") || ("function" == typeof i.title ? i.title.call(e[0]) : i.title)
    }, e.prototype.tip = function () {
        return this.$tip = this.$tip || t(this.options.template)
    }, e.prototype.arrow = function () {
        return this.$arrow = this.$arrow || this.tip().find(".tooltip-arrow")
    }, e.prototype.validate = function () {
        this.$element[0].parentNode || (this.hide(), this.$element = null, this.options = null)
    }, e.prototype.enable = function () {
        this.enabled = !0
    }, e.prototype.disable = function () {
        this.enabled = !1
    }, e.prototype.toggleEnabled = function () {
        this.enabled = !this.enabled
    }, e.prototype.toggle = function (e) {
        var i = e ? t(e.currentTarget)[this.type](this.getDelegateOptions()).data("zui." + this.type) : this;
        i.tip().hasClass("in") ? i.leave(i) : i.enter(i)
    }, e.prototype.destroy = function () {
        this.hide().$element.off("." + this.type).removeData("zui." + this.type)
    };
    var i = t.fn.tooltip;
    t.fn.tooltip = function (i, n) {
        return this.each(function () {
            var o = t(this), a = o.data("zui.tooltip"), s = "object" == typeof i && i;
            a || o.data("zui.tooltip", a = new e(this, s)), "string" == typeof i && a[i](n)
        })
    }, t.fn.tooltip.Constructor = e, t.fn.tooltip.noConflict = function () {
        return t.fn.tooltip = i, this
    }
}(window.jQuery), +function (t) {
    "use strict";
    var e = function (t, e) {
        this.init("popover", t, e)
    };
    if (!t.fn.tooltip) throw new Error("Popover requires tooltip.js");
    e.DEFAULTS = t.extend({}, t.fn.tooltip.Constructor.DEFAULTS, {
        placement: "right",
        trigger: "click",
        content: "",
        template: '<div class="popover"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>'
    }), e.prototype = t.extend({}, t.fn.tooltip.Constructor.prototype), e.prototype.constructor = e, e.prototype.getDefaults = function () {
        return e.DEFAULTS
    }, e.prototype.setContent = function () {
        var t = this.tip(), e = this.getTarget();
        if (e) return e.find(".arrow").length < 1 && t.addClass("no-arrow"), void t.html(e.html());
        var i = this.getTitle(), n = this.getContent();
        t.find(".popover-title")[this.options.html ? "html" : "text"](i), t.find(".popover-content")[this.options.html ? "html" : "text"](n), t.removeClass("fade top bottom left right in"), this.options.tipId && t.attr("id", this.options.tipId), this.options.tipClass && t.addClass(this.options.tipClass), t.find(".popover-title").html() || t.find(".popover-title").hide()
    }, e.prototype.hasContent = function () {
        return this.getTarget() || this.getTitle() || this.getContent()
    }, e.prototype.getContent = function () {
        var t = this.$element, e = this.options;
        return t.attr("data-content") || ("function" == typeof e.content ? e.content.call(t[0]) : e.content)
    }, e.prototype.getTarget = function () {
        var e = this.$element, i = this.options,
            n = e.attr("data-target") || ("function" == typeof i.target ? i.target.call(e[0]) : i.target);
        return !!n && ("$next" == n ? e.next(".popover") : t(n))
    }, e.prototype.arrow = function () {
        return this.$arrow = this.$arrow || this.tip().find(".arrow")
    }, e.prototype.tip = function () {
        return this.$tip || (this.$tip = t(this.options.template)), this.$tip
    };
    var i = t.fn.popover;
    t.fn.popover = function (i) {
        return this.each(function () {
            var n = t(this), o = n.data("zui.popover"), a = "object" == typeof i && i;
            o || n.data("zui.popover", o = new e(this, a)), "string" == typeof i && o[i]()
        })
    }, t.fn.popover.Constructor = e, t.fn.popover.noConflict = function () {
        return t.fn.popover = i, this
    }
}(window.jQuery), +function (t) {
    "use strict";

    function e(e) {
        t(o).remove(), t(a).each(function (e) {
            var o = i(t(this));
            o.hasClass("open") && (o.trigger(e = t.Event("hide." + n)), e.isDefaultPrevented() || o.removeClass("open").trigger("hidden." + n))
        })
    }

    function i(e) {
        var i = e.attr("data-target");
        i || (i = e.attr("href"), i = i && /#/.test(i) && i.replace(/.*(?=#[^\s]*$)/, ""));
        var n;
        try {
            n = i && t(i)
        } catch (o) {
        }
        return n && n.length ? n : e.parent()
    }

    var n = "zui.dropdown", o = ".dropdown-backdrop", a = "[data-toggle=dropdown]", s = function (e) {
        t(e).on("click." + n, this.toggle)
    };
    s.prototype.toggle = function (o) {
        var a = t(this);
        if (!a.is(".disabled, :disabled")) {
            var s = i(a), r = s.hasClass("open");
            if (e(), !r) {
                if ("ontouchstart" in document.documentElement && !s.closest(".navbar-nav").length && t('<div class="dropdown-backdrop"/>').insertAfter(t(this)).on("click", e), s.trigger(o = t.Event("show." + n)), o.isDefaultPrevented()) return;
                s.toggleClass("open").trigger("shown." + n), a.focus()
            }
            return !1
        }
    }, s.prototype.keydown = function (e) {
        if (/(38|40|27)/.test(e.keyCode)) {
            var n = t(this);
            if (e.preventDefault(), e.stopPropagation(), !n.is(".disabled, :disabled")) {
                var o = i(n), s = o.hasClass("open");
                if (!s || s && 27 == e.keyCode) return 27 == e.which && o.find(a).focus(), n.click();
                var r = t("[role=menu] li:not(.divider):visible a", o);
                if (r.length) {
                    var l = r.index(r.filter(":focus"));
                    38 == e.keyCode && l > 0 && l--, 40 == e.keyCode && l < r.length - 1 && l++, ~l || (l = 0), r.eq(l).focus()
                }
            }
        }
    };
    var r = t.fn.dropdown;
    t.fn.dropdown = function (e) {
        return this.each(function () {
            var i = t(this), n = i.data("dropdown");
            n || i.data("dropdown", n = new s(this)), "string" == typeof e && n[e].call(i)
        })
    }, t.fn.dropdown.Constructor = s, t.fn.dropdown.noConflict = function () {
        return t.fn.dropdown = r, this
    };
    var l = n + ".data-api";
    t(document).on("click." + l, e).on("click." + l, ".dropdown form,.not-clear-menu", function (t) {
        t.stopPropagation()
    }).on("click." + l, a, s.prototype.toggle).on("keydown." + l, a + ", [role=menu]", s.prototype.keydown)
}(window.jQuery), +function (t) {
    t(document).on("mouseenter.zui.dropdown", ".dropdown-submenu", function () {
        var e = t(this).children(".dropdown-menu"), i = e.closest(".dropup ").length;
        e.css(i ? "bottom" : "top", 0), (t.zui.asap || setTimout)(function () {
            var n = e[0].getBoundingClientRect();
            if (i) e.css("bottom", n.top < 0 ? n.top : 0); else {
                var o = t(window).height() - n.bottom;
                e.css("top", o < 0 ? o : 0)
            }
        }, 0)
    })
}(window.jQuery), function (t, e, i) {
    "use strict";
    var n = 0,
        o = '<div class="messager messager-{type} {placement}" style="display: none"><div class="messager-content"></div><div class="messager-actions"></div></div>',
        a = {icons: {}, type: "default", placement: "top", time: 4e3, parent: "body", close: !0, fade: !0, scale: !0},
        s = {}, r = function (e, r) {
            t.isPlainObject(e) ? r = t.extend({}, r, e) : e && (r ? r.content = e : r = {content: e});
            var l = this;
            r = l.options = t.extend({}, a, r), l.id = r.id || n++;
            var c = s[l.id];
            c && c.destroy(), s[l.id] = l, l.$ = t(o.format(r)).toggleClass("fade", r.fade).toggleClass("scale", r.scale).attr("id", "messager-" + l.id), r.cssClass && l.$.addClass(r.cssClass);
            var h = !1, d = l.$.find(".messager-actions"), u = function (e) {
                var n = t('<button type="button" class="action action-' + e.name + '"/>');
                "close" === e.name && n.addClass("close"), e.html !== i && n.html(e.html), e.icon !== i && n.append('<i class="action-icon icon-' + e.icon + '"/>'), e.text !== i && n.append('<span class="action-text">' + e.text + "</span>"), e.tooltip !== i && n.attr("title", e.tooltip).tooltip(), n.data("action", e), d.append(n)
            };
            r.actions && t.each(r.actions, function (t, e) {
                e.name === i && (e.name = t), "close" == e.name && (h = !0), u(e)
            }), !h && r.close && u({name: "close", html: "&times;"}), l.$.on("click", ".action", function (e) {
                var i, n = t(this).data("action");
                r.onAction && (i = r.onAction.call(this, n.name, n, l), i === !1) || "function" == typeof n.action && (i = n.action.call(this, l), i === !1) || (l.hide(), e.stopPropagation())
            }), l.$.on("click", function (t) {
                if (r.onAction) {
                    var e = r.onAction.call(this, "content", null, l);
                    e === !0 && l.hide()
                }
            }), l.$.data("zui.messager", l), r.show && l.message !== i && l.show()
        };
    r.prototype.update = function (e, i) {
        t.isPlainObject(e) ? i = e : e && (i ? i.content = e : i = {content: e});
        var n = this, o = n.options;
        n.$.removeClass("messager-" + o.type);
        var a = n.$.find(".messager-content");
        o.contentClass && a.removeClass(o.contentClass), i && (o = t.extend(o, i)), n.$.addClass("messager-" + o.type).toggleClass("messager-notification", !!o.notification), o.contentClass && a.addClass(o.contentClass);
        var s = o.title, r = o.icon;
        if (e = o.content, a.empty(), s) {
            var l = t('<div class="messager-title"></div>');
            l[o.html ? "html" : "text"](s), a.append(l)
        }
        if (e) {
            var c = t('<div class="messager-text"></div>');
            c[o.html ? "html" : "text"](e), a.append(c)
        }
        var h = n.$.find(".messager-icon");
        if (r) {
            var d = t.isPlainObject(r) ? r.html : '<i class="icon-' + r + ' icon"></i>';
            h.length ? h.html(d) : a.before('<div class="messager-icon">' + d + "<div>")
        } else h.remove();
        n.$.toggleClass("messager-has-icon", !!r), n.updateTime || o.onUpdate && o.onUpdate.call(n, o), n.updateTime = Date.now()
    }, r.prototype.show = function (n, o) {
        var a = this, s = this.options;
        if ("function" == typeof n) {
            var r = o;
            o = n, r !== i && (n = r)
        }
        if (a.isShow) return void a.hide(function () {
            a.show(n, o)
        });
        a.hiding && (clearTimeout(a.hiding), a.hiding = null), a.update(n);
        var l = s.placement, c = t(s.parent), h = c.children(".messagers-holder." + l);
        if (h.length || (h = t("<div/>").attr("class", "messagers-holder " + l).appendTo(c)), h.append(a.$), "center" === l) {
            var d = t(e).height() - h.height();
            h.css("top", Math.max(-d, d / 2))
        }
        return a.$.show().addClass("in"), s.time && (a.hiding = setTimeout(function () {
            a.hide()
        }, s.time)), a.isShow = !0, o && o(), s.onShow && s.onShow.call(a, s), a
    }, r.prototype.hide = function (t, e) {
        t === !0 && (e = !0, t = null);
        var i = this, n = i.options;
        if (i.$.hasClass("in")) {
            i.$.removeClass("in");
            var o = function () {
                var o = i.$.parent();
                i.$.detach(), o.children().length || o.remove(), t && t(!0), n.onHide && n.onHide.call(i, e)
            };
            e ? o() : setTimeout(o, 200)
        } else t && t(!1), n.onHide && n.onHide.call(i, e);
        i.isShow = !1
    }, r.prototype.destroy = function () {
        var t = this;
        t.hide(function () {
            t.$.remove(), t.$ = null
        }, !0), delete s[t.id]
    };
    var l = function (e) {
        if (e === i) t(".messager").each(function () {
            var e = t(this).data("zui.messager");
            e && e.hide && e.hide(!0)
        }); else {
            var n = t("#messager-" + e).data("zui.messager");
            n && n.hide && n.hide()
        }
    }, c = function (e, n) {
        "string" == typeof n && (n = {type: n}), t.isPlainObject(e) && (n = t.extend({}, n, e), e = null), n = t.extend({}, n), n.id === i && l();
        var o = s[n.id] || new r(e, n);
        return o.show(), o
    }, h = {notification: !0, placement: "bottom-right", time: 0, icon: "bell icon-2x"}, d = function (e, i, n) {
        var o = t.extend({id: t.zui.uuid()}, h), a = "string" == typeof e, s = "string" == typeof i;
        return a && s ? n = t.extend(o, n, {
            title: e,
            content: i
        }) : a && t.isPlainObject(i) ? n = t.extend(o, n, i, {title: e}) : t.isPlainObject(e) ? n = t.extend(o, n, i, e) : a && (n = t.extend(o, n, {title: e})), c(n)
    }, u = function (t) {
        return "string" == typeof t ? {placement: t} : t
    }, p = {show: c, hide: l};
    r.all = s, r.DEFAULTS = a, r.NOTIFICATION_DEFAULTS = h, t.each({
        primary: 0,
        success: "ok-sign",
        info: "info-sign",
        warning: "warning-sign",
        danger: "exclamation-sign",
        important: 0,
        special: 0
    }, function (e, i) {
        p[e] = function (n, o) {
            return c(n, t.extend({type: e, icon: r.DEFAULTS.icons[e] || i || null}, u(o)))
        }
    }), t.zui({Messager: r, showMessager: c, showNotification: d, messager: p})
}(jQuery, window, void 0), function (t, e, i, n) {
    "use strict";

    function o(t) {
        if (t = t.toLowerCase(), t && h.test(t)) {
            var e;
            if (4 === t.length) {
                var i = "#";
                for (e = 1; e < 4; e += 1) i += t.slice(e, e + 1).concat(t.slice(e, e + 1));
                t = i
            }
            var n = [];
            for (e = 1; e < 7; e += 2) n.push(b("0x" + t.slice(e, e + 2)));
            return {r: n[0], g: n[1], b: n[2], a: 1}
        }
        throw new Error("Wrong hex string! (hex: " + t + ")")
    }

    function a(e) {
        return typeof e === f && ("transparent" === e.toLowerCase() || m[e.toLowerCase()] || h.test(t.trim(e.toLowerCase())))
    }

    function s(t) {
        function e(t) {
            return t = t < 0 ? t + 1 : t > 1 ? t - 1 : t, 6 * t < 1 ? r + (s - r) * t * 6 : 2 * t < 1 ? s : 3 * t < 2 ? r + (s - r) * (2 / 3 - t) * 6 : r
        }

        var i = t.h, n = t.s, o = t.l, a = t.a;
        i = c(i) % u / u, n = l(c(n)), o = l(c(o)), a = l(c(a));
        var s = o <= .5 ? o * (n + 1) : o + n - o * n, r = 2 * o - s,
            h = {r: e(i + 1 / 3) * d, g: e(i) * d, b: e(i - 1 / 3) * d, a: a};
        return h
    }

    function r(t, i, n) {
        return v(n) && (n = 0), v(i) && (i = d), e.min(e.max(t, n), i)
    }

    function l(t, e) {
        return r(t, e)
    }

    function c(t) {
        return "number" == typeof t ? t : parseFloat(t)
    }

    var h = /^#([0-9a-fA-f]{3}|[0-9a-fA-f]{6})$/, d = 255, u = 360, p = 100, f = "string", g = "object", m = {
        aliceblue: "#f0f8ff",
        antiquewhite: "#faebd7",
        aqua: "#00ffff",
        aquamarine: "#7fffd4",
        azure: "#f0ffff",
        beige: "#f5f5dc",
        bisque: "#ffe4c4",
        black: "#000000",
        blanchedalmond: "#ffebcd",
        blue: "#0000ff",
        blueviolet: "#8a2be2",
        brown: "#a52a2a",
        burlywood: "#deb887",
        cadetblue: "#5f9ea0",
        chartreuse: "#7fff00",
        chocolate: "#d2691e",
        coral: "#ff7f50",
        cornflowerblue: "#6495ed",
        cornsilk: "#fff8dc",
        crimson: "#dc143c",
        cyan: "#00ffff",
        darkblue: "#00008b",
        darkcyan: "#008b8b",
        darkgoldenrod: "#b8860b",
        darkgray: "#a9a9a9",
        darkgreen: "#006400",
        darkkhaki: "#bdb76b",
        darkmagenta: "#8b008b",
        darkolivegreen: "#556b2f",
        darkorange: "#ff8c00",
        darkorchid: "#9932cc",
        darkred: "#8b0000",
        darksalmon: "#e9967a",
        darkseagreen: "#8fbc8f",
        darkslateblue: "#483d8b",
        darkslategray: "#2f4f4f",
        darkturquoise: "#00ced1",
        darkviolet: "#9400d3",
        deeppink: "#ff1493",
        deepskyblue: "#00bfff",
        dimgray: "#696969",
        dodgerblue: "#1e90ff",
        firebrick: "#b22222",
        floralwhite: "#fffaf0",
        forestgreen: "#228b22",
        fuchsia: "#ff00ff",
        gainsboro: "#dcdcdc",
        ghostwhite: "#f8f8ff",
        gold: "#ffd700",
        goldenrod: "#daa520",
        gray: "#808080",
        green: "#008000",
        greenyellow: "#adff2f",
        honeydew: "#f0fff0",
        hotpink: "#ff69b4",
        indianred: "#cd5c5c",
        indigo: "#4b0082",
        ivory: "#fffff0",
        khaki: "#f0e68c",
        lavender: "#e6e6fa",
        lavenderblush: "#fff0f5",
        lawngreen: "#7cfc00",
        lemonchiffon: "#fffacd",
        lightblue: "#add8e6",
        lightcoral: "#f08080",
        lightcyan: "#e0ffff",
        lightgoldenrodyellow: "#fafad2",
        lightgray: "#d3d3d3",
        lightgreen: "#90ee90",
        lightpink: "#ffb6c1",
        lightsalmon: "#ffa07a",
        lightseagreen: "#20b2aa",
        lightskyblue: "#87cefa",
        lightslategray: "#778899",
        lightsteelblue: "#b0c4de",
        lightyellow: "#ffffe0",
        lime: "#00ff00",
        limegreen: "#32cd32",
        linen: "#faf0e6",
        magenta: "#ff00ff",
        maroon: "#800000",
        mediumaquamarine: "#66cdaa",
        mediumblue: "#0000cd",
        mediumorchid: "#ba55d3",
        mediumpurple: "#9370db",
        mediumseagreen: "#3cb371",
        mediumslateblue: "#7b68ee",
        mediumspringgreen: "#00fa9a",
        mediumturquoise: "#48d1cc",
        mediumvioletred: "#c71585",
        midnightblue: "#191970",
        mintcream: "#f5fffa",
        mistyrose: "#ffe4e1",
        moccasin: "#ffe4b5",
        navajowhite: "#ffdead",
        navy: "#000080",
        oldlace: "#fdf5e6",
        olive: "#808000",
        olivedrab: "#6b8e23",
        orange: "#ffa500",
        orangered: "#ff4500",
        orchid: "#da70d6",
        palegoldenrod: "#eee8aa",
        palegreen: "#98fb98",
        paleturquoise: "#afeeee",
        palevioletred: "#db7093",
        papayawhip: "#ffefd5",
        peachpuff: "#ffdab9",
        peru: "#cd853f",
        pink: "#ffc0cb",
        plum: "#dda0dd",
        powderblue: "#b0e0e6",
        purple: "#800080",
        red: "#ff0000",
        rosybrown: "#bc8f8f",
        royalblue: "#4169e1",
        saddlebrown: "#8b4513",
        salmon: "#fa8072",
        sandybrown: "#f4a460",
        seagreen: "#2e8b57",
        seashell: "#fff5ee",
        sienna: "#a0522d",
        silver: "#c0c0c0",
        skyblue: "#87ceeb",
        slateblue: "#6a5acd",
        slategray: "#708090",
        snow: "#fffafa",
        springgreen: "#00ff7f",
        steelblue: "#4682b4",
        tan: "#d2b48c",
        teal: "#008080",
        thistle: "#d8bfd8",
        tomato: "#ff6347",
        turquoise: "#40e0d0",
        violet: "#ee82ee",
        wheat: "#f5deb3",
        white: "#ffffff",
        whitesmoke: "#f5f5f5",
        yellow: "#ffff00",
        yellowgreen: "#9acd32"
    }, v = function (t) {
        return t === n
    }, y = function (t) {
        return !v(t)
    }, b = function (t) {
        return parseInt(t)
    }, w = function (t) {
        return b(l(c(t), d))
    }, x = function (t, e, i, n) {
        var a = this;
        if (a.r = a.g = a.b = 0, a.a = 1, y(n) && (a.a = l(c(n), 1)), y(t) && y(e) && y(i)) a.r = w(t), a.g = w(e), a.b = w(i); else if (y(t)) {
            var r = typeof t;
            if (r == f) if (t = t.toLowerCase(), "transparent" === t) a.a = 0; else if (m[t]) a.rgb(o(m[t])); else if (0 === t.indexOf("rgb")) {
                var h = t.substring(t.indexOf("(") + 1, t.lastIndexOf(")")).split(",", 4);
                a.rgb({r: h[0], g: h[1], b: h[2], a: h[3]})
            } else a.rgb(o(t)); else if ("number" == r && v(e)) a.r = a.g = a.b = w(t); else if (r == g && y(t.r)) a.r = w(t.r), y(t.g) && (a.g = w(t.g)), y(t.b) && (a.b = w(t.b)), y(t.a) && (a.a = l(c(t.a), 1)); else if (r == g && y(t.h)) {
                var d = {h: l(c(t.h), u), s: 1, l: 1, a: 1};
                y(t.s) && (d.s = l(c(t.s), 1)), y(t.l) && (d.l = l(c(t.l), 1)), y(t.a) && (d.a = l(c(t.a), 1)), a.rgb(s(d))
            }
        }
    };
    x.prototype.rgb = function (t) {
        var e = this;
        if (y(t)) {
            if (typeof t == g) y(t.r) && (e.r = w(t.r)), y(t.g) && (e.g = w(t.g)), y(t.b) && (e.b = w(t.b)), y(t.a) && (e.a = l(c(t.a), 1)); else {
                var i = b(c(t));
                e.r = i, e.g = i, e.b = i
            }
            return e
        }
        return {r: e.r, g: e.g, b: e.b, a: e.a}
    }, x.prototype.hue = function (t) {
        var e = this, i = e.toHsl();
        return v(t) ? i.h : (i.h = l(c(t), u), e.rgb(s(i)), e)
    }, x.prototype.darken = function (t) {
        var e = this, i = e.toHsl();
        return i.l -= t / p, i.l = l(i.l, 1), e.rgb(s(i)), e
    }, x.prototype.clone = function () {
        var t = this;
        return new x(t.r, t.g, t.b, t.a)
    }, x.prototype.lighten = function (t) {
        return this.darken(-t)
    }, x.prototype.fade = function (t) {
        return this.a = l(t / p, 1), this
    }, x.prototype.spin = function (t) {
        var e = this.toHsl(), i = (e.h + t) % u;
        return e.h = i < 0 ? u + i : i, this.rgb(s(e))
    }, x.prototype.toHsl = function () {
        var t, i, n = this, o = n.r / d, a = n.g / d, s = n.b / d, r = n.a, l = e.max(o, a, s), c = e.min(o, a, s),
            h = (l + c) / 2, p = l - c;
        if (l === c) t = i = 0; else {
            switch (i = h > .5 ? p / (2 - l - c) : p / (l + c), l) {
                case o:
                    t = (a - s) / p + (a < s ? 6 : 0);
                    break;
                case a:
                    t = (s - o) / p + 2;
                    break;
                case s:
                    t = (o - a) / p + 4
            }
            t /= 6
        }
        return {h: t * u, s: i, l: h, a: r}
    }, x.prototype.luma = function () {
        var t = this.r / d, i = this.g / d, n = this.b / d;
        return t = t <= .03928 ? t / 12.92 : e.pow((t + .055) / 1.055, 2.4), i = i <= .03928 ? i / 12.92 : e.pow((i + .055) / 1.055, 2.4), n = n <= .03928 ? n / 12.92 : e.pow((n + .055) / 1.055, 2.4), .2126 * t + .7152 * i + .0722 * n
    }, x.prototype.saturate = function (t) {
        var e = this.toHsl();
        return e.s += t / p, e.s = l(e.s), this.rgb(s(e))
    }, x.prototype.desaturate = function (t) {
        return this.saturate(-t)
    }, x.prototype.contrast = function (t, e, i) {
        if (e = v(e) ? new x(d, d, d, 1) : new x(e), t = v(t) ? new x(0, 0, 0, 1) : new x(t), t.luma() > e.luma()) {
            var n = e;
            e = t, t = n
        }
        return this.a < .5 ? t : (i = v(i) ? .43 : c(i), this.luma() < i ? e : t)
    }, x.prototype.hexStr = function () {
        var t = this.r.toString(16), e = this.g.toString(16), i = this.b.toString(16);
        return 1 == t.length && (t = "0" + t), 1 == e.length && (e = "0" + e), 1 == i.length && (i = "0" + i), "#" + t + e + i
    }, x.prototype.toCssStr = function () {
        var t = this;
        return t.a > 0 ? t.a < 1 ? "rgba(" + t.r + "," + t.g + "," + t.b + "," + t.a + ")" : t.hexStr() : "transparent"
    }, x.isColor = a, x.names = m, x.get = function (t) {
        return new x(t)
    }, t.zui({Color: x})
}(jQuery, Math, window, void 0), function (t) {
    "use strict";
    var e = t && t.zui ? t.zui : this, i = (e.Chart, function (t) {
        this.canvas = t.canvas, this.ctx = t;
        var e = function (t, e) {
            return t["offset" + e] ? t["offset" + e] : document.defaultView.getComputedStyle(t).getPropertyValue(e)
        }, i = this.width = e(t.canvas, "Width"), o = this.height = e(t.canvas, "Height");
        t.canvas.width = i, t.canvas.height = o;
        var i = this.width = t.canvas.width, o = this.height = t.canvas.height;
        return this.aspectRatio = this.width / this.height, n.retinaScale(this), this
    });
    i.defaults = {
        global: {
            animation: !0,
            animationSteps: 60,
            animationEasing: "easeOutQuart",
            showScale: !0,
            scaleOverride: !1,
            scaleSteps: null,
            scaleStepWidth: null,
            scaleStartValue: null,
            scaleLineColor: "rgba(0,0,0,.1)",
            scaleLineWidth: 1,
            scaleShowLabels: !0,
            scaleLabel: "<%=value%>",
            scaleIntegersOnly: !0,
            scaleBeginAtZero: !1,
            scaleFontFamily: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",
            scaleFontSize: 12,
            scaleFontStyle: "normal",
            scaleFontColor: "#666",
            responsive: !1,
            maintainAspectRatio: !0,
            showTooltips: !0,
            customTooltips: !1,
            tooltipEvents: ["mousemove", "touchstart", "touchmove", "mouseout"],
            tooltipFillColor: "rgba(0,0,0,0.8)",
            tooltipFontFamily: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",
            tooltipFontSize: 14,
            tooltipFontStyle: "normal",
            tooltipFontColor: "#fff",
            tooltipTitleFontFamily: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",
            tooltipTitleFontSize: 14,
            tooltipTitleFontStyle: "bold",
            tooltipTitleFontColor: "#fff",
            tooltipYPadding: 6,
            tooltipXPadding: 6,
            tooltipCaretSize: 8,
            tooltipCornerRadius: 6,
            tooltipXOffset: 10,
            tooltipTemplate: "<%if (label){%><%=label%>: <%}%><%= value %>",
            multiTooltipTemplate: "<%if (datasetLabel){%><%=datasetLabel%>: <%}%><%= value %>",
            multiTooltipTitleTemplate: "<%= label %>",
            multiTooltipKeyBackground: "#fff",
            onAnimationProgress: function () {
            },
            onAnimationComplete: function () {
            }
        }
    }, i.types = {};
    var n = i.helpers = {}, o = n.each = function (t, e, i) {
        var n = Array.prototype.slice.call(arguments, 3);
        if (t) if (t.length === +t.length) {
            var o;
            for (o = 0; o < t.length; o++) e.apply(i, [t[o], o].concat(n))
        } else for (var a in t) e.apply(i, [t[a], a].concat(n))
    }, a = n.clone = function (t) {
        var e = {};
        return o(t, function (i, n) {
            t.hasOwnProperty(n) && (e[n] = i)
        }), e
    }, s = n.extend = function (t) {
        return o(Array.prototype.slice.call(arguments, 1), function (e) {
            o(e, function (i, n) {
                e.hasOwnProperty(n) && (t[n] = i)
            })
        }), t
    }, r = n.merge = function (t, e) {
        var i = Array.prototype.slice.call(arguments, 0);
        return i.unshift({}), s.apply(null, i)
    }, l = n.indexOf = function (t, e) {
        if (Array.prototype.indexOf) return t.indexOf(e);
        for (var i = 0; i < t.length; i++) if (t[i] === e) return i;
        return -1
    }, c = (n.where = function (t, e) {
        var i = [];
        return n.each(t, function (t) {
            e(t) && i.push(t)
        }), i
    }, n.findNextWhere = function (t, e, i) {
        i || (i = -1);
        for (var n = i + 1; n < t.length; n++) {
            var o = t[n];
            if (e(o)) return o
        }
    }, n.findPreviousWhere = function (t, e, i) {
        i || (i = t.length);
        for (var n = i - 1; n >= 0; n--) {
            var o = t[n];
            if (e(o)) return o
        }
    }, n.inherits = function (t) {
        var e = this, i = t && t.hasOwnProperty("constructor") ? t.constructor : function () {
            return e.apply(this, arguments)
        }, n = function () {
            this.constructor = i
        };
        return n.prototype = e.prototype, i.prototype = new n, i.extend = c, t && s(i.prototype, t), i.__super__ = e.prototype, i
    }), h = n.noop = function () {
    }, d = n.uid = function () {
        var t = 0;
        return function () {
            return "chart-" + t++
        }
    }(), u = n.warn = function (t) {
        window.console && "function" == typeof window.console.warn && console.warn(t)
    }, p = n.amd = "function" == typeof define && define.amd, f = n.isNumber = function (t) {
        return !isNaN(parseFloat(t)) && isFinite(t)
    }, g = n.max = function (t) {
        return Math.max.apply(Math, t)
    }, m = n.min = function (t) {
        return Math.min.apply(Math, t)
    }, v = (n.cap = function (t, e, i) {
        if (f(e)) {
            if (t > e) return e
        } else if (f(i) && t < i) return i;
        return t
    }, n.getDecimalPlaces = function (t) {
        return t % 1 !== 0 && f(t) ? t.toString().split(".")[1].length : 0
    }), y = n.radians = function (t) {
        return t * (Math.PI / 180)
    }, b = (n.getAngleFromPoint = function (t, e) {
        var i = e.x - t.x, n = e.y - t.y, o = Math.sqrt(i * i + n * n), a = 2 * Math.PI + Math.atan2(n, i);
        return i < 0 && n < 0 && (a += 2 * Math.PI), {angle: a, distance: o}
    }, n.aliasPixel = function (t) {
        return t % 2 === 0 ? 0 : .5
    }), w = (n.splineCurve = function (t, e, i, n) {
        var o = Math.sqrt(Math.pow(e.x - t.x, 2) + Math.pow(e.y - t.y, 2)),
            a = Math.sqrt(Math.pow(i.x - e.x, 2) + Math.pow(i.y - e.y, 2)), s = n * o / (o + a), r = n * a / (o + a);
        return {
            inner: {x: e.x - s * (i.x - t.x), y: e.y - s * (i.y - t.y)},
            outer: {x: e.x + r * (i.x - t.x), y: e.y + r * (i.y - t.y)}
        }
    }, n.calculateOrderOfMagnitude = function (t) {
        return Math.floor(Math.log(t) / Math.LN10)
    }), x = (n.calculateScaleRange = function (t, e, i, n, o) {
        var a = 2, s = Math.floor(e / (1.5 * i)), r = a >= s, l = g(t), c = m(t);
        l === c && (l += .5, c >= .5 && !n ? c -= .5 : l += .5);
        for (var h = Math.abs(l - c), d = w(h), u = Math.ceil(l / (1 * Math.pow(10, d))) * Math.pow(10, d), p = n ? 0 : Math.floor(c / (1 * Math.pow(10, d))) * Math.pow(10, d), f = u - p, v = Math.pow(10, d), y = Math.round(f / v); (y > s || 2 * y < s) && !r;) if (y > s) v *= 2, y = Math.round(f / v), y % 1 !== 0 && (r = !0); else if (o && d >= 0) {
            if (v / 2 % 1 !== 0) break;
            v /= 2, y = Math.round(f / v)
        } else v /= 2, y = Math.round(f / v);
        return r && (y = a, v = f / y), {steps: y, stepValue: v, min: p, max: p + y * v}
    }, n.template = function (t, e) {
        function i(t, e) {
            var i = /\W/.test(t) ? new Function("obj", "var p=[],print=function(){p.push.apply(p,arguments);};with(obj){p.push('" + t.replace(/[\r\t\n]/g, " ").split("<%").join("\t").replace(/((^|%>)[^\t]*)'/g, "$1\r").replace(/\t=(.*?)%>/g, "',$1,'").split("\t").join("');").split("%>").join("p.push('").split("\r").join("\\'") + "');}return p.join('');") : n[t] = n[t];
            return e ? i(e) : i
        }

        if (t instanceof Function) return t(e);
        var n = {};
        return i(t, e)
    }), C = (n.generateLabels = function (t, e, i, n) {
        var a = new Array(e);
        return labelTemplateString && o(a, function (e, o) {
            a[o] = x(t, {value: i + n * (o + 1)})
        }), a
    }, n.easingEffects = {
        linear: function (t) {
            return t
        }, easeInQuad: function (t) {
            return t * t
        }, easeOutQuad: function (t) {
            return -1 * t * (t - 2)
        }, easeInOutQuad: function (t) {
            return (t /= .5) < 1 ? .5 * t * t : -.5 * (--t * (t - 2) - 1)
        }, easeInCubic: function (t) {
            return t * t * t
        }, easeOutCubic: function (t) {
            return 1 * ((t = t / 1 - 1) * t * t + 1)
        }, easeInOutCubic: function (t) {
            return (t /= .5) < 1 ? .5 * t * t * t : .5 * ((t -= 2) * t * t + 2)
        }, easeInQuart: function (t) {
            return t * t * t * t
        }, easeOutQuart: function (t) {
            return -1 * ((t = t / 1 - 1) * t * t * t - 1)
        }, easeInOutQuart: function (t) {
            return (t /= .5) < 1 ? .5 * t * t * t * t : -.5 * ((t -= 2) * t * t * t - 2)
        }, easeInQuint: function (t) {
            return 1 * (t /= 1) * t * t * t * t
        }, easeOutQuint: function (t) {
            return 1 * ((t = t / 1 - 1) * t * t * t * t + 1)
        }, easeInOutQuint: function (t) {
            return (t /= .5) < 1 ? .5 * t * t * t * t * t : .5 * ((t -= 2) * t * t * t * t + 2)
        }, easeInSine: function (t) {
            return -1 * Math.cos(t / 1 * (Math.PI / 2)) + 1
        }, easeOutSine: function (t) {
            return 1 * Math.sin(t / 1 * (Math.PI / 2))
        }, easeInOutSine: function (t) {
            return -.5 * (Math.cos(Math.PI * t / 1) - 1)
        }, easeInExpo: function (t) {
            return 0 === t ? 1 : 1 * Math.pow(2, 10 * (t / 1 - 1))
        }, easeOutExpo: function (t) {
            return 1 === t ? 1 : 1 * (-Math.pow(2, -10 * t / 1) + 1)
        }, easeInOutExpo: function (t) {
            return 0 === t ? 0 : 1 === t ? 1 : (t /= .5) < 1 ? .5 * Math.pow(2, 10 * (t - 1)) : .5 * (-Math.pow(2, -10 * --t) + 2)
        }, easeInCirc: function (t) {
            return t >= 1 ? t : -1 * (Math.sqrt(1 - (t /= 1) * t) - 1)
        }, easeOutCirc: function (t) {
            return 1 * Math.sqrt(1 - (t = t / 1 - 1) * t)
        }, easeInOutCirc: function (t) {
            return (t /= .5) < 1 ? -.5 * (Math.sqrt(1 - t * t) - 1) : .5 * (Math.sqrt(1 - (t -= 2) * t) + 1)
        }, easeInElastic: function (t) {
            var e = 1.70158, i = 0, n = 1;
            return 0 === t ? 0 : 1 == (t /= 1) ? 1 : (i || (i = .3), n < Math.abs(1) ? (n = 1, e = i / 4) : e = i / (2 * Math.PI) * Math.asin(1 / n), -(n * Math.pow(2, 10 * (t -= 1)) * Math.sin((1 * t - e) * (2 * Math.PI) / i)))
        }, easeOutElastic: function (t) {
            var e = 1.70158, i = 0, n = 1;
            return 0 === t ? 0 : 1 == (t /= 1) ? 1 : (i || (i = .3), n < Math.abs(1) ? (n = 1, e = i / 4) : e = i / (2 * Math.PI) * Math.asin(1 / n), n * Math.pow(2, -10 * t) * Math.sin((1 * t - e) * (2 * Math.PI) / i) + 1)
        }, easeInOutElastic: function (t) {
            var e = 1.70158, i = 0, n = 1;
            return 0 === t ? 0 : 2 == (t /= .5) ? 1 : (i || (i = 1 * (.3 * 1.5)), n < Math.abs(1) ? (n = 1, e = i / 4) : e = i / (2 * Math.PI) * Math.asin(1 / n), t < 1 ? -.5 * (n * Math.pow(2, 10 * (t -= 1)) * Math.sin((1 * t - e) * (2 * Math.PI) / i)) : n * Math.pow(2, -10 * (t -= 1)) * Math.sin((1 * t - e) * (2 * Math.PI) / i) * .5 + 1)
        }, easeInBack: function (t) {
            var e = 1.70158;
            return 1 * (t /= 1) * t * ((e + 1) * t - e)
        }, easeOutBack: function (t) {
            var e = 1.70158;
            return 1 * ((t = t / 1 - 1) * t * ((e + 1) * t + e) + 1)
        }, easeInOutBack: function (t) {
            var e = 1.70158;
            return (t /= .5) < 1 ? .5 * (t * t * (((e *= 1.525) + 1) * t - e)) : .5 * ((t -= 2) * t * (((e *= 1.525) + 1) * t + e) + 2)
        }, easeInBounce: function (t) {
            return 1 - C.easeOutBounce(1 - t)
        }, easeOutBounce: function (t) {
            return (t /= 1) < 1 / 2.75 ? 1 * (7.5625 * t * t) : t < 2 / 2.75 ? 1 * (7.5625 * (t -= 1.5 / 2.75) * t + .75) : t < 2.5 / 2.75 ? 1 * (7.5625 * (t -= 2.25 / 2.75) * t + .9375) : 1 * (7.5625 * (t -= 2.625 / 2.75) * t + .984375)
        }, easeInOutBounce: function (t) {
            return t < .5 ? .5 * C.easeInBounce(2 * t) : .5 * C.easeOutBounce(2 * t - 1) + .5
        }
    }), _ = n.requestAnimFrame = function () {
        return window.requestAnimationFrame || window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame || window.oRequestAnimationFrame || window.msRequestAnimationFrame || function (t) {
            return window.setTimeout(t, 1e3 / 60)
        }
    }(), k = n.cancelAnimFrame = function () {
        return window.cancelAnimationFrame || window.webkitCancelAnimationFrame || window.mozCancelAnimationFrame || window.oCancelAnimationFrame || window.msCancelAnimationFrame || function (t) {
            return window.clearTimeout(t, 1e3 / 60)
        }
    }(), T = (n.animationLoop = function (t, e, i, n, o, a) {
        var s = 0, r = C[i] || C.linear, l = function () {
            s++;
            var i = s / e, c = r(i);
            t.call(a, c, i, s), n.call(a, c, i), s < e ? a.animationFrame = _(l) : o.apply(a)
        };
        _(l)
    }, n.getRelativePosition = function (t) {
        var e, i, n = t.originalEvent || t, o = t.currentTarget || t.srcElement, a = o.getBoundingClientRect();
        return n.touches ? (e = n.touches[0].clientX - a.left, i = n.touches[0].clientY - a.top) : (e = n.clientX - a.left, i = n.clientY - a.top), {
            x: e,
            y: i
        }
    }, n.addEvent = function (t, e, i) {
        t.addEventListener ? t.addEventListener(e, i) : t.attachEvent ? t.attachEvent("on" + e, i) : t["on" + e] = i
    }), S = n.removeEvent = function (t, e, i) {
        t.removeEventListener ? t.removeEventListener(e, i, !1) : t.detachEvent ? t.detachEvent("on" + e, i) : t["on" + e] = h
    }, D = (n.bindEvents = function (t, e, i) {
        t.events || (t.events = {}), o(e, function (e) {
            t.events[e] = function () {
                i.apply(t, arguments)
            }, T(t.chart.canvas, e, t.events[e])
        })
    }, n.unbindEvents = function (t, e) {
        o(e, function (e, i) {
            S(t.chart.canvas, i, e)
        })
    }), M = n.getMaximumWidth = function (t) {
        var e = t.parentNode;
        return e.clientWidth
    }, L = n.getMaximumHeight = function (t) {
        var e = t.parentNode;
        return e.clientHeight
    }, z = (n.getMaximumSize = n.getMaximumWidth, n.retinaScale = function (t) {
        var e = t.ctx, i = t.canvas.width, n = t.canvas.height;
        window.devicePixelRatio && (e.canvas.style.width = i + "px", e.canvas.style.height = n + "px", e.canvas.height = n * window.devicePixelRatio, e.canvas.width = i * window.devicePixelRatio, e.scale(window.devicePixelRatio, window.devicePixelRatio))
    }), P = n.clear = function (t) {
        t.ctx.clearRect(0, 0, t.width, t.height)
    }, $ = n.fontString = function (t, e, i) {
        return e + " " + t + "px " + i
    }, I = n.longestText = function (t, e, i) {
        t.font = e;
        var n = 0;
        return o(i, function (e) {
            var i = t.measureText(e).width;
            n = i > n ? i : n
        }), n
    }, F = n.drawRoundedRectangle = function (t, e, i, n, o, a) {
        t.beginPath(), t.moveTo(e + a, i), t.lineTo(e + n - a, i), t.quadraticCurveTo(e + n, i, e + n, i + a), t.lineTo(e + n, i + o - a), t.quadraticCurveTo(e + n, i + o, e + n - a, i + o), t.lineTo(e + a, i + o), t.quadraticCurveTo(e, i + o, e, i + o - a), t.lineTo(e, i + a), t.quadraticCurveTo(e, i, e + a, i), t.closePath()
    };
    i.instances = {}, i.Type = function (t, e, n) {
        this.options = e, this.chart = n, this.id = d(), i.instances[this.id] = this, e.responsive && this.resize(), this.initialize.call(this, t)
    }, s(i.Type.prototype, {
        initialize: function () {
            return this
        }, clear: function () {
            return P(this.chart), this
        }, stop: function () {
            return k(this.animationFrame), this
        }, resize: function (t) {
            this.stop();
            var e = this.chart.canvas, i = M(this.chart.canvas),
                n = this.options.maintainAspectRatio ? i / this.chart.aspectRatio : L(this.chart.canvas);
            return e.width = this.chart.width = i, e.height = this.chart.height = n, z(this.chart), "function" == typeof t && t.apply(this, Array.prototype.slice.call(arguments, 1)), this
        }, reflow: h, render: function (t) {
            return t && this.reflow(), this.options.animation && !t ? n.animationLoop(this.draw, this.options.animationSteps, this.options.animationEasing, this.options.onAnimationProgress, this.options.onAnimationComplete, this) : (this.draw(), this.options.onAnimationComplete.call(this)), this
        }, generateLegend: function () {
            return x(this.options.legendTemplate, this)
        }, destroy: function () {
            this.clear(), D(this, this.events);
            var t = this.chart.canvas;
            t.width = this.chart.width, t.height = this.chart.height, t.style.removeProperty ? (t.style.removeProperty("width"), t.style.removeProperty("height")) : (t.style.removeAttribute("width"), t.style.removeAttribute("height")), delete i.instances[this.id]
        }, showTooltip: function (t, e) {
            "undefined" == typeof this.activeElements && (this.activeElements = []);
            var a = function (t) {
                var e = !1;
                return t.length !== this.activeElements.length ? e = !0 : (o(t, function (t, i) {
                    t !== this.activeElements[i] && (e = !0)
                }, this), e)
            }.call(this, t);
            if (a || e) {
                if (this.activeElements = t, this.draw(), this.options.customTooltips && this.options.customTooltips(!1), t.length > 0) if (this.datasets && this.datasets.length > 1) {
                    for (var s, r, c = this.datasets.length - 1; c >= 0 && (s = this.datasets[c].points || this.datasets[c].bars || this.datasets[c].segments, r = l(s, t[0]), r === -1); c--) ;
                    var h = [], d = [], u = function (t) {
                        var e, i, o, a, s, l = [], c = [], u = [];
                        return n.each(this.datasets, function (t) {
                            t.showTooltips !== !1 && (e = t.points || t.bars || t.segments, e[r] && e[r].hasValue() && l.push(e[r]))
                        }), n.each(l, function (t) {
                            c.push(t.x), u.push(t.y), h.push(n.template(this.options.multiTooltipTemplate, t)), d.push({
                                fill: t._saved.fillColor || t.fillColor,
                                stroke: t._saved.strokeColor || t.strokeColor
                            })
                        }, this), s = m(u), o = g(u), a = m(c), i = g(c), {
                            x: a > this.chart.width / 2 ? a : i,
                            y: (s + o) / 2
                        }
                    }.call(this, r);
                    new i.MultiTooltip({
                        x: u.x,
                        y: u.y,
                        xPadding: this.options.tooltipXPadding,
                        yPadding: this.options.tooltipYPadding,
                        xOffset: this.options.tooltipXOffset,
                        fillColor: this.options.tooltipFillColor,
                        textColor: this.options.tooltipFontColor,
                        fontFamily: this.options.tooltipFontFamily,
                        fontStyle: this.options.tooltipFontStyle,
                        fontSize: this.options.tooltipFontSize,
                        titleTextColor: this.options.tooltipTitleFontColor,
                        titleFontFamily: this.options.tooltipTitleFontFamily,
                        titleFontStyle: this.options.tooltipTitleFontStyle,
                        titleFontSize: this.options.tooltipTitleFontSize,
                        cornerRadius: this.options.tooltipCornerRadius,
                        labels: h,
                        legendColors: d,
                        legendColorBackground: this.options.multiTooltipKeyBackground,
                        title: x(this.options.multiTooltipTitleTemplate, t[0]),
                        chart: this.chart,
                        ctx: this.chart.ctx,
                        custom: this.options.customTooltips
                    }).draw()
                } else o(t, function (t) {
                    var e = t.tooltipPosition();
                    new i.Tooltip({
                        x: Math.round(e.x),
                        y: Math.round(e.y),
                        xPadding: this.options.tooltipXPadding,
                        yPadding: this.options.tooltipYPadding,
                        fillColor: this.options.tooltipFillColor,
                        textColor: this.options.tooltipFontColor,
                        fontFamily: this.options.tooltipFontFamily,
                        fontStyle: this.options.tooltipFontStyle,
                        fontSize: this.options.tooltipFontSize,
                        caretHeight: this.options.tooltipCaretSize,
                        cornerRadius: this.options.tooltipCornerRadius,
                        text: x(this.options.tooltipTemplate, t),
                        chart: this.chart,
                        custom: this.options.customTooltips
                    }).draw()
                }, this);
                return this
            }
        }, toBase64Image: function () {
            return this.chart.canvas.toDataURL.apply(this.chart.canvas, arguments)
        }
    }), i.Type.extend = function (t) {
        var e = this, n = function () {
            return e.apply(this, arguments)
        };
        if (n.prototype = a(e.prototype), s(n.prototype, t), n.extend = i.Type.extend, t.name || e.prototype.name) {
            var o = t.name || e.prototype.name, l = i.defaults[e.prototype.name] ? a(i.defaults[e.prototype.name]) : {};
            i.defaults[o] = s(l, t.defaults), i.types[o] = n, i.prototype[o] = function (t, e) {
                var a = r(i.defaults.global, i.defaults[o], e || {});
                return new n(t, a, this)
            }
        } else u("Name not provided for this chart, so it hasn't been registered");
        return e
    }, i.Element = function (t) {
        s(this, t), this.initialize.apply(this, arguments), this.save()
    }, s(i.Element.prototype, {
        initialize: function () {
        }, restore: function (t) {
            return t ? o(t, function (t) {
                this[t] = this._saved[t]
            }, this) : s(this, this._saved), this
        }, save: function () {
            return this._saved = a(this), delete this._saved._saved, this
        }, update: function (t) {
            return o(t, function (t, e) {
                this._saved[e] = this[e], this[e] = t
            }, this), this
        }, transition: function (t, e) {
            return o(t, function (t, i) {
                this[i] = (t - this._saved[i]) * e + this._saved[i]
            }, this), this
        }, tooltipPosition: function () {
            return {x: this.x, y: this.y}
        }, hasValue: function () {
            return f(this.value)
        }
    }), i.Element.extend = c, i.Point = i.Element.extend({
        display: !0, inRange: function (t, e) {
            var i = this.hitDetectionRadius + this.radius;
            return Math.pow(t - this.x, 2) + Math.pow(e - this.y, 2) < Math.pow(i, 2)
        }, draw: function () {
            if (this.display) {
                var t = this.ctx;
                t.beginPath(), t.arc(this.x, this.y, this.radius, 0, 2 * Math.PI), t.closePath(), t.strokeStyle = this.strokeColor, t.lineWidth = this.strokeWidth, t.fillStyle = this.fillColor, t.fill(), t.stroke()
            }
        }
    }), i.Arc = i.Element.extend({
        inRange: function (t, e) {
            var i = n.getAngleFromPoint(this, {x: t, y: e}), o = i.angle >= this.startAngle && i.angle <= this.endAngle,
                a = i.distance >= this.innerRadius && i.distance <= this.outerRadius;
            return o && a
        }, tooltipPosition: function () {
            var t = this.startAngle + (this.endAngle - this.startAngle) / 2,
                e = (this.outerRadius - this.innerRadius) / 2 + this.innerRadius;
            return {x: this.x + Math.cos(t) * e, y: this.y + Math.sin(t) * e}
        }, draw: function (t) {
            var e = this.ctx;
            if (e.beginPath(), e.arc(this.x, this.y, this.outerRadius, this.startAngle, this.endAngle), e.arc(this.x, this.y, this.innerRadius, this.endAngle, this.startAngle, !0), e.closePath(), e.strokeStyle = this.strokeColor, e.lineWidth = this.strokeWidth, e.fillStyle = this.fillColor, e.fill(), e.lineJoin = "bevel", this.showStroke && e.stroke(), this.circleBeginEnd) {
                var i = (this.outerRadius + this.innerRadius) / 2, n = (this.outerRadius - this.innerRadius) / 2;
                e.beginPath(), e.arc(this.x + Math.cos(this.startAngle) * i, this.y + Math.sin(this.startAngle) * i, n, 0, 2 * Math.PI), e.closePath(), e.fill(), e.beginPath(), e.arc(this.x + Math.cos(this.endAngle) * i, this.y + Math.sin(this.endAngle) * i, n, 0, 2 * Math.PI), e.closePath(), e.fill()
            }
        }
    }), i.Rectangle = i.Element.extend({
        draw: function () {
            var t = this.ctx, e = this.width / 2, i = this.x - e, n = this.x + e, o = this.base - (this.base - this.y),
                a = this.strokeWidth / 2;
            this.showStroke && (i += a, n -= a, o += a), t.beginPath(), t.fillStyle = this.fillColor, t.strokeStyle = this.strokeColor, t.lineWidth = this.strokeWidth, t.moveTo(i, this.base), t.lineTo(i, o), t.lineTo(n, o), t.lineTo(n, this.base), t.fill(), this.showStroke && t.stroke()
        }, height: function () {
            return this.base - this.y
        }, inRange: function (t, e) {
            return t >= this.x - this.width / 2 && t <= this.x + this.width / 2 && e >= this.y && e <= this.base
        }
    }), i.Tooltip = i.Element.extend({
        draw: function () {
            var t = this.chart.ctx;
            t.font = $(this.fontSize, this.fontStyle, this.fontFamily), this.xAlign = "center", this.yAlign = "above";
            var e = this.caretPadding = 2, i = t.measureText(this.text).width + 2 * this.xPadding,
                n = this.fontSize + 2 * this.yPadding, o = n + this.caretHeight + e;
            this.x + i / 2 > this.chart.width ? this.xAlign = "left" : this.x - i / 2 < 0 && (this.xAlign = "right"), this.y - o < 0 && (this.yAlign = "below");
            var a = this.x - i / 2, s = this.y - o;
            if (t.fillStyle = this.fillColor, this.custom) this.custom(this); else {
                switch (this.yAlign) {
                    case"above":
                        t.beginPath(), t.moveTo(this.x, this.y - e), t.lineTo(this.x + this.caretHeight, this.y - (e + this.caretHeight)), t.lineTo(this.x - this.caretHeight, this.y - (e + this.caretHeight)), t.closePath(), t.fill();
                        break;
                    case"below":
                        s = this.y + e + this.caretHeight, t.beginPath(), t.moveTo(this.x, this.y + e), t.lineTo(this.x + this.caretHeight, this.y + e + this.caretHeight), t.lineTo(this.x - this.caretHeight, this.y + e + this.caretHeight), t.closePath(), t.fill()
                }
                switch (this.xAlign) {
                    case"left":
                        a = this.x - i + (this.cornerRadius + this.caretHeight);
                        break;
                    case"right":
                        a = this.x - (this.cornerRadius + this.caretHeight)
                }
                F(t, a, s, i, n, this.cornerRadius), t.fill(), t.fillStyle = this.textColor, t.textAlign = "center", t.textBaseline = "middle", t.fillText(this.text, a + i / 2, s + n / 2)
            }
        }
    }), i.MultiTooltip = i.Element.extend({
        initialize: function () {
            this.font = $(this.fontSize, this.fontStyle, this.fontFamily), this.titleFont = $(this.titleFontSize, this.titleFontStyle, this.titleFontFamily), this.height = this.labels.length * this.fontSize + (this.labels.length - 1) * (this.fontSize / 2) + 2 * this.yPadding + 1.5 * this.titleFontSize, this.ctx.font = this.titleFont;
            var t = this.ctx.measureText(this.title).width, e = I(this.ctx, this.font, this.labels) + this.fontSize + 3,
                i = g([e, t]);
            this.width = i + 2 * this.xPadding;
            var n = this.height / 2;
            this.y - n < 0 ? this.y = n : this.y + n > this.chart.height && (this.y = this.chart.height - n), this.x > this.chart.width / 2 ? this.x -= this.xOffset + this.width : this.x += this.xOffset
        }, getLineHeight: function (t) {
            var e = this.y - this.height / 2 + this.yPadding, i = t - 1;
            return 0 === t ? e + this.titleFontSize / 2 : e + (1.5 * this.fontSize * i + this.fontSize / 2) + 1.5 * this.titleFontSize
        }, draw: function () {
            if (this.custom) this.custom(this); else {
                F(this.ctx, this.x, this.y - this.height / 2, this.width, this.height, this.cornerRadius);
                var t = this.ctx;
                t.fillStyle = this.fillColor, t.fill(), t.closePath(), t.textAlign = "left", t.textBaseline = "middle", t.fillStyle = this.titleTextColor, t.font = this.titleFont, t.fillText(this.title, this.x + this.xPadding, this.getLineHeight(0)), t.font = this.font, n.each(this.labels, function (e, i) {
                    t.fillStyle = this.textColor, t.fillText(e, this.x + this.xPadding + this.fontSize + 3, this.getLineHeight(i + 1)), t.fillStyle = this.legendColorBackground, t.fillRect(this.x + this.xPadding, this.getLineHeight(i + 1) - this.fontSize / 2, this.fontSize, this.fontSize), t.fillStyle = this.legendColors[i].fill, t.fillRect(this.x + this.xPadding, this.getLineHeight(i + 1) - this.fontSize / 2, this.fontSize, this.fontSize)
                }, this)
            }
        }
    }), i.Scale = i.Element.extend({
        initialize: function () {
            this.fit()
        }, buildYLabels: function () {
            this.yLabels = [];
            for (var t = v(this.stepValue), e = 0; e <= this.steps; e++) this.yLabels.push(x(this.templateString, {value: (this.min + e * this.stepValue).toFixed(t)}));
            this.yLabelWidth = this.display && this.showLabels ? I(this.ctx, this.font, this.yLabels) : 0
        }, addXLabel: function (t) {
            this.xLabels.push(t), this.valuesCount++, this.fit()
        }, removeXLabel: function () {
            this.xLabels.shift(), this.valuesCount--, this.fit()
        }, fit: function () {
            this.startPoint = this.display ? this.fontSize : 0, this.endPoint = this.display ? this.height - 1.5 * this.fontSize - 5 : this.height, this.startPoint += this.padding, this.endPoint -= this.padding;
            var t, e = this.endPoint - this.startPoint;
            for (this.calculateYRange(e), this.buildYLabels(), this.calculateXLabelRotation(); e > this.endPoint - this.startPoint;) e = this.endPoint - this.startPoint, t = this.yLabelWidth, this.calculateYRange(e), this.buildYLabels(), t < this.yLabelWidth && this.calculateXLabelRotation()
        }, calculateXLabelRotation: function () {
            this.ctx.font = this.font;
            var t, e, i = this.ctx.measureText(this.xLabels[0]).width,
                n = this.ctx.measureText(this.xLabels[this.xLabels.length - 1]).width;
            if (this.xScalePaddingRight = n / 2 + 3, this.xScalePaddingLeft = i / 2 > this.yLabelWidth + 10 ? i / 2 : this.yLabelWidth + 10, this.xLabelRotation = 0, this.display) {
                var o, a = I(this.ctx, this.font, this.xLabels);
                this.xLabelWidth = a;
                for (var s = Math.floor(this.calculateX(1) - this.calculateX(0)) - 6; this.xLabelWidth > s && 0 === this.xLabelRotation || this.xLabelWidth > s && this.xLabelRotation <= 90 && this.xLabelRotation > 0;) o = Math.cos(y(this.xLabelRotation)), t = o * i, e = o * n, t + this.fontSize / 2 > this.yLabelWidth + 8 && (this.xScalePaddingLeft = t + this.fontSize / 2), this.xScalePaddingRight = this.fontSize / 2, this.xLabelRotation++, this.xLabelWidth = o * a;
                this.xLabelRotation > 0 && (this.endPoint -= Math.sin(y(this.xLabelRotation)) * a + 3)
            } else this.xLabelWidth = 0, this.xScalePaddingRight = this.padding, this.xScalePaddingLeft = this.padding
        }, calculateYRange: h, drawingArea: function () {
            return this.startPoint - this.endPoint
        }, calculateY: function (t) {
            var e = this.drawingArea() / (this.min - this.max);
            return this.endPoint - e * (t - this.min)
        }, calculateX: function (t) {
            var e = (this.xLabelRotation > 0, this.width - (this.xScalePaddingLeft + this.xScalePaddingRight)),
                i = e / Math.max(this.valuesCount - (this.offsetGridLines ? 0 : 1), 1),
                n = i * t + this.xScalePaddingLeft;
            return this.offsetGridLines && (n += i / 2), Math.round(n)
        }, update: function (t) {
            n.extend(this, t), this.fit()
        }, draw: function () {
            var t = this.ctx, e = (this.endPoint - this.startPoint) / this.steps,
                i = Math.round(this.xScalePaddingLeft);
            if (this.display) {
                t.fillStyle = this.textColor, t.font = this.font;
                var a = this.showBeyondLine ? 5 : 0;
                o(this.yLabels, function (o, s) {
                    var r = this.endPoint - e * s, l = Math.round(r), c = this.showHorizontalLines;
                    t.textAlign = "right", t.textBaseline = "middle", this.showLabels && t.fillText(o, i - 10, r), 0 !== s || c || (c = !0), c && t.beginPath(), s > 0 ? (t.lineWidth = this.gridLineWidth, t.strokeStyle = this.gridLineColor) : (t.lineWidth = this.lineWidth, t.strokeStyle = this.lineColor), l += n.aliasPixel(t.lineWidth), c && (t.moveTo(i, l), t.lineTo(this.width, l), t.stroke(), t.closePath()), t.lineWidth = this.lineWidth, t.strokeStyle = this.lineColor, t.beginPath(), t.moveTo(i - a, l), t.lineTo(i, l), t.stroke(), t.closePath()
                }, this), o(this.xLabels, function (e, i) {
                    var n = this.calculateX(i) + b(this.lineWidth),
                        o = this.calculateX(i - (this.offsetGridLines ? .5 : 0)) + b(this.lineWidth),
                        s = this.xLabelRotation > 0, r = this.showVerticalLines;
                    0 !== i || r || (r = !0), r && t.beginPath(), i > 0 ? (t.lineWidth = this.gridLineWidth, t.strokeStyle = this.gridLineColor) : (t.lineWidth = this.lineWidth, t.strokeStyle = this.lineColor), r && (t.moveTo(o, this.endPoint), t.lineTo(o, this.startPoint - 3), t.stroke(), t.closePath()), t.lineWidth = this.lineWidth, t.strokeStyle = this.lineColor, t.beginPath(), t.moveTo(o, this.endPoint), t.lineTo(o, this.endPoint + a), t.stroke(), t.closePath(), t.save(), t.translate(n, s ? this.endPoint + 12 : this.endPoint + 8), t.rotate(y(this.xLabelRotation) * -1), t.font = this.font, t.textAlign = s ? "right" : "center", t.textBaseline = s ? "middle" : "top", t.fillText(e, 0, 0), t.restore()
                }, this)
            }
        }
    }), i.RadialScale = i.Element.extend({
        initialize: function () {
            this.size = m([this.height, this.width]), this.drawingArea = this.display ? this.size / 2 - (this.fontSize / 2 + this.backdropPaddingY) : this.size / 2
        }, calculateCenterOffset: function (t) {
            var e = this.drawingArea / (this.max - this.min);
            return (t - this.min) * e
        }, update: function () {
            this.lineArc ? this.drawingArea = this.display ? this.size / 2 - (this.fontSize / 2 + this.backdropPaddingY) : this.size / 2 : this.setScaleSize(), this.buildYLabels()
        }, buildYLabels: function () {
            this.yLabels = [];
            for (var t = v(this.stepValue), e = 0; e <= this.steps; e++) this.yLabels.push(x(this.templateString, {value: (this.min + e * this.stepValue).toFixed(t)}))
        }, getCircumference: function () {
            return 2 * Math.PI / this.valuesCount
        }, setScaleSize: function () {
            var t, e, i, n, o, a, s, r, l, c, h, d,
                u = m([this.height / 2 - this.pointLabelFontSize - 5, this.width / 2]), p = this.width, g = 0;
            for (this.ctx.font = $(this.pointLabelFontSize, this.pointLabelFontStyle, this.pointLabelFontFamily), e = 0; e < this.valuesCount; e++) t = this.getPointPosition(e, u), i = this.ctx.measureText(x(this.templateString, {value: this.labels[e]})).width + 5, 0 === e || e === this.valuesCount / 2 ? (n = i / 2, t.x + n > p && (p = t.x + n, o = e), t.x - n < g && (g = t.x - n, s = e)) : e < this.valuesCount / 2 ? t.x + i > p && (p = t.x + i, o = e) : e > this.valuesCount / 2 && t.x - i < g && (g = t.x - i, s = e);
            l = g, c = Math.ceil(p - this.width), a = this.getIndexAngle(o), r = this.getIndexAngle(s), h = c / Math.sin(a + Math.PI / 2), d = l / Math.sin(r + Math.PI / 2), h = f(h) ? h : 0, d = f(d) ? d : 0, this.drawingArea = u - (d + h) / 2, this.setCenterPoint(d, h)
        }, setCenterPoint: function (t, e) {
            var i = this.width - e - this.drawingArea, n = t + this.drawingArea;
            this.xCenter = (n + i) / 2, this.yCenter = this.height / 2
        }, getIndexAngle: function (t) {
            var e = 2 * Math.PI / this.valuesCount;
            return t * e - Math.PI / 2
        }, getPointPosition: function (t, e) {
            var i = this.getIndexAngle(t);
            return {x: Math.cos(i) * e + this.xCenter, y: Math.sin(i) * e + this.yCenter}
        }, draw: function () {
            if (this.display) {
                var t = this.ctx;
                if (o(this.yLabels, function (e, i) {
                    if (i > 0) {
                        var n, o = i * (this.drawingArea / this.steps), a = this.yCenter - o;
                        if (this.lineWidth > 0) if (t.strokeStyle = this.lineColor, t.lineWidth = this.lineWidth, this.lineArc) t.beginPath(), t.arc(this.xCenter, this.yCenter, o, 0, 2 * Math.PI), t.closePath(), t.stroke(); else {
                            t.beginPath();
                            for (var s = 0; s < this.valuesCount; s++) n = this.getPointPosition(s, this.calculateCenterOffset(this.min + i * this.stepValue)), 0 === s ? t.moveTo(n.x, n.y) : t.lineTo(n.x, n.y);
                            t.closePath(), t.stroke()
                        }
                        if (this.showLabels) {
                            if (t.font = $(this.fontSize, this.fontStyle, this.fontFamily), this.showLabelBackdrop) {
                                var r = t.measureText(e).width;
                                t.fillStyle = this.backdropColor, t.fillRect(this.xCenter - r / 2 - this.backdropPaddingX, a - this.fontSize / 2 - this.backdropPaddingY, r + 2 * this.backdropPaddingX, this.fontSize + 2 * this.backdropPaddingY)
                            }
                            t.textAlign = "center", t.textBaseline = "middle", t.fillStyle = this.fontColor, t.fillText(e, this.xCenter, a)
                        }
                    }
                }, this), !this.lineArc) {
                    t.lineWidth = this.angleLineWidth, t.strokeStyle = this.angleLineColor;
                    for (var e = this.valuesCount - 1; e >= 0; e--) {
                        if (this.angleLineWidth > 0) {
                            var i = this.getPointPosition(e, this.calculateCenterOffset(this.max));
                            t.beginPath(), t.moveTo(this.xCenter, this.yCenter), t.lineTo(i.x, i.y), t.stroke(), t.closePath()
                        }
                        var n = this.getPointPosition(e, this.calculateCenterOffset(this.max) + 5);
                        t.font = $(this.pointLabelFontSize, this.pointLabelFontStyle, this.pointLabelFontFamily), t.fillStyle = this.pointLabelFontColor;
                        var a = this.labels.length, s = this.labels.length / 2, r = s / 2, l = e < r || e > a - r,
                            c = e === r || e === a - r;
                        0 === e ? t.textAlign = "center" : e === s ? t.textAlign = "center" : e < s ? t.textAlign = "left" : t.textAlign = "right", c ? t.textBaseline = "middle" : l ? t.textBaseline = "bottom" : t.textBaseline = "top", t.fillText(this.labels[e], n.x, n.y)
                    }
                }
            }
        }
    }), n.addEvent(window, "resize", function () {
        var t;
        return function () {
            clearTimeout(t), t = setTimeout(function () {
                o(i.instances, function (t) {
                    t.options.responsive && t.resize(t.render, !0)
                })
            }, 50)
        }
    }()), p ? define(function () {
        return i
    }) : "object" == typeof module && module.exports && (module.exports = i), e.Chart = i, t.fn.chart = function () {
        var t = [];
        return this.each(function () {
            t.push(new i(this.getContext("2d")))
        }), 1 === t.length ? t[0] : t
    }
}.call(this, jQuery), function (t) {
    "use strict";
    var e = t && t.zui ? t.zui : this, i = e.Chart, n = i.helpers, o = {
        scaleShowGridLines: !0,
        scaleGridLineColor: "rgba(0,0,0,.05)",
        scaleGridLineWidth: 1,
        scaleShowHorizontalLines: !0,
        scaleShowBeyondLine: !0,
        scaleShowVerticalLines: !0,
        bezierCurve: !0,
        bezierCurveTension: .4,
        pointDot: !0,
        pointDotRadius: 4,
        pointDotStrokeWidth: 1,
        pointHitDetectionRadius: 20,
        datasetStroke: !0,
        datasetStrokeWidth: 2,
        datasetFill: !0,
        legendTemplate: '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].strokeColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>'
    };
    i.Type.extend({
        name: "Line", defaults: o, initialize: function (e) {
            this.PointClass = i.Point.extend({
                strokeWidth: this.options.pointDotStrokeWidth,
                radius: this.options.pointDotRadius,
                display: this.options.pointDot,
                hitDetectionRadius: Math.min(this.options.pointHitDetectionRadius, Math.max(2, Math.floor(300 / (e.labels.length - 1) / 2))),
                ctx: this.chart.ctx,
                inRange: function (t) {
                    return Math.pow(t - this.x, 2) < Math.pow(this.radius + this.hitDetectionRadius, 2)
                }
            }), this.datasets = [], this.options.showTooltips && n.bindEvents(this, this.options.tooltipEvents, function (t) {
                var e = "mouseout" !== t.type ? this.getPointsAtEvent(t) : [];
                this.eachPoints(function (t) {
                    t.restore(["fillColor", "strokeColor"])
                }), n.each(e, function (t) {
                    t.fillColor = t.highlightFill, t.strokeColor = t.highlightStroke
                }), this.showTooltip(e)
            }), n.each(e.datasets, function (i) {
                if (t.zui && t.zui.Color && t.zui.Color.get) {
                    var o = t.zui.Color.get(i.color), a = o.toCssStr();
                    i.fillColor || (i.fillColor = o.clone().fade(20).toCssStr()), i.strokeColor || (i.strokeColor = a), i.pointColor || (i.pointColor = a), i.pointStrokeColor || (i.pointStrokeColor = "#fff"), i.pointHighlightFill || (i.pointHighlightFill = "#fff"), i.pointHighlightStroke || (i.pointHighlightStroke = a)
                }
                var s = {
                    label: i.label || null,
                    fillColor: i.fillColor,
                    strokeColor: i.strokeColor,
                    pointColor: i.pointColor,
                    pointStrokeColor: i.pointStrokeColor,
                    showTooltips: i.showTooltips !== !1,
                    points: []
                };
                this.datasets.push(s), n.each(i.data, function (t, n) {
                    s.points.push(new this.PointClass({
                        value: t,
                        label: e.labels[n],
                        datasetLabel: i.label,
                        strokeColor: i.pointStrokeColor,
                        fillColor: i.pointColor,
                        highlightFill: i.pointHighlightFill || i.pointColor,
                        highlightStroke: i.pointHighlightStroke || i.pointStrokeColor
                    }))
                }, this), this.buildScale(e.labels), this.eachPoints(function (t, e) {
                    n.extend(t, {x: this.scale.calculateX(e), y: this.scale.endPoint}), t.save()
                }, this)
            }, this), this.render()
        }, update: function () {
            this.scale.update(), n.each(this.activeElements, function (t) {
                t.restore(["fillColor", "strokeColor"])
            }), this.eachPoints(function (t) {
                t.save()
            }), this.render()
        }, eachPoints: function (t) {
            n.each(this.datasets, function (e) {
                n.each(e.points, t, this)
            }, this)
        }, getPointsAtEvent: function (t) {
            var e = [], i = n.getRelativePosition(t);
            return n.each(this.datasets, function (t) {
                n.each(t.points, function (t) {
                    t.inRange(i.x, i.y) && e.push(t)
                })
            }, this), e
        }, buildScale: function (t) {
            var e = this, o = function () {
                var t = [];
                return e.eachPoints(function (e) {
                    t.push(e.value)
                }), t
            }, a = {
                templateString: this.options.scaleLabel,
                height: this.chart.height,
                width: this.chart.width,
                ctx: this.chart.ctx,
                textColor: this.options.scaleFontColor,
                fontSize: this.options.scaleFontSize,
                fontStyle: this.options.scaleFontStyle,
                fontFamily: this.options.scaleFontFamily,
                valuesCount: t.length,
                beginAtZero: this.options.scaleBeginAtZero,
                integersOnly: this.options.scaleIntegersOnly,
                calculateYRange: function (t) {
                    var e = n.calculateScaleRange(o(), t, this.fontSize, this.beginAtZero, this.integersOnly);
                    n.extend(this, e)
                },
                xLabels: t,
                font: n.fontString(this.options.scaleFontSize, this.options.scaleFontStyle, this.options.scaleFontFamily),
                lineWidth: this.options.scaleLineWidth,
                lineColor: this.options.scaleLineColor,
                showHorizontalLines: this.options.scaleShowHorizontalLines,
                showVerticalLines: this.options.scaleShowVerticalLines,
                showBeyondLine: this.options.scaleShowBeyondLine,
                gridLineWidth: this.options.scaleShowGridLines ? this.options.scaleGridLineWidth : 0,
                gridLineColor: this.options.scaleShowGridLines ? this.options.scaleGridLineColor : "rgba(0,0,0,0)",
                padding: this.options.showScale ? 0 : this.options.pointDotRadius + this.options.pointDotStrokeWidth,
                showLabels: this.options.scaleShowLabels,
                display: this.options.showScale
            };
            this.options.scaleOverride && n.extend(a, {
                calculateYRange: n.noop,
                steps: this.options.scaleSteps,
                stepValue: this.options.scaleStepWidth,
                min: this.options.scaleStartValue,
                max: this.options.scaleStartValue + this.options.scaleSteps * this.options.scaleStepWidth
            }), this.scale = new i.Scale(a)
        }, addData: function (t, e) {
            n.each(t, function (t, i) {
                this.datasets[i].points.push(new this.PointClass({
                    value: t,
                    label: e,
                    datasetLabel: this.datasets[i].label,
                    x: this.scale.calculateX(this.scale.valuesCount + 1),
                    y: this.scale.endPoint,
                    strokeColor: this.datasets[i].pointStrokeColor,
                    fillColor: this.datasets[i].pointColor
                }))
            }, this), this.scale.addXLabel(e), this.update()
        }, removeData: function () {
            this.scale.removeXLabel(), n.each(this.datasets, function (t) {
                t.points.shift()
            }, this), this.update()
        }, reflow: function () {
            var t = n.extend({height: this.chart.height, width: this.chart.width});
            this.scale.update(t)
        }, draw: function (t) {
            var e = t || 1;
            this.clear();
            var i = this.chart.ctx, o = function (t) {
                return null !== t.value
            }, a = function (t, e, i) {
                return n.findNextWhere(e, o, i) || t
            }, s = function (t, e, i) {
                return n.findPreviousWhere(e, o, i) || t
            };
            this.scale.draw(e), n.each(this.datasets, function (t) {
                var r = n.where(t.points, o);
                n.each(t.points, function (t, i) {
                    t.hasValue() && t.transition({y: this.scale.calculateY(t.value), x: this.scale.calculateX(i)}, e)
                }, this), this.options.bezierCurve && n.each(r, function (t, e) {
                    var i = e > 0 && e < r.length - 1 ? this.options.bezierCurveTension : 0;
                    t.controlPoints = n.splineCurve(s(t, r, e), t, a(t, r, e), i), t.controlPoints.outer.y > this.scale.endPoint ? t.controlPoints.outer.y = this.scale.endPoint : t.controlPoints.outer.y < this.scale.startPoint && (t.controlPoints.outer.y = this.scale.startPoint), t.controlPoints.inner.y > this.scale.endPoint ? t.controlPoints.inner.y = this.scale.endPoint : t.controlPoints.inner.y < this.scale.startPoint && (t.controlPoints.inner.y = this.scale.startPoint)
                }, this), i.lineWidth = this.options.datasetStrokeWidth, i.strokeStyle = t.strokeColor, i.beginPath(), n.each(r, function (t, e) {
                    if (0 === e) i.moveTo(t.x, t.y); else if (this.options.bezierCurve) {
                        var n = s(t, r, e);
                        i.bezierCurveTo(n.controlPoints.outer.x, n.controlPoints.outer.y, t.controlPoints.inner.x, t.controlPoints.inner.y, t.x, t.y)
                    } else i.lineTo(t.x, t.y)
                }, this), i.stroke(), this.options.datasetFill && r.length > 0 && (i.lineTo(r[r.length - 1].x, this.scale.endPoint), i.lineTo(r[0].x, this.scale.endPoint), i.fillStyle = t.fillColor, i.closePath(), i.fill()), n.each(r, function (t) {
                    t.draw()
                })
            }, this)
        }
    }), t.fn.lineChart = function (e, n) {
        var o = [];
        return this.each(function () {
            var a = t(this);
            o.push(new i(this.getContext("2d")).Line(e, t.extend(a.data(), n)))
        }), 1 === o.length ? o[0] : o
    }
}.call(this, jQuery), function (t) {
    "use strict";
    var e = t && t.zui ? t.zui : this, i = e.Chart, n = i.helpers, o = {
        segmentShowStroke: !0,
        segmentStrokeColor: "#fff",
        segmentStrokeWidth: 1,
        percentageInnerCutout: 50,
        scaleShowLabels: !1,
        scaleLabel: "<%=value%>",
        scaleLabelPlacement: "auto",
        animationSteps: 60,
        animationEasing: "easeOutBounce",
        animateRotate: !0,
        animateScale: !1,
        legendTemplate: '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<segments.length; i++){%><li><span style="background-color:<%=segments[i].fillColor%>"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>'
    };
    i.Type.extend({
        name: "Doughnut", defaults: o, initialize: function (t) {
            this.segments = [], this.outerRadius = (n.min([this.chart.width, this.chart.height]) - this.options.segmentStrokeWidth / 2) / 2, this.SegmentArc = i.Arc.extend({
                ctx: this.chart.ctx,
                x: this.chart.width / 2,
                y: this.chart.height / 2
            }), this.options.showTooltips && n.bindEvents(this, this.options.tooltipEvents, function (t) {
                var e = "mouseout" !== t.type ? this.getSegmentsAtEvent(t) : [];
                n.each(this.segments, function (t) {
                    t.restore(["fillColor"])
                }), n.each(e, function (t) {
                    t.fillColor = t.highlightColor
                }), this.showTooltip(e)
            }), this.calculateTotal(t), n.each(t, function (t, e) {
                this.addData(t, e, !0)
            }, this), this.render()
        }, getSegmentsAtEvent: function (t) {
            var e = [], i = n.getRelativePosition(t);
            return n.each(this.segments, function (t) {
                t.inRange(i.x, i.y) && e.push(t)
            }, this), e
        }, addData: function (e, i, n) {
            if (t.zui && t.zui.Color && t.zui.Color.get) {
                var o = new t.zui.Color.get(e.color);
                e.color = o.toCssStr(), e.highlight || (e.highlight = o.lighten(5).toCssStr())
            }
            var a = i || this.segments.length;
            this.segments.splice(a, 0, new this.SegmentArc({
                id: "undefined" == typeof e.id ? a : e.id,
                value: e.value,
                outerRadius: this.options.animateScale ? 0 : this.outerRadius,
                innerRadius: this.options.animateScale ? 0 : this.outerRadius / 100 * this.options.percentageInnerCutout,
                fillColor: e.color,
                highlightColor: e.highlight || e.color,
                showStroke: this.options.segmentShowStroke,
                strokeWidth: this.options.segmentStrokeWidth,
                strokeColor: this.options.segmentStrokeColor,
                startAngle: 1.5 * Math.PI,
                circumference: this.options.animateRotate ? 0 : this.calculateCircumference(e.value),
                showLabel: e.showLabel !== !1,
                circleBeginEnd: e.circleBeginEnd,
                label: e.label
            })), n || (this.reflow(), this.update())
        }, calculateCircumference: function (t) {
            return 2 * Math.PI * (Math.abs(t) / this.total)
        }, calculateTotal: function (t) {
            this.total = 0, n.each(t, function (t) {
                this.total += Math.abs(t.value)
            }, this)
        }, update: function () {
            this.calculateTotal(this.segments), n.each(this.activeElements, function (t) {
                t.restore(["fillColor"])
            }), n.each(this.segments, function (t) {
                t.save()
            }), this.render()
        }, removeData: function (t) {
            var e = n.isNumber(t) ? t : this.segments.length - 1;
            this.segments.splice(e, 1), this.reflow(), this.update()
        }, reflow: function () {
            n.extend(this.SegmentArc.prototype, {
                x: this.chart.width / 2,
                y: this.chart.height / 2
            }), this.outerRadius = (n.min([this.chart.width, this.chart.height]) - this.options.segmentStrokeWidth / 2) / 2, n.each(this.segments, function (t) {
                t.update({
                    outerRadius: this.outerRadius,
                    innerRadius: this.outerRadius / 100 * this.options.percentageInnerCutout
                })
            }, this)
        }, drawLabel: function (e, i, o) {
            var a = this.options, s = (e.endAngle + e.startAngle) / 2, r = a.scaleLabelPlacement;
            "inside" !== r && "outside" !== r && this.chart.width - this.chart.height > 50 && e.circumference < Math.PI / 18 && (r = "outside");
            var l = Math.cos(s) * e.outerRadius, c = Math.sin(s) * e.outerRadius, h = n.template(a.scaleLabel, {
                value: "undefined" == typeof i ? e.value : Math.round(i * e.value),
                label: e.label
            }), d = this.chart.ctx;
            d.font = n.fontString(a.scaleFontSize, a.scaleFontStyle, a.scaleFontFamily), d.textBaseline = "middle", d.textAlign = "center";
            var u = (d.measureText(h).width, this.chart.width / 2), p = this.chart.height / 2;
            if ("outside" === r) {
                var f = l >= 0, g = l + u, m = c + p;
                d.textAlign = f ? "left" : "right", d.measureText(h).width, l = f ? Math.max(u + e.outerRadius + 10, l + 30 + u) : Math.min(u - e.outerRadius - 10, l - 30 + u);
                var v = a.scaleFontSize * (a.scaleLineHeight || 1), y = Math.round((.8 * c + p) / v) + 1,
                    b = (Math.floor(this.chart.width / v) + 1, f ? 1 : -1);
                if (o[y * b] && (y > 1 ? y-- : y++), o[y * b]) return;
                c = (y - 1) * v + a.scaleFontSize / 2, o[y * b] = !0, d.beginPath(), d.moveTo(g, m), d.lineTo(l, c), l = f ? l + 5 : l - 5, d.lineTo(l, c), d.strokeStyle = t.zui && t.zui.Color ? new t.zui.Color(e.fillColor).fade(40).toCssStr() : e.fillColor, d.strokeWidth = a.scaleLineWidth, d.stroke(), d.fillStyle = e.fillColor
            } else l = .7 * l + u, c = .7 * c + p, d.fillStyle = t.zui && t.zui.Color ? new t.zui.Color(e.fillColor).contrast().toCssStr() : "#fff";
            d.fillText(h, l, c)
        }, draw: function (t) {
            var e = t ? t : 1;
            this.clear();
            var i;
            if (n.each(this.segments, function (t, i) {
                t.transition({
                    circumference: this.calculateCircumference(t.value),
                    outerRadius: this.outerRadius,
                    innerRadius: this.outerRadius / 100 * this.options.percentageInnerCutout
                }, e), t.endAngle = t.startAngle + t.circumference, this.options.reverseDrawOrder || t.draw(), 0 === i && (t.startAngle = 1.5 * Math.PI), i < this.segments.length - 1 && (this.segments[i + 1].startAngle = t.endAngle)
            }, this), this.options.reverseDrawOrder && n.each(this.segments.slice().reverse(), function (t, e) {
                t.draw()
            }, this), this.options.scaleShowLabels) {
                var o = this.segments.slice().sort(function (t, e) {
                    return e.value - t.value
                }), i = {};
                n.each(o, function (e, n) {
                    e.showLabel && this.drawLabel(e, t, i)
                }, this)
            }
        }
    }), i.types.Doughnut.extend({
        name: "Pie",
        defaults: n.merge(o, {percentageInnerCutout: 0})
    }), t.fn.pieChart = function (e, n) {
        var o = [];
        return this.each(function () {
            var a = t(this);
            o.push(new i(this.getContext("2d")).Pie(e, t.extend(a.data(), n)))
        }), 1 === o.length ? o[0] : o
    }, t.fn.doughnutChart = function (e, n) {
        var o = [];
        return this.each(function () {
            var a = t(this);
            o.push(new i(this.getContext("2d")).Doughnut(e, t.extend(a.data(), n)))
        }), 1 === o.length ? o[0] : o
    }
}.call(this, jQuery), function (t) {
    "use strict";
    var e = t && t.zui ? t.zui : this, i = e.Chart, n = i.helpers, o = {
        scaleBeginAtZero: !0,
        scaleShowGridLines: !0,
        scaleGridLineColor: "rgba(0,0,0,.05)",
        scaleGridLineWidth: 1,
        scaleShowHorizontalLines: !0,
        scaleShowVerticalLines: !0,
        scaleShowBeyondLine: !0,
        barShowStroke: !0,
        barStrokeWidth: 1,
        scaleValuePlacement: "auto",
        barValueSpacing: 5,
        barDatasetSpacing: 1,
        legendTemplate: '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>'
    };
    i.Type.extend({
        name: "Bar", defaults: o, initialize: function (e) {
            var o = this.options;
            this.ScaleClass = i.Scale.extend({
                offsetGridLines: !0, calculateBarX: function (t, e, i) {
                    var n = this.calculateBaseWidth(), a = this.calculateX(i) - n / 2, s = this.calculateBarWidth(t);
                    return a + s * e + e * o.barDatasetSpacing + s / 2
                }, calculateBaseWidth: function () {
                    return this.calculateX(1) - this.calculateX(0) - 2 * o.barValueSpacing
                }, calculateBarWidth: function (t) {
                    var e = this.calculateBaseWidth() - (t - 1) * o.barDatasetSpacing;
                    return e / t
                }
            }), this.datasets = [], this.options.showTooltips && n.bindEvents(this, this.options.tooltipEvents, function (t) {
                var e = "mouseout" !== t.type ? this.getBarsAtEvent(t) : [];
                this.eachBars(function (t) {
                    t.restore(["fillColor", "strokeColor"])
                }), n.each(e, function (t) {
                    t.fillColor = t.highlightFill, t.strokeColor = t.highlightStroke
                }), this.showTooltip(e)
            }), this.BarClass = i.Rectangle.extend({
                strokeWidth: this.options.barStrokeWidth,
                showStroke: this.options.barShowStroke,
                ctx: this.chart.ctx
            }), n.each(e.datasets, function (i, o) {
                if (t.zui && t.zui.Color && t.zui.Color.get) {
                    var a = t.zui.Color.get(i.color), s = a.toCssStr();
                    i.fillColor || (i.fillColor = a.clone().fade(50).toCssStr()), i.strokeColor || (i.strokeColor = s)
                }
                var r = {label: i.label || null, fillColor: i.fillColor, strokeColor: i.strokeColor, bars: []};
                this.datasets.push(r), n.each(i.data, function (t, n) {
                    r.bars.push(new this.BarClass({
                        value: t,
                        label: e.labels[n],
                        datasetLabel: i.label,
                        strokeColor: i.strokeColor,
                        fillColor: i.fillColor,
                        highlightFill: i.highlightFill || i.fillColor,
                        highlightStroke: i.highlightStroke || i.strokeColor
                    }))
                }, this)
            }, this), this.buildScale(e.labels), this.BarClass.prototype.base = this.scale.endPoint, this.eachBars(function (t, e, i) {
                n.extend(t, {
                    width: this.scale.calculateBarWidth(this.datasets.length),
                    x: this.scale.calculateBarX(this.datasets.length, i, e),
                    y: this.scale.endPoint
                }), t.save()
            }, this), this.render()
        }, update: function () {
            this.scale.update(), n.each(this.activeElements, function (t) {
                t.restore(["fillColor", "strokeColor"])
            }), this.eachBars(function (t) {
                t.save()
            }), this.render()
        }, eachBars: function (t) {
            n.each(this.datasets, function (e, i) {
                n.each(e.bars, t, this, i)
            }, this)
        }, getBarsAtEvent: function (t) {
            for (var e, i = [], o = n.getRelativePosition(t), a = function (t) {
                i.push(t.bars[e])
            }, s = 0; s < this.datasets.length; s++) for (e = 0; e < this.datasets[s].bars.length; e++) if (this.datasets[s].bars[e].inRange(o.x, o.y)) return n.each(this.datasets, a), i;
            return i
        }, buildScale: function (t) {
            var e = this, i = function () {
                var t = [];
                return e.eachBars(function (e) {
                    t.push(e.value)
                }), t
            }, o = {
                templateString: this.options.scaleLabel,
                height: this.chart.height,
                width: this.chart.width,
                ctx: this.chart.ctx,
                textColor: this.options.scaleFontColor,
                fontSize: this.options.scaleFontSize,
                fontStyle: this.options.scaleFontStyle,
                fontFamily: this.options.scaleFontFamily,
                valuesCount: t.length,
                beginAtZero: this.options.scaleBeginAtZero,
                integersOnly: this.options.scaleIntegersOnly,
                calculateYRange: function (t) {
                    var e = n.calculateScaleRange(i(), t, this.fontSize, this.beginAtZero, this.integersOnly);
                    n.extend(this, e)
                },
                xLabels: t,
                font: n.fontString(this.options.scaleFontSize, this.options.scaleFontStyle, this.options.scaleFontFamily),
                lineWidth: this.options.scaleLineWidth,
                lineColor: this.options.scaleLineColor,
                showHorizontalLines: this.options.scaleShowHorizontalLines,
                showVerticalLines: this.options.scaleShowVerticalLines,
                showBeyondLine: this.options.scaleShowBeyondLine,
                gridLineWidth: this.options.scaleShowGridLines ? this.options.scaleGridLineWidth : 0,
                gridLineColor: this.options.scaleShowGridLines ? this.options.scaleGridLineColor : "rgba(0,0,0,0)",
                padding: this.options.showScale ? 0 : this.options.barShowStroke ? this.options.barStrokeWidth : 0,
                showLabels: this.options.scaleShowLabels,
                display: this.options.showScale
            };
            this.options.scaleOverride && n.extend(o, {
                calculateYRange: n.noop,
                steps: this.options.scaleSteps,
                stepValue: this.options.scaleStepWidth,
                min: this.options.scaleStartValue,
                max: this.options.scaleStartValue + this.options.scaleSteps * this.options.scaleStepWidth
            }), this.scale = new this.ScaleClass(o)
        }, addData: function (t, e) {
            n.each(t, function (t, i) {
                this.datasets[i].bars.push(new this.BarClass({
                    value: t,
                    label: e,
                    x: this.scale.calculateBarX(this.datasets.length, i, this.scale.valuesCount + 1),
                    y: this.scale.endPoint,
                    width: this.scale.calculateBarWidth(this.datasets.length),
                    base: this.scale.endPoint,
                    strokeColor: this.datasets[i].strokeColor,
                    fillColor: this.datasets[i].fillColor
                }))
            }, this), this.scale.addXLabel(e), this.update()
        }, removeData: function () {
            this.scale.removeXLabel(), n.each(this.datasets, function (t) {
                t.bars.shift()
            }, this), this.update()
        }, reflow: function () {
            n.extend(this.BarClass.prototype, {y: this.scale.endPoint, base: this.scale.endPoint});
            var t = n.extend({height: this.chart.height, width: this.chart.width});
            this.scale.update(t)
        }, drawLabel: function (t, e) {
            var i = this.options;
            e = e || i.scaleValuePlacement, e = e ? e.toLowerCase() : "auto", "auto" === e && (e = t.y < 15 ? "insdie" : "outside");
            var o = "insdie" === e ? t.y + 10 : t.y - 10, a = this.chart.ctx;
            a.font = n.fontString(i.scaleFontSize, i.scaleFontStyle, i.scaleFontFamily), a.textBaseline = "middle", a.textAlign = "center", a.fillStyle = i.scaleFontColor, a.fillText(t.value, t.x, o)
        }, draw: function (t) {
            var e = t || 1;
            this.clear();
            this.chart.ctx;
            this.scale.draw(e);
            var i = this.options.scaleShowLabels && this.options.scaleValuePlacement;
            n.each(this.datasets, function (t, o) {
                n.each(t.bars, function (t, n) {
                    t.hasValue() && (t.base = this.scale.endPoint, t.transition({
                        x: this.scale.calculateBarX(this.datasets.length, o, n),
                        y: this.scale.calculateY(t.value),
                        width: this.scale.calculateBarWidth(this.datasets.length)
                    }, e).draw()), i && this.drawLabel(t)
                }, this)
            }, this)
        }
    }), t.fn.barChart = function (e, n) {
        var o = [];
        return this.each(function () {
            var a = t(this);
            o.push(new i(this.getContext("2d")).Bar(e, t.extend(a.data(), n)))
        }), 1 === o.length ? o[0] : o
    }
}.call(this, jQuery), !function (t) {
    function e() {
        return new Date(Date.UTC.apply(Date, arguments))
    }

    var i = function (e, i) {
        var o = this;
        this.element = t(e), this.language = (i.language || this.element.data("date-language") || (t.zui && t.zui.clientLang ? t.zui.clientLang().replace("_", "-") : "zh-cn")).toLowerCase(), this.lang = t.zui && t.zui.getLangData ? t.zui.getLangData("datetimepicker", this.language, n) : n[this.language], this.isRTL = this.lang.rtl || !1, this.formatType = i.formatType || this.element.data("format-type") || "standard", this.format = a.parseFormat(i.format || this.element.data("date-format") || this.lang.format || a.getDefaultFormat(this.formatType, "input"), this.formatType), this.isInline = !1, this.isVisible = !1, this.isInput = this.element.is("input"), this.component = !!this.element.is(".date") && this.element.find(".input-group-addon .icon-th, .input-group-addon .icon-time, .input-group-addon .icon-calendar").parent(), this.componentReset = !!this.element.is(".date") && this.element.find(".input-group-addon .icon-remove").parent(), this.hasInput = this.component && this.element.find("input").length, this.component && 0 === this.component.length && (this.component = !1), this.linkField = i.linkField || this.element.data("link-field") || !1, this.linkFormat = a.parseFormat(i.linkFormat || this.element.data("link-format") || a.getDefaultFormat(this.formatType, "link"), this.formatType), this.minuteStep = i.minuteStep || this.element.data("minute-step") || 5, this.pickerPosition = i.pickerPosition || this.element.data("picker-position") || "bottom-right", this.showMeridian = i.showMeridian || this.element.data("show-meridian") || !1, this.initialDate = i.initialDate || new Date, this.pickerClass = i.eleClass, this.onlyPickTime = i.maxView <= 1, this.pickerId = i.eleId, this._attachEvents(), this.formatViewType = "datetime", "formatViewType" in i ? this.formatViewType = i.formatViewType : "formatViewType" in this.element.data() && (this.formatViewType = this.element.data("formatViewType")), this.minView = 0, "minView" in i ? this.minView = i.minView : "minView" in this.element.data() && (this.minView = this.element.data("min-view")), this.minView = a.convertViewMode(this.minView), this.maxView = a.modes.length - 1, "maxView" in i ? this.maxView = i.maxView : "maxView" in this.element.data() && (this.maxView = this.element.data("max-view")), this.maxView = a.convertViewMode(this.maxView), this.wheelViewModeNavigation = !1, "wheelViewModeNavigation" in i ? this.wheelViewModeNavigation = i.wheelViewModeNavigation : "wheelViewModeNavigation" in this.element.data() && (this.wheelViewModeNavigation = this.element.data("view-mode-wheel-navigation")), this.wheelViewModeNavigationInverseDirection = !1, "wheelViewModeNavigationInverseDirection" in i ? this.wheelViewModeNavigationInverseDirection = i.wheelViewModeNavigationInverseDirection : "wheelViewModeNavigationInverseDirection" in this.element.data() && (this.wheelViewModeNavigationInverseDirection = this.element.data("view-mode-wheel-navigation-inverse-dir")), this.wheelViewModeNavigationDelay = 100, "wheelViewModeNavigationDelay" in i ? this.wheelViewModeNavigationDelay = i.wheelViewModeNavigationDelay : "wheelViewModeNavigationDelay" in this.element.data() && (this.wheelViewModeNavigationDelay = this.element.data("view-mode-wheel-navigation-delay")), this.startViewMode = 2, "startView" in i ? this.startViewMode = i.startView : "startView" in this.element.data() && (this.startViewMode = this.element.data("start-view")), this.startViewMode = a.convertViewMode(this.startViewMode), this.viewMode = this.startViewMode, this.viewSelect = this.minView, "viewSelect" in i ? this.viewSelect = i.viewSelect : "viewSelect" in this.element.data() && (this.viewSelect = this.element.data("view-select")), this.viewSelect = a.convertViewMode(this.viewSelect), this.forceParse = !0, "forceParse" in i ? this.forceParse = i.forceParse : "dateForceParse" in this.element.data() && (this.forceParse = this.element.data("date-force-parse")), this.picker = t(a.template).appendTo(this.isInline ? this.element : "body").on({click: this.click.bind(this)}), this.wheelViewModeNavigation && (t.fn.mousewheel ? this.picker.on({mousewheel: this.mousewheel.bind(this)}) : console.log("Mouse Wheel event is not supported. Please include the jQuery Mouse Wheel plugin before enabling this option")), this.isInline ? this.picker.addClass("datetimepicker-inline") : this.picker.addClass("datetimepicker-dropdown-" + this.pickerPosition + " dropdown-menu"), this.isRTL && (this.picker.addClass("datetimepicker-rtl"), this.picker.find(".prev span, .next span").toggleClass("icon-arrow-left icon-arrow-right")), t(document).on("mousedown", function (e) {
            0 === t(e.target).closest(".datetimepicker").length && o.hide()
        }), this.autoclose = !1, "autoclose" in i ? this.autoclose = i.autoclose : "dateAutoclose" in this.element.data() && (this.autoclose = this.element.data("date-autoclose")), this.keyboardNavigation = !0, "keyboardNavigation" in i ? this.keyboardNavigation = i.keyboardNavigation : "dateKeyboardNavigation" in this.element.data() && (this.keyboardNavigation = this.element.data("date-keyboard-navigation")), this.todayBtn = i.todayBtn || this.element.data("date-today-btn") || !1, this.todayHighlight = i.todayHighlight || this.element.data("date-today-highlight") || !1, this.weekStart = (i.weekStart || this.element.data("date-weekstart") || this.lang.weekStart || 0) % 7, this.weekEnd = (this.weekStart + 6) % 7, this.startDate = -(1 / 0), this.endDate = 1 / 0, this.daysOfWeekDisabled = [], this.setStartDate(i.startDate || this.element.data("date-startdate")), this.setEndDate(i.endDate || this.element.data("date-enddate")), this.setDaysOfWeekDisabled(i.daysOfWeekDisabled || this.element.data("date-days-of-week-disabled")), this.fillDow(), this.fillMonths(), this.update(), this.showMode(), this.isInline && this.show()
    };
    i.prototype = {
        constructor: i, _events: [], _attachEvents: function () {
            this._detachEvents(), this.isInput ? this._events = [[this.element, {
                focus: this.show.bind(this),
                keyup: this.update.bind(this),
                keydown: this.keydown.bind(this)
            }]] : this.component && this.hasInput ? (this._events = [[this.element.find("input"), {
                focus: this.show.bind(this),
                keyup: this.update.bind(this),
                keydown: this.keydown.bind(this)
            }], [this.component, {click: this.show.bind(this)}]], this.componentReset && this._events.push([this.componentReset, {click: this.reset.bind(this)}])) : this.element.is("div") ? this.isInline = !0 : this._events = [[this.element, {click: this.show.bind(this)}]];
            for (var t, e, i = 0; i < this._events.length; i++) t = this._events[i][0], e = this._events[i][1], t.on(e)
        }, _detachEvents: function () {
            for (var t, e, i = 0; i < this._events.length; i++) t = this._events[i][0], e = this._events[i][1], t.off(e);
            this._events = []
        }, show: function (e) {
            this.picker.show(), this.height = this.component ? this.component.outerHeight() : this.element.outerHeight(), this.forceParse && this.update(), this.place(), t(window).on("resize", this.place.bind(this)), e && (e.stopPropagation(), e.preventDefault()), this.isVisible = !0, this.element.trigger({
                type: "show",
                date: this.date
            })
        }, hide: function (e) {
            this.isVisible && (this.isInline || (this.picker.hide(), t(window).off("resize", this.place), this.viewMode = this.startViewMode, this.showMode(), this.isInput || t(document).off("mousedown", this.hide), this.forceParse && (this.isInput && this.element.val() || this.hasInput && this.element.find("input").val()) && this.setValue(), this.isVisible = !1, this.element.trigger({
                type: "hide",
                date: this.date
            })))
        }, remove: function () {
            this._detachEvents(), this.picker.remove(), delete this.picker, delete this.element.data().datetimepicker
        }, getDate: function () {
            var t = this.getUTCDate();
            return new Date(t.getTime() + 6e4 * t.getTimezoneOffset())
        }, getUTCDate: function () {
            return this.date
        }, setDate: function (t) {
            this.setUTCDate(new Date(t.getTime() - 6e4 * t.getTimezoneOffset()))
        }, setUTCDate: function (t) {
            t >= this.startDate && t <= this.endDate ? (this.date = t, this.setValue(), this.viewDate = this.date, this.fill()) : this.element.trigger({
                type: "outOfRange",
                date: t,
                startDate: this.startDate,
                endDate: this.endDate
            })
        }, setFormat: function (t) {
            this.format = a.parseFormat(t, this.formatType);
            var e;
            this.isInput ? e = this.element : this.component && (e = this.element.find("input")), e && e.val() && this.setValue()
        }, setValue: function () {
            var e = this.getFormattedDate();
            this.isInput ? this.element.val(e) : (this.component && this.element.find("input").val(e), this.element.data("date", e)), this.linkField && t("#" + this.linkField).val(this.getFormattedDate(this.linkFormat))
        }, getFormattedDate: function (t) {
            return void 0 == t && (t = this.format), a.formatDate(this.date, t, this.language, this.formatType)
        }, setStartDate: function (t) {
            this.startDate = t || -(1 / 0), this.startDate !== -(1 / 0) && (this.startDate = a.parseDate(this.startDate, this.format, this.language, this.formatType)), this.update(), this.updateNavArrows()
        }, setEndDate: function (t) {
            this.endDate = t || 1 / 0, this.endDate !== 1 / 0 && (this.endDate = a.parseDate(this.endDate, this.format, this.language, this.formatType)), this.update(), this.updateNavArrows()
        }, setDaysOfWeekDisabled: function (e) {
            this.daysOfWeekDisabled = e || [], Array.isArray(this.daysOfWeekDisabled) || (this.daysOfWeekDisabled = this.daysOfWeekDisabled.split(/,\s*/)), this.daysOfWeekDisabled = t.map(this.daysOfWeekDisabled, function (t) {
                return parseInt(t, 10)
            }), this.update(), this.updateNavArrows()
        }, place: function () {
            if (!this.isInline) {
                var e = 0;
                t("div").each(function () {
                    var i = parseInt(t(this).css("zIndex"), 10);
                    i > e && (e = i)
                });
                var i, n, o, a = e + 10;
                this.component ? (i = this.component.offset(), o = i.left, "bottom-left" !== this.pickerPosition && "top-left" !== this.pickerPosition && "auto-left" !== this.pickerPosition || (o += this.component.outerWidth() - this.picker.outerWidth())) : (i = this.element.offset(), o = i.left);
                var s = 0 === this.pickerPosition.indexOf("auto-"),
                    r = s ? (i.top + this.picker.outerHeight() > t(window).height() + t(window).scrollTop() ? "top" : "bottom") + (0 === this.pickerPosition.lastIndexOf("-left") ? "-left" : "-right") : this.pickerPosition;
                n = "top-left" === r || "top-right" === r ? i.top - this.picker.outerHeight() : i.top + this.height, this.picker.css({
                    top: n,
                    left: o,
                    zIndex: a
                }).attr("class", "datetimepicker dropdown-menu datetimepicker-dropdown-" + r), this.pickerClass && this.picker.addClass(this.pickerClass), this.pickerId && this.picker.attr("id", this.pickerId), this.onlyPickTime && this.picker.addClass("datetimepicker-only-time")
            }
        }, update: function () {
            var t, e = !1;
            arguments && arguments.length && ("string" == typeof arguments[0] || arguments[0] instanceof Date) ? (t = arguments[0], e = !0) : (t = this.element.data("date") || (this.isInput ? this.element.val() : this.element.find("input").val()) || this.initialDate, ("string" == typeof t || t instanceof String) && (t = t.replace(/^\s+|\s+$/g, ""))), t || (t = new Date, e = !1), this.date = a.parseDate(t, this.format, this.language, this.formatType), e && this.setValue(), this.date < this.startDate ? this.viewDate = new Date(this.startDate) : this.date > this.endDate ? this.viewDate = new Date(this.endDate) : this.viewDate = new Date(this.date), this.fill()
        }, fillDow: function () {
            for (var t = this.weekStart, e = "<tr>"; t < this.weekStart + 7;) e += '<th class="dow">' + this.lang.daysMin[t++ % 7] + "</th>";
            e += "</tr>", this.picker.find(".datetimepicker-days thead").append(e)
        }, fillMonths: function () {
            for (var t = "", e = 0; e < 12;) t += '<span class="month">' + this.lang.monthsShort[e++] + "</span>";
            this.picker.find(".datetimepicker-months td").html(t)
        }, fill: function () {
            if (null != this.date && null != this.viewDate) {
                var i = new Date(this.viewDate), n = i.getUTCFullYear(), o = i.getUTCMonth(), s = i.getUTCDate(),
                    r = i.getUTCHours(), l = i.getUTCMinutes(),
                    c = this.startDate !== -(1 / 0) ? this.startDate.getUTCFullYear() : -(1 / 0),
                    h = this.startDate !== -(1 / 0) ? this.startDate.getUTCMonth() : -(1 / 0),
                    d = this.endDate !== 1 / 0 ? this.endDate.getUTCFullYear() : 1 / 0,
                    u = this.endDate !== 1 / 0 ? this.endDate.getUTCMonth() : 1 / 0,
                    p = new e(this.date.getUTCFullYear(), this.date.getUTCMonth(), this.date.getUTCDate()).valueOf(),
                    f = new Date;
                if (this.picker.find(".datetimepicker-days thead th:eq(1)").text(this.lang.months[o] + " " + n), "time" == this.formatViewType) {
                    var g = r % 12 ? r % 12 : 12, m = (g < 10 ? "0" : "") + g, v = (l < 10 ? "0" : "") + l,
                        y = this.lang.meridiem[r < 12 ? 0 : 1];
                    this.picker.find(".datetimepicker-hours thead th:eq(1)").text(m + ":" + v + " " + y.toUpperCase()), this.picker.find(".datetimepicker-minutes thead th:eq(1)").text(m + ":" + v + " " + y.toUpperCase())
                } else this.picker.find(".datetimepicker-hours thead th:eq(1)").text(s + " " + this.lang.months[o] + " " + n), this.picker.find(".datetimepicker-minutes thead th:eq(1)").text(s + " " + this.lang.months[o] + " " + n);
                this.picker.find("tfoot th.today").text(this.lang.today).toggle(this.todayBtn !== !1), this.updateNavArrows(), this.fillMonths();
                var b = e(n, o - 1, 28, 0, 0, 0, 0), w = a.getDaysInMonth(b.getUTCFullYear(), b.getUTCMonth());
                b.setUTCDate(w), b.setUTCDate(w - (b.getUTCDay() - this.weekStart + 7) % 7);
                var x = new Date(b);
                x.setUTCDate(x.getUTCDate() + 42), x = x.valueOf();
                for (var C, _ = []; b.valueOf() < x;) b.getUTCDay() == this.weekStart && _.push("<tr>"), C = "", b.getUTCFullYear() < n || b.getUTCFullYear() == n && b.getUTCMonth() < o ? C += " old" : (b.getUTCFullYear() > n || b.getUTCFullYear() == n && b.getUTCMonth() > o) && (C += " new"), this.todayHighlight && b.getUTCFullYear() == f.getFullYear() && b.getUTCMonth() == f.getMonth() && b.getUTCDate() == f.getDate() && (C += " today"), b.valueOf() == p && (C += " active"), (b.valueOf() + 864e5 <= this.startDate || b.valueOf() > this.endDate || t.inArray(b.getUTCDay(), this.daysOfWeekDisabled) !== -1) && (C += " disabled"), _.push('<td class="day' + C + '">' + b.getUTCDate() + "</td>"), b.getUTCDay() == this.weekEnd && _.push("</tr>"), b.setUTCDate(b.getUTCDate() + 1);
                this.picker.find(".datetimepicker-days tbody").empty().append(_.join("")), _ = [];
                for (var k = "", T = "", S = "", D = 0; D < 24; D++) {
                    var M = e(n, o, s, D);
                    C = "", M.valueOf() + 36e5 <= this.startDate || M.valueOf() > this.endDate ? C += " disabled" : r == D && (C += " active"), this.showMeridian && 2 == this.lang.meridiem.length ? (T = D < 12 ? this.lang.meridiem[0] : this.lang.meridiem[1], T != S && ("" != S && _.push("</fieldset>"), _.push('<fieldset class="hour"><legend>' + T.toUpperCase() + "</legend>")), S = T, k = D % 12 ? D % 12 : 12, _.push('<span class="hour' + C + " hour_" + (D < 12 ? "am" : "pm") + '">' + k + "</span>"), 23 == D && _.push("</fieldset>")) : (k = D + ":00", _.push('<span class="hour' + C + '">' + k + "</span>"))
                }
                this.picker.find(".datetimepicker-hours td").html(_.join("")), _ = [], k = "", T = "", S = "";
                for (var D = 0; D < 60; D += this.minuteStep) {
                    var M = e(n, o, s, r, D, 0);
                    C = "", M.valueOf() < this.startDate || M.valueOf() > this.endDate ? C += " disabled" : Math.floor(l / this.minuteStep) == Math.floor(D / this.minuteStep) && (C += " active"), this.showMeridian && 2 == this.lang.meridiem.length ? (T = r < 12 ? this.lang.meridiem[0] : this.lang.meridiem[1], T != S && ("" != S && _.push("</fieldset>"), _.push('<fieldset class="minute"><legend>' + T.toUpperCase() + "</legend>")), S = T, k = r % 12 ? r % 12 : 12, _.push('<span class="minute' + C + '">' + k + ":" + (D < 10 ? "0" + D : D) + "</span>"), 59 == D && _.push("</fieldset>")) : (k = D + ":00", _.push('<span class="minute' + C + '">' + r + ":" + (D < 10 ? "0" + D : D) + "</span>"))
                }
                this.picker.find(".datetimepicker-minutes td").html(_.join(""));
                var L = this.date.getUTCFullYear(),
                    z = this.picker.find(".datetimepicker-months").find("th:eq(1)").text(n).end().find("span").removeClass("active");
                L == n && z.eq(this.date.getUTCMonth()).addClass("active"), (n < c || n > d) && z.addClass("disabled"), n == c && z.slice(0, h).addClass("disabled"), n == d && z.slice(u + 1).addClass("disabled"), _ = "", n = 10 * parseInt(n / 10, 10);
                var P = this.picker.find(".datetimepicker-years").find("th:eq(1)").text(n + "-" + (n + 9)).end().find("td");
                n -= 1;
                for (var D = -1; D < 11; D++) _ += '<span class="year' + (D == -1 || 10 == D ? " old" : "") + (L == n ? " active" : "") + (n < c || n > d ? " disabled" : "") + '">' + n + "</span>", n += 1;
                P.html(_), this.place()
            }
        }, updateNavArrows: function () {
            var t = new Date(this.viewDate), e = t.getUTCFullYear(), i = t.getUTCMonth(), n = t.getUTCDate(),
                o = t.getUTCHours();
            switch (this.viewMode) {
                case 0:
                    this.startDate !== -(1 / 0) && e <= this.startDate.getUTCFullYear() && i <= this.startDate.getUTCMonth() && n <= this.startDate.getUTCDate() && o <= this.startDate.getUTCHours() ? this.picker.find(".prev").css({visibility: "hidden"}) : this.picker.find(".prev").css({visibility: "visible"}), this.endDate !== 1 / 0 && e >= this.endDate.getUTCFullYear() && i >= this.endDate.getUTCMonth() && n >= this.endDate.getUTCDate() && o >= this.endDate.getUTCHours() ? this.picker.find(".next").css({visibility: "hidden"}) : this.picker.find(".next").css({visibility: "visible"});
                    break;
                case 1:
                    this.startDate !== -(1 / 0) && e <= this.startDate.getUTCFullYear() && i <= this.startDate.getUTCMonth() && n <= this.startDate.getUTCDate() ? this.picker.find(".prev").css({visibility: "hidden"}) : this.picker.find(".prev").css({visibility: "visible"}), this.endDate !== 1 / 0 && e >= this.endDate.getUTCFullYear() && i >= this.endDate.getUTCMonth() && n >= this.endDate.getUTCDate() ? this.picker.find(".next").css({visibility: "hidden"}) : this.picker.find(".next").css({visibility: "visible"});
                    break;
                case 2:
                    this.startDate !== -(1 / 0) && e <= this.startDate.getUTCFullYear() && i <= this.startDate.getUTCMonth() ? this.picker.find(".prev").css({visibility: "hidden"}) : this.picker.find(".prev").css({visibility: "visible"}), this.endDate !== 1 / 0 && e >= this.endDate.getUTCFullYear() && i >= this.endDate.getUTCMonth() ? this.picker.find(".next").css({visibility: "hidden"}) : this.picker.find(".next").css({visibility: "visible"});
                    break;
                case 3:
                case 4:
                    this.startDate !== -(1 / 0) && e <= this.startDate.getUTCFullYear() ? this.picker.find(".prev").css({visibility: "hidden"}) : this.picker.find(".prev").css({visibility: "visible"}), this.endDate !== 1 / 0 && e >= this.endDate.getUTCFullYear() ? this.picker.find(".next").css({visibility: "hidden"}) : this.picker.find(".next").css({visibility: "visible"})
            }
        }, mousewheel: function (t) {
            if (t.preventDefault(), t.stopPropagation(), !this.wheelPause) {
                this.wheelPause = !0;
                var e = t.originalEvent, i = e.wheelDelta, n = i > 0 ? 1 : 0 === i ? 0 : -1;
                this.wheelViewModeNavigationInverseDirection && (n = -n), this.showMode(n), setTimeout(function () {
                    this.wheelPause = !1
                }.bind(this), this.wheelViewModeNavigationDelay)
            }
        }, click: function (i) {
            i.stopPropagation(), i.preventDefault();
            var n = t(i.target).closest("span, td, th, legend");
            if (1 == n.length) {
                if (n.is(".disabled")) return void this.element.trigger({
                    type: "outOfRange",
                    date: this.viewDate,
                    startDate: this.startDate,
                    endDate: this.endDate
                });
                switch (n[0].nodeName.toLowerCase()) {
                    case"th":
                        switch (n[0].className) {
                            case"switch":
                                this.showMode(1);
                                break;
                            case"prev":
                            case"next":
                                var o = a.modes[this.viewMode].navStep * ("prev" == n[0].className ? -1 : 1);
                                switch (this.viewMode) {
                                    case 0:
                                        this.viewDate = this.moveHour(this.viewDate, o);
                                        break;
                                    case 1:
                                        this.viewDate = this.moveDate(this.viewDate, o);
                                        break;
                                    case 2:
                                        this.viewDate = this.moveMonth(this.viewDate, o);
                                        break;
                                    case 3:
                                    case 4:
                                        this.viewDate = this.moveYear(this.viewDate, o)
                                }
                                this.fill();
                                break;
                            case"today":
                                var s = new Date;
                                s = e(s.getFullYear(), s.getMonth(), s.getDate(), s.getHours(), s.getMinutes(), s.getSeconds(), 0), s < this.startDate ? s = this.startDate : s > this.endDate && (s = this.endDate), this.viewMode = this.startViewMode, this.showMode(0), this._setDate(s), this.fill(), this.autoclose && this.hide()
                        }
                        break;
                    case"span":
                        if (!n.is(".disabled")) {
                            var r = this.viewDate.getUTCFullYear(), l = this.viewDate.getUTCMonth(),
                                c = this.viewDate.getUTCDate(), h = this.viewDate.getUTCHours(),
                                d = this.viewDate.getUTCMinutes(), u = this.viewDate.getUTCSeconds();
                            if (n.is(".month") ? (this.viewDate.setUTCDate(1), l = n.parent().find("span").index(n), c = this.viewDate.getUTCDate(), this.viewDate.setUTCMonth(l), this.element.trigger({
                                type: "changeMonth",
                                date: this.viewDate
                            }), this.viewSelect >= 3 && this._setDate(e(r, l, c, h, d, u, 0))) : n.is(".year") ? (this.viewDate.setUTCDate(1), r = parseInt(n.text(), 10) || 0, this.viewDate.setUTCFullYear(r), this.element.trigger({
                                type: "changeYear",
                                date: this.viewDate
                            }), this.viewSelect >= 4 && this._setDate(e(r, l, c, h, d, u, 0))) : n.is(".hour") ? (h = parseInt(n.text(), 10) || 0, (n.hasClass("hour_am") || n.hasClass("hour_pm")) && (12 == h && n.hasClass("hour_am") ? h = 0 : 12 != h && n.hasClass("hour_pm") && (h += 12)), this.viewDate.setUTCHours(h), this.element.trigger({
                                type: "changeHour",
                                date: this.viewDate
                            }), this.viewSelect >= 1 && this._setDate(e(r, l, c, h, d, u, 0))) : n.is(".minute") && (d = parseInt(n.text().substr(n.text().indexOf(":") + 1), 10) || 0, this.viewDate.setUTCMinutes(d), this.element.trigger({
                                type: "changeMinute",
                                date: this.viewDate
                            }), this.viewSelect >= 0 && this._setDate(e(r, l, c, h, d, u, 0))), 0 != this.viewMode) {
                                var p = this.viewMode;
                                this.showMode(-1), this.fill(), p == this.viewMode && this.autoclose && this.hide()
                            } else this.fill(), this.autoclose && this.hide()
                        }
                        break;
                    case"td":
                        if (n.is(".day") && !n.is(".disabled")) {
                            var c = parseInt(n.text(), 10) || 1, r = this.viewDate.getUTCFullYear(),
                                l = this.viewDate.getUTCMonth(), h = this.viewDate.getUTCHours(),
                                d = this.viewDate.getUTCMinutes(), u = this.viewDate.getUTCSeconds();
                            n.is(".old") ? 0 === l ? (l = 11, r -= 1) : l -= 1 : n.is(".new") && (11 == l ? (l = 0, r += 1) : l += 1), this.viewDate.setUTCFullYear(r), this.viewDate.setUTCMonth(l, c), this.element.trigger({
                                type: "changeDay",
                                date: this.viewDate
                            }), this.viewSelect >= 2 && this._setDate(e(r, l, c, h, d, u, 0));
                            var p = this.viewMode;
                            this.showMode(-1), this.fill(), p == this.viewMode && this.autoclose && this.hide()
                        }
                }
            }
        }, _setDate: function (t, e) {
            e && "date" != e || (this.date = t), e && "view" != e || (this.viewDate = t), this.fill(), this.setValue();
            var i;
            this.isInput ? i = this.element : this.component && (i = this.element.find("input")), i && (i.change(), this.autoclose && (!e || "date" == e)), this.element.trigger({
                type: "changeDate",
                date: this.date
            }), null === t && (this.date = this.viewDate)
        }, moveMinute: function (t, e) {
            if (!e) return t;
            var i = new Date(t.valueOf());
            return i.setUTCMinutes(i.getUTCMinutes() + e * this.minuteStep), i
        }, moveHour: function (t, e) {
            if (!e) return t;
            var i = new Date(t.valueOf());
            return i.setUTCHours(i.getUTCHours() + e), i
        }, moveDate: function (t, e) {
            if (!e) return t;
            var i = new Date(t.valueOf());
            return i.setUTCDate(i.getUTCDate() + e), i
        }, moveMonth: function (t, e) {
            if (!e) return t;
            var i, n, o = new Date(t.valueOf()), a = o.getUTCDate(), s = o.getUTCMonth(), r = Math.abs(e);
            if (e = e > 0 ? 1 : -1, 1 == r) n = e == -1 ? function () {
                return o.getUTCMonth() == s
            } : function () {
                return o.getUTCMonth() != i
            }, i = s + e, o.setUTCMonth(i), (i < 0 || i > 11) && (i = (i + 12) % 12); else {
                for (var l = 0; l < r; l++) o = this.moveMonth(o, e);
                i = o.getUTCMonth(), o.setUTCDate(a), n = function () {
                    return i != o.getUTCMonth()
                }
            }
            for (; n();) o.setUTCDate(--a), o.setUTCMonth(i);
            return o
        }, moveYear: function (t, e) {
            return this.moveMonth(t, 12 * e)
        }, dateWithinRange: function (t) {
            return t >= this.startDate && t <= this.endDate
        }, keydown: function (t) {
            if (this.picker.is(":not(:visible)")) return void (27 == t.keyCode && this.show());
            var e, i, n, o = !1;
            switch (t.keyCode) {
                case 27:
                    this.hide(), t.preventDefault();
                    break;
                case 37:
                case 39:
                    if (!this.keyboardNavigation) break;
                    e = 37 == t.keyCode ? -1 : 1, viewMode = this.viewMode, t.ctrlKey ? viewMode += 2 : t.shiftKey && (viewMode += 1), 4 == viewMode ? (i = this.moveYear(this.date, e), n = this.moveYear(this.viewDate, e)) : 3 == viewMode ? (i = this.moveMonth(this.date, e), n = this.moveMonth(this.viewDate, e)) : 2 == viewMode ? (i = this.moveDate(this.date, e), n = this.moveDate(this.viewDate, e)) : 1 == viewMode ? (i = this.moveHour(this.date, e), n = this.moveHour(this.viewDate, e)) : 0 == viewMode && (i = this.moveMinute(this.date, e), n = this.moveMinute(this.viewDate, e)), this.dateWithinRange(i) && (this.date = i, this.viewDate = n, this.setValue(), this.update(), t.preventDefault(), o = !0);
                    break;
                case 38:
                case 40:
                    if (!this.keyboardNavigation) break;
                    e = 38 == t.keyCode ? -1 : 1, viewMode = this.viewMode, t.ctrlKey ? viewMode += 2 : t.shiftKey && (viewMode += 1), 4 == viewMode ? (i = this.moveYear(this.date, e), n = this.moveYear(this.viewDate, e)) : 3 == viewMode ? (i = this.moveMonth(this.date, e), n = this.moveMonth(this.viewDate, e)) : 2 == viewMode ? (i = this.moveDate(this.date, 7 * e), n = this.moveDate(this.viewDate, 7 * e)) : 1 == viewMode ? this.showMeridian ? (i = this.moveHour(this.date, 6 * e), n = this.moveHour(this.viewDate, 6 * e)) : (i = this.moveHour(this.date, 4 * e), n = this.moveHour(this.viewDate, 4 * e)) : 0 == viewMode && (i = this.moveMinute(this.date, 4 * e), n = this.moveMinute(this.viewDate, 4 * e)), this.dateWithinRange(i) && (this.date = i, this.viewDate = n, this.setValue(), this.update(), t.preventDefault(), o = !0);
                    break;
                case 13:
                    if (0 != this.viewMode) {
                        var a = this.viewMode;
                        this.showMode(-1), this.fill(), a == this.viewMode && this.autoclose && this.hide()
                    } else this.fill(), this.autoclose && this.hide();
                    t.preventDefault();
                    break;
                case 9:
                    this.hide()
            }
            if (o) {
                var s;
                this.isInput ? s = this.element : this.component && (s = this.element.find("input")), s && s.change(), this.element.trigger({
                    type: "changeDate",
                    date: this.date
                })
            }
        }, showMode: function (t) {
            if (t) {
                var e = Math.max(0, Math.min(a.modes.length - 1, this.viewMode + t));
                e >= this.minView && e <= this.maxView && (this.element.trigger({
                    type: "changeMode",
                    date: this.viewDate,
                    oldViewMode: this.viewMode,
                    newViewMode: e
                }), this.viewMode = e)
            }
            this.picker.find(">div").hide().filter(".datetimepicker-" + a.modes[this.viewMode].clsName).css("display", "block"), this.updateNavArrows()
        }, reset: function (t) {
            this._setDate(null, "date")
        }
    }, t.fn.datetimepicker = function (e) {
        var n = Array.apply(null, arguments);
        return n.shift(), this.each(function () {
            var o = t(this), a = o.data("datetimepicker"), s = "object" == typeof e && e;
            a || o.data("datetimepicker", a = new i(this, t.extend({}, t.fn.datetimepicker.defaults, o.data(), s))), "string" == typeof e && "function" == typeof a[e] && a[e].apply(a, n)
        })
    }, t.fn.datetimepicker.defaults = {pickerPosition: "auto-right"}, t.fn.datetimepicker.Constructor = i;
    var n = t.fn.datetimepicker.dates = {
        en: {
            days: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"],
            daysShort: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
            daysMin: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa", "Su"],
            months: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
            monthsShort: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            meridiem: ["am", "pm"],
            suffix: ["st", "nd", "rd", "th"],
            today: "Today"
        },
        "zh-cn": {
            days: ["星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六", "星期日"],
            daysShort: ["周日", "周一", "周二", "周三", "周四", "周五", "周六", "周日"],
            daysMin: ["日", "一", "二", "三", "四", "五", "六", "日"],
            months: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
            monthsShort: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
            today: "今日",
            suffix: [],
            meridiem: []
        },
        "zh-tw": {
            days: ["星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六", "星期日"],
            daysShort: ["周日", "周一", "周二", "周三", "周四", "周五", "周六", "周日"],
            daysMin: ["日", "一", "二", "三", "四", "五", "六", "日"],
            months: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
            monthsShort: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
            today: "今天",
            suffix: [],
            meridiem: ["上午", "下午"]
        }
    }, o = function (e) {
        var i = n[e];
        return i || (i = t.zui && t.zui.getLangData ? n[e] = t.zui.getLangData("datetimepicker", this.language, n) : n.en), i
    }, a = {
        modes: [{clsName: "minutes", navFnc: "Hours", navStep: 1}, {
            clsName: "hours",
            navFnc: "Date",
            navStep: 1
        }, {clsName: "days", navFnc: "Month", navStep: 1}, {
            clsName: "months",
            navFnc: "FullYear",
            navStep: 1
        }, {clsName: "years", navFnc: "FullYear", navStep: 10}],
        isLeapYear: function (t) {
            return t % 4 === 0 && t % 100 !== 0 || t % 400 === 0
        },
        getDaysInMonth: function (t, e) {
            return [31, a.isLeapYear(t) ? 29 : 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31][e]
        },
        getDefaultFormat: function (t, e) {
            if ("standard" == t) return "input" == e ? "yyyy-mm-dd hh:ii" : "yyyy-mm-dd hh:ii:ss";
            if ("php" == t) return "input" == e ? "Y-m-d H:i" : "Y-m-d H:i:s";
            throw new Error("Invalid format type.")
        },
        validParts: function (t) {
            if ("standard" == t) return /hh?|HH?|p|P|ii?|ss?|dd?|DD?|mm?|MM?|yy(?:yy)?/g;
            if ("php" == t) return /[dDjlNwzFmMnStyYaABgGhHis]/g;
            throw new Error("Invalid format type.")
        },
        nonpunctuation: /[^ -\/:-@\[-`{-~\t\n\rTZ]+/g,
        parseFormat: function (t, e) {
            var i = t.replace(this.validParts(e), "\0").split("\0"), n = t.match(this.validParts(e));
            if (!i || !i.length || !n || 0 == n.length) throw new Error("Invalid date format.");
            return {separators: i, parts: n}
        },
        parseDate: function (n, a, s, r) {
            if (n instanceof Date) {
                var l = new Date(n.valueOf() - 6e4 * n.getTimezoneOffset());
                return l.setMilliseconds(0), l
            }
            if (/^\d{4}\-\d{1,2}\-\d{1,2}$/.test(n) && (a = this.parseFormat("yyyy-mm-dd", r)), /^\d{4}\-\d{1,2}\-\d{1,2}[T ]\d{1,2}\:\d{1,2}$/.test(n) && (a = this.parseFormat("yyyy-mm-dd hh:ii", r)), /^\d{4}\-\d{1,2}\-\d{1,2}[T ]\d{1,2}\:\d{1,2}\:\d{1,2}[Z]{0,1}$/.test(n) && (a = this.parseFormat("yyyy-mm-dd hh:ii:ss", r)), /^[-+]\d+[dmwy]([\s,]+[-+]\d+[dmwy])*$/.test(n)) {
                var c, h, d = /([-+]\d+)([dmwy])/, u = n.match(/([-+]\d+)([dmwy])/g);
                n = new Date;
                for (var p = 0; p < u.length; p++) switch (c = d.exec(u[p]), h = parseInt(c[1]), c[2]) {
                    case"d":
                        n.setUTCDate(n.getUTCDate() + h);
                        break;
                    case"m":
                        n = i.prototype.moveMonth.call(i.prototype, n, h);
                        break;
                    case"w":
                        n.setUTCDate(n.getUTCDate() + 7 * h);
                        break;
                    case"y":
                        n = i.prototype.moveYear.call(i.prototype, n, h)
                }
                return e(n.getUTCFullYear(), n.getUTCMonth(), n.getUTCDate(), n.getUTCHours(), n.getUTCMinutes(), n.getUTCSeconds(), 0)
            }
            var f, g, c, u = n && n.match(this.nonpunctuation) || [], n = new Date(0, 0, 0, 0, 0, 0, 0), m = {},
                v = ["hh", "h", "ii", "i", "ss", "s", "yyyy", "yy", "M", "MM", "m", "mm", "D", "DD", "d", "dd", "H", "HH", "p", "P"],
                y = {
                    hh: function (t, e) {
                        return t.setUTCHours(e)
                    }, h: function (t, e) {
                        return t.setUTCHours(e)
                    }, HH: function (t, e) {
                        return t.setUTCHours(12 == e ? 0 : e)
                    }, H: function (t, e) {
                        return t.setUTCHours(12 == e ? 0 : e)
                    }, ii: function (t, e) {
                        return t.setUTCMinutes(e)
                    }, i: function (t, e) {
                        return t.setUTCMinutes(e)
                    }, ss: function (t, e) {
                        return t.setUTCSeconds(e)
                    }, s: function (t, e) {
                        return t.setUTCSeconds(e)
                    }, yyyy: function (t, e) {
                        return t.setUTCFullYear(e)
                    }, yy: function (t, e) {
                        return t.setUTCFullYear(2e3 + e)
                    }, m: function (t, e) {
                        for (e -= 1; e < 0;) e += 12;
                        for (e %= 12, t.setUTCMonth(e); t.getUTCMonth() != e;) t.setUTCDate(t.getUTCDate() - 1);
                        return t
                    }, d: function (t, e) {
                        return t.setUTCDate(e)
                    }, p: function (t, e) {
                        return t.setUTCHours(1 == e ? t.getUTCHours() + 12 : t.getUTCHours())
                    }
                };
            if (y.M = y.MM = y.mm = y.m, y.dd = y.d, y.P = y.p, n = e(n.getFullYear(), n.getMonth(), n.getDate(), n.getHours(), n.getMinutes(), n.getSeconds()), u.length == a.parts.length) {
                for (var p = 0, b = a.parts.length; p < b; p++) {
                    if (f = parseInt(u[p], 10), c = a.parts[p], isNaN(f)) switch (c) {
                        case"MM":
                            g = t(o(s).months).filter(function () {
                                var t = this.slice(0, u[p].length), e = u[p].slice(0, t.length);
                                return t == e
                            }), f = t.inArray(g[0], o(s).months) + 1;
                            break;
                        case"M":
                            g = t(o(s).monthsShort).filter(function () {
                                var t = this.slice(0, u[p].length), e = u[p].slice(0, t.length);
                                return t == e
                            }), f = t.inArray(g[0], o(s).monthsShort) + 1;
                            break;
                        case"p":
                        case"P":
                            f = t.inArray(u[p].toLowerCase(), o(s).meridiem)
                    }
                    m[c] = f
                }
                for (var w, p = 0; p < v.length; p++) w = v[p], w in m && !isNaN(m[w]) && y[w](n, m[w])
            }
            return n
        },
        formatDate: function (e, i, n, s) {
            if (null == e) return "";
            var r;
            if ("standard" == s) r = {
                yy: e.getUTCFullYear().toString().substring(2),
                yyyy: e.getUTCFullYear(),
                m: e.getUTCMonth() + 1,
                M: o(n).monthsShort[e.getUTCMonth()],
                MM: o(n).months[e.getUTCMonth()],
                d: e.getUTCDate(),
                D: o(n).daysShort[e.getUTCDay()],
                DD: o(n).days[e.getUTCDay()],
                p: 2 == o(n).meridiem.length ? o(n).meridiem[e.getUTCHours() < 12 ? 0 : 1] : "",
                h: e.getUTCHours(),
                i: e.getUTCMinutes(),
                s: e.getUTCSeconds()
            }, 2 == o(n).meridiem.length ? r.H = r.h % 12 == 0 ? 12 : r.h % 12 : r.H = r.h, r.HH = (r.H < 10 ? "0" : "") + r.H, r.P = r.p.toUpperCase(), r.hh = (r.h < 10 ? "0" : "") + r.h, r.ii = (r.i < 10 ? "0" : "") + r.i, r.ss = (r.s < 10 ? "0" : "") + r.s, r.dd = (r.d < 10 ? "0" : "") + r.d, r.mm = (r.m < 10 ? "0" : "") + r.m; else {
                if ("php" != s) throw new Error("Invalid format type.");
                r = {
                    y: e.getUTCFullYear().toString().substring(2),
                    Y: e.getUTCFullYear(),
                    F: o(n).months[e.getUTCMonth()],
                    M: o(n).monthsShort[e.getUTCMonth()],
                    n: e.getUTCMonth() + 1,
                    t: a.getDaysInMonth(e.getUTCFullYear(), e.getUTCMonth()),
                    j: e.getUTCDate(),
                    l: o(n).days[e.getUTCDay()],
                    D: o(n).daysShort[e.getUTCDay()],
                    w: e.getUTCDay(),
                    N: 0 == e.getUTCDay() ? 7 : e.getUTCDay(),
                    S: e.getUTCDate() % 10 <= o(n).suffix.length ? o(n).suffix[e.getUTCDate() % 10 - 1] : "",
                    a: 2 == o(n).meridiem.length ? o(n).meridiem[e.getUTCHours() < 12 ? 0 : 1] : "",
                    g: e.getUTCHours() % 12 == 0 ? 12 : e.getUTCHours() % 12,
                    G: e.getUTCHours(),
                    i: e.getUTCMinutes(),
                    s: e.getUTCSeconds()
                }, r.m = (r.n < 10 ? "0" : "") + r.n, r.d = (r.j < 10 ? "0" : "") + r.j, r.A = r.a.toString().toUpperCase(), r.h = (r.g < 10 ? "0" : "") + r.g, r.H = (r.G < 10 ? "0" : "") + r.G, r.i = (r.i < 10 ? "0" : "") + r.i, r.s = (r.s < 10 ? "0" : "") + r.s
            }
            for (var e = [], l = t.extend([], i.separators), c = 0, h = i.parts.length; c < h; c++) l.length && e.push(l.shift()), e.push(r[i.parts[c]]);
            return l.length && e.push(l.shift()), e.join("")
        },
        convertViewMode: function (t) {
            switch (t) {
                case 4:
                case"decade":
                    t = 4;
                    break;
                case 3:
                case"year":
                    t = 3;
                    break;
                case 2:
                case"month":
                    t = 2;
                    break;
                case 1:
                case"day":
                    t = 1;
                    break;
                case 0:
                case"hour":
                    t = 0
            }
            return t
        },
        headTemplate: '<thead><tr><th class="prev"><i class="icon-arrow-left"/></th><th colspan="5" class="switch"></th><th class="next"><i class="icon-arrow-right"/></th></tr></thead>',
        contTemplate: '<tbody><tr><td colspan="7"></td></tr></tbody>',
        footTemplate: '<tfoot><tr><th colspan="7" class="today"></th></tr></tfoot>'
    };
    a.template = '<div class="datetimepicker"><div class="datetimepicker-minutes"><table class=" table-condensed">' + a.headTemplate + a.contTemplate + a.footTemplate + '</table></div><div class="datetimepicker-hours"><table class=" table-condensed">' + a.headTemplate + a.contTemplate + a.footTemplate + '</table></div><div class="datetimepicker-days"><table class=" table-condensed">' + a.headTemplate + "<tbody></tbody>" + a.footTemplate + '</table></div><div class="datetimepicker-months"><table class="table-condensed">' + a.headTemplate + a.contTemplate + a.footTemplate + '</table></div><div class="datetimepicker-years"><table class="table-condensed">' + a.headTemplate + a.contTemplate + a.footTemplate + "</table></div></div>", t.fn.datetimepicker.DPGlobal = a, t.fn.datetimepicker.noConflict = function () {
        return t.fn.datetimepicker = old, this
    }, t(document).on("focus.datetimepicker.data-api click.datetimepicker.data-api", '[data-provide="datetimepicker"]', function (e) {
        var i = t(this);
        i.data("datetimepicker") || (e.preventDefault(), i.datetimepicker("show"))
    }), t(function () {
        t('[data-provide="datetimepicker-inline"]').datetimepicker()
    })
}(window.jQuery), function (t, e) {
    "use strict";
    "function" == typeof define && define.amd ? define(["jquery"], e) : "object" == typeof exports ? module.exports = e(require("jquery")) : t.bootbox = e(t.jQuery)
}(this, function t(e, i) {
    "use strict";

    function n(t) {
        var i = e.zui && e.zui.getLangData ? e.zui.getLangData("bootbox", f.locale, m) : m[f.locale];
        return i ? i[t] : m.en[t]
    }

    function o(t, e, i) {
        t.stopPropagation(), t.preventDefault();
        var n = "function" == typeof i && i.call(e, t) === !1;
        n || e.modal("hide")
    }

    function a(t) {
        var e, i = 0;
        for (e in t) i++;
        return i
    }

    function s(t, i) {
        var n = 0;
        e.each(t, function (t, e) {
            i(t, e, n++)
        })
    }

    function r(t) {
        var i, n;
        if ("object" != typeof t) throw new Error("Please supply an object of options");
        if (!t.message) throw new Error("Please specify a message");
        return t = e.extend({}, f, t), t.buttons || (t.buttons = {}), i = t.buttons, n = a(i), s(i, function (t, o, a) {
            if ("function" == typeof o && (o = i[t] = {callback: o}), "object" !== e.type(o)) throw new Error("button with key " + t + " must be an object");
            o.label || (o.label = t), o.className || (2 === n && ("ok" === t || "confirm" === t) || 1 === n ? o.className = "btn-primary" : o.className = "btn-default")
        }), t
    }

    function l(t, e) {
        var i = t.length, n = {};
        if (i < 1 || i > 2) throw new Error("Invalid argument length");
        return 2 === i || "string" == typeof t[0] ? (n[e[0]] = t[0], n[e[1]] = t[1]) : n = t[0], n
    }

    function c(t, i, n) {
        return e.extend(!0, {}, t, l(i, n))
    }

    function h(t, e, i, n) {
        var o = {className: "bootbox-" + t, buttons: d.apply(null, e)};
        return u(c(o, n, i), e)
    }

    function d() {
        for (var t = {}, e = 0, i = arguments.length; e < i; e++) {
            var o = arguments[e], a = o.toLowerCase(), s = o.toUpperCase();
            t[a] = {label: n(s)}
        }
        return t
    }

    function u(t, e) {
        var n = {};
        return s(e, function (t, e) {
            n[e] = !0
        }), s(t.buttons, function (t) {
            if (n[t] === i) throw new Error("button key " + t + " is not allowed (options are " + e.join("\n") + ")")
        }), t
    }

    var p = {
        dialog: "<div class='bootbox modal' tabindex='-1' role='dialog'><div class='modal-dialog'><div class='modal-content'><div class='modal-body'><div class='bootbox-body'></div></div></div></div></div>",
        header: "<div class='modal-header'><h4 class='modal-title'></h4></div>",
        footer: "<div class='modal-footer'></div>",
        closeButton: "<button type='button' class='bootbox-close-button close' data-dismiss='modal' aria-hidden='true'>&times;</button>",
        form: "<form class='bootbox-form'></form>",
        inputs: {
            text: "<input class='bootbox-input bootbox-input-text form-control' autocomplete=off type=text />",
            textarea: "<textarea class='bootbox-input bootbox-input-textarea form-control'></textarea>",
            email: "<input class='bootbox-input bootbox-input-email form-control' autocomplete='off' type='email' />",
            select: "<select class='bootbox-input bootbox-input-select form-control'></select>",
            checkbox: "<div class='checkbox'><label><input class='bootbox-input bootbox-input-checkbox' type='checkbox' /></label></div>",
            date: "<input class='bootbox-input bootbox-input-date form-control' autocomplete=off type='date' />",
            time: "<input class='bootbox-input bootbox-input-time form-control' autocomplete=off type='time' />",
            number: "<input class='bootbox-input bootbox-input-number form-control' autocomplete=off type='number' />",
            password: "<input class='bootbox-input bootbox-input-password form-control' autocomplete='off' type='password' />"
        }
    }, f = {
        locale: e.zui && e.zui.clientLang ? e.zui.clientLang() : "en",
        backdrop: "static",
        animate: !0,
        className: null,
        closeButton: !0,
        show: !0,
        container: "body"
    }, g = {};
    g.alert = function () {
        var t;
        if (t = h("alert", ["ok"], ["message", "callback"], arguments), t.callback && "function" != typeof t.callback) throw new Error("alert requires callback property to be a function when provided");
        return t.buttons.ok.callback = t.onEscape = function () {
            return "function" != typeof t.callback || t.callback.call(this)
        }, g.dialog(t)
    }, g.confirm = function () {
        var t;
        if (t = h("confirm", ["confirm", "cancel"], ["message", "callback"], arguments), t.buttons.cancel.callback = t.onEscape = function () {
            return t.callback.call(this, !1)
        }, t.buttons.confirm.callback = function () {
            return t.callback.call(this, !0)
        }, "function" != typeof t.callback) throw new Error("confirm requires a callback");
        return g.dialog(t)
    }, g.prompt = function () {
        var t, n, o, a, r, l, h;
        if (a = e(p.form), n = {
            className: "bootbox-prompt",
            buttons: d("cancel", "confirm"),
            value: "",
            inputType: "text"
        }, t = u(c(n, arguments, ["title", "callback"]), ["confirm", "cancel"]), l = t.show === i || t.show, t.message = a, t.buttons.cancel.callback = t.onEscape = function () {
            return t.callback.call(this, null)
        }, t.buttons.confirm.callback = function () {
            var i;
            switch (t.inputType) {
                case"text":
                case"textarea":
                case"email":
                case"select":
                case"date":
                case"time":
                case"number":
                case"password":
                    i = r.val();
                    break;
                case"checkbox":
                    var n = r.find("input:checked");
                    i = [], s(n, function (t, n) {
                        i.push(e(n).val())
                    })
            }
            return t.callback.call(this, i)
        }, t.show = !1, !t.title) throw new Error("prompt requires a title");
        if ("function" != typeof t.callback) throw new Error("prompt requires a callback");
        if (!p.inputs[t.inputType]) throw new Error("invalid prompt type");
        switch (r = e(p.inputs[t.inputType]), t.inputType) {
            case"text":
            case"textarea":
            case"email":
            case"date":
            case"time":
            case"number":
            case"password":
                r.val(t.value);
                break;
            case"select":
                var f = {};
                if (h = t.inputOptions || [], !Array.isArray(h)) throw new Error("Please pass an array of input options");
                if (!h.length) throw new Error("prompt with select requires options");
                s(h, function (t, n) {
                    var o = r;
                    if (n.value === i || n.text === i) throw new Error("given options in wrong format");
                    n.group && (f[n.group] || (f[n.group] = e("<optgroup/>").attr("label", n.group)), o = f[n.group]), o.append("<option value='" + n.value + "'>" + n.text + "</option>")
                }), s(f, function (t, e) {
                    r.append(e)
                }), r.val(t.value);
                break;
            case"checkbox":
                var m = Array.isArray(t.value) ? t.value : [t.value];
                if (h = t.inputOptions || [], !h.length) throw new Error("prompt with checkbox requires options");
                if (!h[0].value || !h[0].text) throw new Error("given options in wrong format");
                r = e("<div/>"), s(h, function (i, n) {
                    var o = e(p.inputs[t.inputType]);
                    o.find("input").attr("value", n.value), o.find("label").append(n.text), s(m, function (t, e) {
                        e === n.value && o.find("input").prop("checked", !0)
                    }), r.append(o)
                })
        }
        return t.placeholder && r.attr("placeholder", t.placeholder), t.pattern && r.attr("pattern", t.pattern), t.maxlength && r.attr("maxlength", t.maxlength), a.append(r), a.on("submit", function (t) {
            t.preventDefault(), t.stopPropagation(), o.find(".btn-primary").click()
        }), o = g.dialog(t), o.off("shown.zui.modal"), o.on("shown.zui.modal", function () {
            r.focus()
        }), l === !0 && o.modal("show"), o
    }, g.dialog = function (t) {
        t = r(t);
        var n = e(p.dialog), a = n.find(".modal-dialog"), l = n.find(".modal-body"), c = t.buttons, h = "",
            d = {onEscape: t.onEscape};
        if (e.fn.modal === i) throw new Error("$.fn.modal is not defined; please double check you have included the Bootstrap JavaScript library. See http://getbootstrap.com/javascript/ for more details.");
        if (s(c, function (t, e) {
            h += "<button data-bb-handler='" + t + "' type='button' class='btn " + e.className + "'>" + e.label + "</button>", d[t] = e.callback
        }), l.find(".bootbox-body").html(t.message), t.animate === !0 && n.addClass("fade"), t.className && n.addClass(t.className), "large" === t.size ? a.addClass("modal-lg") : "small" === t.size && a.addClass("modal-sm"), t.title && l.before(p.header), t.closeButton) {
            var u = e(p.closeButton);
            t.title ? n.find(".modal-header").prepend(u) : u.css("margin-top", "-10px").prependTo(l)
        }
        return t.title && n.find(".modal-title").html(t.title), h.length && (l.after(p.footer), n.find(".modal-footer").html(h)), n.on("hidden.zui.modal", function (t) {
            t.target === this && n.remove()
        }), n.on("shown.zui.modal", function () {
            n.find(".btn-primary:first").focus()
        }), "static" !== t.backdrop && n.on("click.dismiss.zui.modal", function (t) {
            n.children(".modal-backdrop").length && (t.currentTarget = n.children(".modal-backdrop").get(0)), t.target === t.currentTarget && n.trigger("escape.close.bb")
        }), n.on("escape.close.bb", function (t) {
            d.onEscape && o(t, n, d.onEscape)
        }), n.on("click", ".modal-footer button", function (t) {
            var i = e(this).data("bb-handler");
            o(t, n, d[i])
        }), n.on("click", ".bootbox-close-button", function (t) {
            o(t, n, d.onEscape)
        }), n.on("keyup", function (t) {
            27 === t.which && n.trigger("escape.close.bb")
        }), e(t.container).append(n), n.modal({
            backdrop: !!t.backdrop && "static",
            keyboard: !1,
            show: !1
        }), t.show && n.modal("show"), n
    }, g.setDefaults = function () {
        var t = {};
        2 === arguments.length ? t[arguments[0]] = arguments[1] : t = arguments[0], e.extend(f, t)
    }, g.hideAll = function () {
        return e(".bootbox").modal("hide"), g
    };
    var m = {
        en: {OK: "OK", CANCEL: "Cancel", CONFIRM: "Confirm"},
        zh_cn: {OK: "确认", CANCEL: "取消", CONFIRM: "确认"},
        zh_tw: {OK: "確認", CANCEL: "取消", CONFIRM: "確認"}
    };
    return g.addLocale = function (t, i) {
        return e.each(["OK", "CANCEL", "CONFIRM"], function (t, e) {
            if (!i[e]) throw new Error("Please supply a translation for '" + e + "'")
        }), m[t] = {OK: i.OK, CANCEL: i.CANCEL, CONFIRM: i.CONFIRM}, g
    }, g.removeLocale = function (t) {
        return delete m[t], g
    }, g.setLocale = function (t) {
        return g.setDefaults("locale", t)
    }, g.init = function (i) {
        return t(i || e)
    }, g
}), function () {
    var t, e, i, n, o, a = {}.hasOwnProperty, s = function (t, e) {
        function i() {
            this.constructor = t
        }

        for (var n in e) a.call(e, n) && (t[n] = e[n]);
        return i.prototype = e.prototype, t.prototype = new i, t.__super__ = e.prototype, t
    }, r = {
        zh_cn: {no_results_text: "没有找到"},
        zh_tw: {no_results_text: "沒有找到"},
        en: {no_results_text: "No results match"}
    }, l = {};
    n = function () {
        function e() {
            this.options_index = 0, this.parsed = []
        }

        return e.prototype.add_node = function (t) {
            return "OPTGROUP" === t.nodeName.toUpperCase() ? this.add_group(t) : this.add_option(t)
        }, e.prototype.add_group = function (e) {
            var i, n, o, a, s, r;
            for (i = this.parsed.length, this.parsed.push({
                array_index: i,
                group: !0,
                label: this.escapeExpression(e.label),
                children: 0,
                disabled: e.disabled,
                title: e.title,
                search_keys: t.trim(e.getAttribute("data-keys") || "").replace(/,/g, " ")
            }), s = e.childNodes, r = [], o = 0, a = s.length; o < a; o++) n = s[o], r.push(this.add_option(n, i, e.disabled));
            return r
        }, e.prototype.add_option = function (e, i, n) {
            if ("OPTION" === e.nodeName.toUpperCase()) return "" !== e.text ? (null != i && (this.parsed[i].children += 1), this.parsed.push({
                array_index: this.parsed.length,
                options_index: this.options_index,
                value: e.value,
                text: e.text,
                title: e.title,
                html: e.innerHTML,
                selected: e.selected,
                disabled: n === !0 ? n : e.disabled,
                group_array_index: i,
                classes: e.className,
                style: e.style.cssText,
                data: e.getAttribute("data-data"),
                search_keys: (t.trim(e.getAttribute("data-keys") || "") + e.value).replace(/,/, " ")
            })) : this.parsed.push({
                array_index: this.parsed.length,
                options_index: this.options_index,
                empty: !0
            }), this.options_index += 1
        }, e.prototype.escapeExpression = function (t) {
            var e, i;
            return null == t || t === !1 ? "" : /[\&\<\>\"\'\`]/.test(t) ? (e = {
                "<": "&lt;",
                ">": "&gt;",
                '"': "&quot;",
                "'": "&#x27;",
                "`": "&#x60;"
            }, i = /&(?!\w+;)|[\<\>\"\'\`]/g, t.replace(i, function (t) {
                return e[t] || "&amp;"
            })) : t
        }, e
    }(), n.select_to_array = function (t) {
        var e, i, o, a, s;
        for (i = new n, s = t.childNodes, o = 0, a = s.length; o < a; o++) e = s[o], i.add_node(e);
        return i.parsed
    }, e = function () {
        function e(i, n) {
            if (this.form_field = i, this.options = t.extend({}, l, null != n ? n : {}), e.browser_is_supported()) {
                var o = this.options.lang || t.zui.clientLang ? t.zui.clientLang() : "en",
                    a = t.zui.clientLang ? t.zui.clientLang() : "en";
                t.isPlainObject(o) ? this.lang = t.zui.getLangData ? t.zui.getLangData("chosen", a, r) : t.extend(o, r.en, r[a]) : this.lang = t.zui.getLangData ? t.zui.getLangData("chosen", o, r) : r[o || a] || r.en, this.is_multiple = this.form_field.multiple, this.set_default_text(), this.set_default_values(), this.setup(), this.set_up_html(), this.register_observers()
            }
        }

        return e.prototype.set_default_values = function () {
            var t = this, e = t.options;
            t.click_test_action = function (e) {
                return t.test_active_click(e)
            }, t.activate_action = function (e) {
                return t.activate_field(e)
            }, t.active_field = !1, t.mouse_on_container = !1, t.results_showing = !1, t.result_highlighted = null, t.allow_single_deselect = null != e.allow_single_deselect && null != this.form_field.options[0] && "" === t.form_field.options[0].text && e.allow_single_deselect, t.disable_search_threshold = e.disable_search_threshold || 0, t.disable_search = e.disable_search || !1, t.enable_split_word_search = null == e.enable_split_word_search || e.enable_split_word_search, t.group_search = null == e.group_search || e.group_search, t.search_contains = e.search_contains || !1, t.single_backstroke_delete = null == e.single_backstroke_delete || e.single_backstroke_delete, t.max_selected_options = e.max_selected_options || 1 / 0, t.drop_direction = e.drop_direction || "auto", t.drop_item_height = void 0 !== e.drop_item_height ? e.drop_item_height : 25, t.max_drop_height = void 0 !== e.max_drop_height ? e.max_drop_height : 240, t.middle_highlight = e.middle_highlight, t.compact_search = e.compact_search || !1, t.inherit_select_classes = e.inherit_select_classes || !1, t.display_selected_options = null == e.display_selected_options || e.display_selected_options, t.sort_value_splitter = e.sort_value_spliter || e.sort_value_splitter || ",", t.sort_field = e.sort_field;
            var i = e.max_drop_width;
            return "string" == typeof i && i.indexOf("px") === i.length - 2 && (i = parseInt(i.substring(0, i.length - 2))), t.max_drop_width = i, t.display_disabled_options = null == e.display_disabled_options || e.display_disabled_options
        }, e.prototype.set_default_text = function () {
            return this.form_field.getAttribute("data-placeholder") ? this.default_text = this.form_field.getAttribute("data-placeholder") : this.is_multiple ? this.default_text = this.options.placeholder_text_multiple || this.options.placeholder_text || e.default_multiple_text : this.default_text = this.options.placeholder_text_single || this.options.placeholder_text || e.default_single_text, this.results_none_found = this.form_field.getAttribute("data-no_results_text") || this.options.no_results_text || this.lang.no_results_text || e.default_no_result_text
        }, e.prototype.mouse_enter = function () {
            return this.mouse_on_container = !0
        }, e.prototype.mouse_leave = function () {
            return this.mouse_on_container = !1
        }, e.prototype.input_focus = function (t) {
            var e = this;
            if (this.is_multiple) {
                if (!this.active_field) return setTimeout(function () {
                    return e.container_mousedown()
                }, 50)
            } else if (!this.active_field) return this.activate_field()
        }, e.prototype.input_blur = function (t) {
            var e = this;
            if (!this.mouse_on_container) return this.active_field = !1, setTimeout(function () {
                return e.blur_test()
            }, 100)
        }, e.prototype.results_option_build = function (e) {
            var i, n, o, a, s;
            i = "", s = this.results_data;
            var r = e && e.first ? [] : null;
            for (o = 0, a = s.length; o < a; o++) n = s[o], i += n.group ? this.result_add_group(n) : this.result_add_option(n), r && n.selected && r.push(n);
            if (r) {
                var l, c;
                if (this.sort_field && this.is_multiple) {
                    l = t(this.sort_field);
                    var h = l.val();
                    if (c = "string" == typeof h && h.length ? h.split(this.sort_value_splitter) : [], c.length) {
                        var d = {};
                        for (o = 0; o < c.length; ++o) d[c[o]] = o;
                        r.sort(function (t, e) {
                            var i = d[t.value], n = d[e.value];
                            return void 0 === i && (i = 0), void 0 === n && (n = 0), i - n
                        })
                    }
                }
                for (c = [], o = 0; o < r.length; ++o) n = r[o], this.is_multiple ? (this.choice_build(n), c.push(n.value)) : this.single_set_selected_text(n.text);
                l && l.length && l.val(c.join(this.sort_value_splitter))
            }
            return i
        }, e.prototype.result_add_option = function (t) {
            var e, i;
            return t.search_match && this.include_option_in_results(t) ? (e = [], t.disabled || t.selected && this.is_multiple || e.push("active-result"), !t.disabled || t.selected && this.is_multiple || e.push("disabled-result"), t.selected && e.push("result-selected"), null != t.group_array_index && e.push("group-option"), "" !== t.classes && e.push(t.classes), i = document.createElement("li"), i.className = e.join(" "), i.style.cssText = t.style, i.title = t.title, i.setAttribute("data-option-array-index", t.array_index), i.setAttribute("data-data", t.data), i.innerHTML = t.search_text, this.outerHTML(i)) : ""
        }, e.prototype.result_add_group = function (t) {
            var e;
            return (t.search_match || t.group_match) && t.active_options > 0 ? (e = document.createElement("li"), e.className = "group-result", e.title = t.title, e.innerHTML = t.search_text, this.outerHTML(e)) : ""
        }, e.prototype.results_update_field = function () {
            this.set_default_text(), this.is_multiple || this.results_reset_cleanup(), this.result_clear_highlight(), this.results_build(), this.results_showing && (this.winnow_results(), this.autoResizeDrop())
        }, e.prototype.reset_single_select_options = function () {
            var t, e, i, n, o;
            for (n = this.results_data, o = [], e = 0, i = n.length; e < i; e++) t = n[e], t.selected ? o.push(t.selected = !1) : o.push(void 0);
            return o
        }, e.prototype.results_toggle = function () {
            return this.results_showing ? this.results_hide() : this.results_show()
        }, e.prototype.results_search = function (t) {
            return this.results_showing ? this.winnow_results(1) : this.results_show()
        }, e.prototype.winnow_results = function (t) {
            var e, i, n, o, a, s, r, l, c, h, d, u, p;
            for (this.no_results_clear(), a = 0, r = this.get_search_text(), e = r.replace(/[-[\]{}()*+?.,\\^$|#\s]/g, "\\$&"), o = this.search_contains ? "" : "^", n = new RegExp(o + e, "i"), h = new RegExp(e, "i"), p = this.results_data, d = 0, u = p.length; d < u; d++) i = p[d], i.search_match = !1, s = null, this.include_option_in_results(i) && (i.group && (i.group_match = !1, i.active_options = 0), null != i.group_array_index && this.results_data[i.group_array_index] && (s = this.results_data[i.group_array_index], 0 === s.active_options && s.search_match && (a += 1), s.active_options += 1), i.group && !this.group_search || (i.search_text = i.group ? i.label : i.html, i.search_keys_match = this.search_string_match(i.search_keys, n), i.search_text_match = this.search_string_match(i.search_text, n), i.search_match = i.search_text_match || i.search_keys_match, i.search_match && !i.group && (a += 1), i.search_match ? (i.search_text_match && i.search_text.length ? (l = i.search_text.search(h), c = i.search_text.substr(0, l + r.length) + "</em>" + i.search_text.substr(l + r.length), i.search_text = c.substr(0, l) + "<em>" + c.substr(l)) : i.search_keys_match && i.search_keys.length && (l = i.search_keys.search(h), c = i.search_keys.substr(0, l + r.length) + "</em>" + i.search_keys.substr(l + r.length), i.search_text += '&nbsp; <small style="opacity: 0.7">' + c.substr(0, l) + "<em>" + c.substr(l) + "</small>"), null != s && (s.group_match = !0)) : null != i.group_array_index && this.results_data[i.group_array_index].search_match && (i.search_match = !0)));
            return this.result_clear_highlight(), a < 1 && r.length ? (this.update_results_content(""), this.no_results(r)) : (this.update_results_content(this.results_option_build()), this.winnow_results_set_highlight(t))
        }, e.prototype.search_string_match = function (t, e) {
            var i, n, o, a;
            if (e.test(t)) return !0;
            if (this.enable_split_word_search && (t.indexOf(" ") >= 0 || 0 === t.indexOf("[")) && (n = t.replace(/\[|\]/g, "").split(" "), n.length)) for (o = 0, a = n.length; o < a; o++) if (i = n[o], e.test(i)) return !0
        }, e.prototype.choices_count = function () {
            var t, e, i, n;
            if (null != this.selected_option_count) return this.selected_option_count;
            for (this.selected_option_count = 0, n = this.form_field.options, e = 0, i = n.length; e < i; e++) t = n[e], t.selected && "" != t.value && (this.selected_option_count += 1);
            return this.selected_option_count
        }, e.prototype.choices_click = function (t) {
            return t.preventDefault(), this.results_showing || this.is_disabled ? void this.search_field.focus() : this.results_show()
        }, e.prototype.keyup_checker = function (t) {
            var e, i;
            switch (e = null != (i = t.which) ? i : t.keyCode, this.search_field_scale(), e) {
                case 8:
                    if (this.is_multiple && this.backstroke_length < 1 && this.choices_count() > 0) return this.keydown_backstroke();
                    if (!this.pending_backstroke) return this.result_clear_highlight(), this.results_search();
                    break;
                case 13:
                    if (t.preventDefault(), this.results_showing) return this.result_select(t);
                    break;
                case 27:
                    return this.results_showing && this.results_hide(), !0;
                case 9:
                case 38:
                case 40:
                case 16:
                case 91:
                case 17:
                    break;
                default:
                    return this.results_search()
            }
        }, e.prototype.clipboard_event_checker = function (t) {
            var e = this;
            return setTimeout(function () {
                return e.results_search()
            }, 50)
        }, e.prototype.container_width = function () {
            return null != this.options.width ? this.options.width : this.form_field && this.form_field.classList && this.form_field.classList.contains("form-control") ? "100%" : "" + this.form_field.offsetWidth + "px"
        }, e.prototype.include_option_in_results = function (t) {
            return !(this.is_multiple && !this.display_selected_options && t.selected) && (!(!this.display_disabled_options && t.disabled) && !t.empty)
        }, e.prototype.search_results_touchstart = function (t) {
            return this.touch_started = !0, this.search_results_mouseover(t)
        }, e.prototype.search_results_touchmove = function (t) {
            return this.touch_started = !1, this.search_results_mouseout(t)
        }, e.prototype.search_results_touchend = function (t) {
            if (this.touch_started) return this.search_results_mouseup(t)
        }, e.prototype.outerHTML = function (t) {
            var e;
            return t.outerHTML ? t.outerHTML : (e = document.createElement("div"), e.appendChild(t), e.innerHTML)
        }, e.browser_is_supported = function () {
            return "Microsoft Internet Explorer" === window.navigator.appName ? document.documentMode >= 8 : !/iP(od|hone)/i.test(window.navigator.userAgent) && (!/Android/i.test(window.navigator.userAgent) || !/Mobile/i.test(window.navigator.userAgent))
        }, e.default_multiple_text = "", e.default_single_text = "", e.default_no_result_text = "No results match", e
    }(), t = jQuery, t.fn.extend({
        chosen: function (n) {
            return e.browser_is_supported() ? this.each(function (e) {
                var o = t(this), a = o.data("chosen");
                "destroy" === n && a ? a.destroy() : a || o.data("chosen", new i(this, t.extend({}, o.data(), n)))
            }) : this
        }
    }), i = function (e) {
        function i() {
            return o = i.__super__.constructor.apply(this, arguments)
        }

        return s(i, e), i.prototype.setup = function () {
            return this.form_field_jq = t(this.form_field), this.current_selectedIndex = this.form_field.selectedIndex, this.is_rtl = this.form_field_jq.hasClass("chosen-rtl")
        }, i.prototype.set_up_html = function () {
            var e, i;
            e = ["chosen-container"], e.push("chosen-container-" + (this.is_multiple ? "multi" : "single")), this.inherit_select_classes && this.form_field.className && e.push(this.form_field.className), this.is_rtl && e.push("chosen-rtl");
            var n = this.form_field.getAttribute("data-css-class");
            return n && e.push(n), i = {
                "class": e.join(" "),
                style: "width: " + this.container_width() + ";",
                title: this.form_field.title
            }, this.form_field.id.length && (i.id = this.form_field.id.replace(/[^\w]/g, "_") + "_chosen"), this.container = t("<div />", i), this.is_multiple ? this.container.html('<ul class="chosen-choices"><li class="search-field"><input type="text" value="' + this.default_text + '" class="default" autocomplete="off" style="width:25px;" /></li></ul><div class="chosen-drop"><ul class="chosen-results"></ul></div>') : (this.container.html('<a class="chosen-single chosen-default" tabindex="-1"><span>' + this.default_text + '</span><div><b></b></div><div class="chosen-search"><input type="text" autocomplete="off" /></div></a><div class="chosen-drop"><ul class="chosen-results"></ul></div>'), this.compact_search ? this.container.addClass("chosen-compact").find(".chosen-search").appendTo(this.container.find(".chosen-single")) : this.container.find(".chosen-search").prependTo(this.container.find(".chosen-drop")), this.options.highlight_selected !== !1 && this.container.addClass("chosen-highlight-selected")), this.form_field_jq.hide().after(this.container), this.dropdown = this.container.find("div.chosen-drop").first(), this.search_field = this.container.find("input").first(), this.search_results = this.container.find("ul.chosen-results").first(), this.search_field_scale(), this.search_no_results = this.container.find("li.no-results").first(), this.is_multiple ? (this.search_choices = this.container.find("ul.chosen-choices").first(), this.search_container = this.container.find("li.search-field").first()) : (this.search_container = this.container.find("div.chosen-search").first(), this.selected_item = this.container.find(".chosen-single").first()), this.options.drop_width && this.dropdown.css("width", this.options.drop_width).addClass("chosen-drop-size-limited"), this.max_drop_width && this.dropdown.addClass("chosen-auto-max-width"), this.options.no_wrap && this.dropdown.addClass("chosen-no-wrap"), this.results_build(), this.set_tab_index(), this.set_label_behavior(), this.form_field_jq.trigger("chosen:ready", {chosen: this})
        }, i.prototype.register_observers = function () {
            var t = this;
            return this.container.bind("mousedown.chosen", function (e) {
                t.container_mousedown(e)
            }), this.container.bind("mouseup.chosen", function (e) {
                t.container_mouseup(e)
            }), this.container.bind("mouseenter.chosen", function (e) {
                t.mouse_enter(e)
            }), this.container.bind("mouseleave.chosen", function (e) {
                t.mouse_leave(e)
            }), this.search_results.bind("mouseup.chosen", function (e) {
                t.search_results_mouseup(e)
            }), this.search_results.bind("mouseover.chosen", function (e) {
                t.search_results_mouseover(e)
            }), this.search_results.bind("mouseout.chosen", function (e) {
                t.search_results_mouseout(e)
            }), this.search_results.bind("mousewheel.chosen DOMMouseScroll.chosen", function (e) {
                t.search_results_mousewheel(e)
            }), this.search_results.bind("touchstart.chosen", function (e) {
                t.search_results_touchstart(e)
            }), this.search_results.bind("touchmove.chosen", function (e) {
                t.search_results_touchmove(e)
            }), this.search_results.bind("touchend.chosen", function (e) {
                t.search_results_touchend(e)
            }), this.form_field_jq.bind("chosen:updated.chosen", function (e) {
                t.results_update_field(e)
            }), this.form_field_jq.bind("chosen:activate.chosen", function (e) {
                t.activate_field(e)
            }), this.form_field_jq.bind("chosen:open.chosen", function (e) {
                t.container_mousedown(e)
            }), this.form_field_jq.bind("chosen:close.chosen", function (e) {
                t.input_blur(e)
            }), this.search_field.bind("blur.chosen", function (e) {
                t.input_blur(e)
            }), this.search_field.bind("keyup.chosen", function (e) {
                t.keyup_checker(e)
            }), this.search_field.bind("keydown.chosen", function (e) {
                t.keydown_checker(e)
            }), this.search_field.bind("focus.chosen", function (e) {
                t.input_focus(e)
            }), this.search_field.bind("cut.chosen", function (e) {
                t.clipboard_event_checker(e)
            }), this.search_field.bind("paste.chosen", function (e) {
                t.clipboard_event_checker(e)
            }), this.is_multiple ? this.search_choices.bind("click.chosen", function (e) {
                t.choices_click(e)
            }) : this.container.bind("click.chosen", function (t) {
                t.preventDefault()
            })
        }, i.prototype.destroy = function () {
            return t(this.container[0].ownerDocument).unbind("click.chosen", this.click_test_action), this.search_field[0].tabIndex && (this.form_field_jq[0].tabIndex = this.search_field[0].tabIndex), this.container.remove(), this.form_field_jq.removeData("chosen"), this.form_field_jq.show()
        }, i.prototype.search_field_disabled = function () {
            return this.is_disabled = this.form_field_jq[0].disabled, this.is_disabled ? (this.container.addClass("chosen-disabled"), this.search_field[0].disabled = !0, this.is_multiple || this.selected_item.unbind("focus.chosen", this.activate_action), this.close_field()) : (this.container.removeClass("chosen-disabled"), this.search_field[0].disabled = !1, this.is_multiple ? void 0 : this.selected_item.bind("focus.chosen", this.activate_action))
        }, i.prototype.container_mousedown = function (e) {
            if (!this.is_disabled && (e && "mousedown" === e.type && !this.results_showing && e.preventDefault(), null == e || !t(e.target).hasClass("search-choice-close"))) return this.active_field ? this.is_multiple || !e || t(e.target)[0] !== this.selected_item[0] && !t(e.target).parents("a.chosen-single").length || (e.preventDefault(), this.results_toggle()) : (this.is_multiple && this.search_field.val(""), t(this.container[0].ownerDocument).bind("click.chosen", this.click_test_action), this.results_show()), this.activate_field()
        }, i.prototype.container_mouseup = function (t) {
            if ("ABBR" === t.target.nodeName && !this.is_disabled) return this.results_reset(t)
        }, i.prototype.search_results_mousewheel = function (t) {
            var e;
            if (t.originalEvent && (e = -t.originalEvent.wheelDelta || t.originalEvent.detail), null != e) return t.preventDefault(), "DOMMouseScroll" === t.type && (e = 40 * e), this.search_results.scrollTop(e + this.search_results.scrollTop())
        }, i.prototype.blur_test = function (t) {
            if (!this.active_field && this.container.hasClass("chosen-container-active")) return this.close_field()
        }, i.prototype.close_field = function () {
            return t(this.container[0].ownerDocument).unbind("click.chosen", this.click_test_action), this.active_field = !1, this.results_hide(), this.container.removeClass("chosen-container-active"), this.clear_backstroke(), this.show_search_field_default(), this.search_field_scale()
        }, i.prototype.activate_field = function () {
            return this.container.addClass("chosen-container-active"), this.active_field = !0, this.search_field.val(this.search_field.val()), this.search_field.focus()
        }, i.prototype.test_active_click = function (e) {
            var i;
            return i = t(e.target).closest(".chosen-container"), i.length && this.container[0] === i[0] ? this.active_field = !0 : this.close_field()
        }, i.prototype.results_build = function () {
            return this.parsing = !0, this.selected_option_count = null, this.results_data = n.select_to_array(this.form_field), this.is_multiple ? this.search_choices.find("li.search-choice").remove() : this.is_multiple || (this.single_set_selected_text(), this.disable_search || this.form_field.options.length <= this.disable_search_threshold ? (this.search_field[0].readOnly = !0, this.container.addClass("chosen-container-single-nosearch"), this.container.removeClass("chosen-with-search")) : (this.search_field[0].readOnly = !1, this.container.removeClass("chosen-container-single-nosearch"), this.container.addClass("chosen-with-search"))), this.update_results_content(this.results_option_build({first: !0})), this.search_field_disabled(), this.show_search_field_default(), this.search_field_scale(), this.parsing = !1
        }, i.prototype.result_do_highlight = function (t, e) {
            if (t.length) {
                var i, n, o, a, s, r, l = -1;
                this.result_clear_highlight(), this.result_highlight = t, this.result_highlight.addClass("highlighted"), o = parseInt(this.search_results.css("maxHeight"), 10), r = this.result_highlight.outerHeight(), s = this.search_results.scrollTop(), a = o + s, n = this.result_highlight.position().top + this.search_results.scrollTop(), i = n + r, this.middle_highlight && (e || "always" === this.middle_highlight) ? l = Math.min(n - r, Math.max(0, n - (o - r) / 2)) : i >= a ? l = i - o > 0 ? i - o : 0 : n < s && (l = n), l > -1 ? this.search_results.scrollTop(l) : this.result_highlight.scrollIntoView && this.result_highlight.scrollIntoView()
            }
        }, i.prototype.result_clear_highlight = function () {
            return this.result_highlight && this.result_highlight.removeClass("highlighted"), this.result_highlight = null
        }, i.prototype.results_show = function () {
            var e = this;
            if (e.is_multiple && e.max_selected_options <= e.choices_count()) return e.form_field_jq.trigger("chosen:maxselected", {chosen: this}), !1;
            e.results_showing = !0, e.search_field.val(e.search_field.val()), e.search_field.focus(), e.container.addClass("chosen-with-drop"), e.winnow_results(1);
            var i = e.drop_direction;
            if ("function" == typeof i && (i = i.call(this)), "auto" === i) if (e.drop_directionFixed) i = e.drop_directionFixed; else {
                var n = e.container.find(".chosen-drop"), o = n.outerHeight();
                e.drop_item_height && o < e.max_drop_height && (o = Math.min(e.max_drop_height, n.find(".chosen-results>.active-result").length * e.drop_item_height));
                var a = e.container.offset();
                a.top + o + 30 > t(window).height() + t(window).scrollTop() && (i = "up"), e.drop_directionFixed = i
            }
            return e.container.toggleClass("chosen-up", "up" === i), e.autoResizeDrop(), e.form_field_jq.trigger("chosen:showing_dropdown", {chosen: e})
        }, i.prototype.autoResizeDrop = function () {
            var e = this, i = e.max_drop_width;
            if (i) {
                var n = e.container.find(".chosen-drop");
                n.removeClass("in");
                var o = 0, a = n.find(".chosen-results"), s = a.children("li"),
                    r = parseFloat(a.css("padding-left").replace("px", "")),
                    l = parseFloat(a.css("padding-right").replace("px", "")),
                    c = (isNaN(r) ? 0 : r) + (isNaN(l) ? 0 : l);
                s.each(function () {
                    o = Math.max(o, t(this).outerWidth())
                }), n.css("width", Math.min(o + c + 20, i)), e.fixDropWidthTimer = setTimeout(function () {
                    e.fixDropWidthTimer = null, n.addClass("in"), e.winnow_results_set_highlight(1)
                }, 50)
            }
        }, i.prototype.update_results_content = function (t) {
            return this.search_results.html(t)
        }, i.prototype.results_hide = function () {
            var t = this;
            return t.fixDropWidthTimer && (clearTimeout(t.fixDropWidthTimer), t.fixDropWidthTimer = null), t.results_showing && (t.result_clear_highlight(), t.container.removeClass("chosen-with-drop"), t.form_field_jq.trigger("chosen:hiding_dropdown", {chosen: t}), t.drop_directionFixed = 0), t.results_showing = !1
        }, i.prototype.set_tab_index = function (t) {
            var e;
            if (this.form_field.tabIndex) return e = this.form_field.tabIndex, this.form_field.tabIndex = -1, this.search_field[0].tabIndex = e
        }, i.prototype.set_label_behavior = function () {
            var e = this;
            if (this.form_field_label = this.form_field_jq.parents("label"), !this.form_field_label.length && this.form_field.id.length && (this.form_field_label = t("label[for='" + this.form_field.id + "']")), this.form_field_label.length > 0) return this.form_field_label.bind("click.chosen", function (t) {
                return e.is_multiple ? e.container_mousedown(t) : e.activate_field()
            })
        }, i.prototype.show_search_field_default = function () {
            return this.is_multiple && this.choices_count() < 1 && !this.active_field ? (this.search_field.val(this.default_text), this.search_field.addClass("default")) : (this.search_field.val(""), this.search_field.removeClass("default"))
        }, i.prototype.search_results_mouseup = function (e) {
            var i;
            if (i = t(e.target).hasClass("active-result") ? t(e.target) : t(e.target).parents(".active-result").first(), i.length) return this.result_highlight = i, this.result_select(e), this.search_field.focus()
        }, i.prototype.search_results_mouseover = function (e) {
            var i;
            if (i = t(e.target).hasClass("active-result") ? t(e.target) : t(e.target).parents(".active-result").first()) return this.result_do_highlight(i)
        }, i.prototype.search_results_mouseout = function (e) {
            if (t(e.target).hasClass("active-result")) return this.result_clear_highlight()
        }, i.prototype.choice_build = function (e) {
            var i, n, o = this;
            return i = t("<li />", {"class": "search-choice"}).html("<span title='" + e.html + "'>" + e.html + "</span>"), e.disabled ? i.addClass("search-choice-disabled") : (n = t("<a />", {
                "class": "search-choice-close",
                "data-option-array-index": e.array_index
            }), n.bind("click.chosen", function (t) {
                return o.choice_destroy_link_click(t)
            }), i.append(n)), this.search_container.before(i)
        }, i.prototype.choice_destroy_link_click = function (e) {
            if (e.preventDefault(), e.stopPropagation(), !this.is_disabled) return this.choice_destroy(t(e.target))
        }, i.prototype.choice_destroy = function (t) {
            if (this.result_deselect(t[0].getAttribute("data-option-array-index"))) return this.show_search_field_default(), this.is_multiple && this.choices_count() > 0 && this.search_field.val().length < 1 && this.results_hide(), t.parents("li").first().remove(), this.search_field_scale()
        }, i.prototype.results_reset = function () {
            var t = this.form_field_jq.val();
            this.reset_single_select_options(), this.form_field.options[0].selected = !0, this.single_set_selected_text(), this.show_search_field_default(), this.results_reset_cleanup();
            var e = this.form_field_jq.val(), i = {selected: e};
            if (t === e || e.length || (i.deselected = t), this.form_field_jq.trigger("change", i), this.sync_sort_field(), this.active_field) return this.results_hide()
        }, i.prototype.results_reset_cleanup = function () {
            return this.current_selectedIndex = this.form_field.selectedIndex, this.selected_item.find("abbr").remove()
        }, i.prototype.result_select = function (t) {
            var e, i;
            if (this.result_highlight) return e = this.result_highlight, this.result_clear_highlight(), this.is_multiple && this.max_selected_options <= this.choices_count() ? (this.form_field_jq.trigger("chosen:maxselected", {chosen: this}), !1) : (this.is_multiple ? e.removeClass("active-result") : this.reset_single_select_options(), i = this.results_data[e[0].getAttribute("data-option-array-index")], i.selected = !0, this.form_field.options[i.options_index].selected = !0, this.selected_option_count = null, this.is_multiple ? this.choice_build(i) : this.single_set_selected_text(i.text), (t.metaKey || t.ctrlKey) && this.is_multiple || this.results_hide(), this.search_field.val(""), (this.is_multiple || this.form_field.selectedIndex !== this.current_selectedIndex) && (this.form_field_jq.trigger("change", {selected: this.form_field.options[i.options_index].value}), this.sync_sort_field()), this.current_selectedIndex = this.form_field.selectedIndex, this.search_field_scale())
        }, i.prototype.single_set_selected_text = function (t) {
            return null == t && (t = this.default_text), t === this.default_text ? this.selected_item.addClass("chosen-default") : (this.single_deselect_control_build(), this.selected_item.removeClass("chosen-default")), this.compact_search && this.search_field.attr("placeholder", t), this.selected_item.find("span").attr("title", t).text(t)
        }, i.prototype.sync_sort_field = function () {
            var e = this;
            if (e.is_multiple && e.sort_field) {
                var i = t(e.sort_field);
                if (!i.length) return;
                var n = [];
                e.search_choices.find("li.search-choice").each(function () {
                    var i = t(this), o = i.children(".search-choice-close").first().data("optionArrayIndex"),
                        a = e.results_data[o];
                    a && a.selected && n.push(a.value)
                }), i.val(n.join(e.sort_value_splitter)).trigger("change")
            }
        }, i.prototype.result_deselect = function (t) {
            var e;
            return e = this.results_data[t], !this.form_field.options[e.options_index].disabled && (e.selected = !1, this.form_field.options[e.options_index].selected = !1, this.selected_option_count = null, this.result_clear_highlight(), this.results_showing && this.winnow_results(), this.form_field_jq.trigger("change", {deselected: this.form_field.options[e.options_index].value}), this.sync_sort_field(), this.search_field_scale(), !0)
        }, i.prototype.single_deselect_control_build = function () {
            if (this.allow_single_deselect) return this.selected_item.find("abbr").length || this.selected_item.find("span").first().after('<abbr class="search-choice-close"></abbr>'), this.selected_item.addClass("chosen-single-with-deselect")
        }, i.prototype.get_search_text = function () {
            return this.search_field.val() === this.default_text ? "" : t("<div/>").text(t.trim(this.search_field.val())).html()
        }, i.prototype.winnow_results_set_highlight = function (t) {
            var e, i;
            if (i = this.is_multiple ? [] : this.search_results.find(".result-selected.active-result"), e = i.length ? i.first() : this.search_results.find(".active-result").first(), null != e) return this.result_do_highlight(e, t)
        }, i.prototype.no_results = function (e) {
            var i;
            return i = t('<li class="no-results">' + this.results_none_found + ' "<span></span>"</li>'), i.find("span").first().html(e), this.search_results.append(i), this.form_field_jq.trigger("chosen:no_results", {chosen: this})
        }, i.prototype.no_results_clear = function () {
            return this.search_results.find(".no-results").remove()
        }, i.prototype.keydown_arrow = function () {
            var t;
            return this.results_showing && this.result_highlight ? (t = this.result_highlight.nextAll("li.active-result").first()) ? this.result_do_highlight(t) : void 0 : this.results_show()
        }, i.prototype.keyup_arrow = function () {
            var t;
            return this.results_showing || this.is_multiple ? this.result_highlight ? (t = this.result_highlight.prevAll("li.active-result"), t.length ? this.result_do_highlight(t.first()) : (this.choices_count() > 0 && this.results_hide(), this.result_clear_highlight())) : void 0 : this.results_show()
        }, i.prototype.keydown_backstroke = function () {
            var t;
            return this.pending_backstroke ? (this.choice_destroy(this.pending_backstroke.find("a").first()), this.clear_backstroke()) : (t = this.search_container.siblings("li.search-choice").last(), t.length && !t.hasClass("search-choice-disabled") ? (this.pending_backstroke = t, this.single_backstroke_delete ? this.keydown_backstroke() : this.pending_backstroke.addClass("search-choice-focus")) : void 0)
        }, i.prototype.clear_backstroke = function () {
            return this.pending_backstroke && this.pending_backstroke.removeClass("search-choice-focus"), this.pending_backstroke = null
        }, i.prototype.keydown_checker = function (t) {
            var e, i;
            switch (e = null != (i = t.which) ? i : t.keyCode, this.search_field_scale(), 8 !== e && this.pending_backstroke && this.clear_backstroke(), e) {
                case 8:
                    this.backstroke_length = this.search_field.val().length;
                    break;
                case 9:
                    this.results_showing && !this.is_multiple && this.result_select(t), this.mouse_on_container = !1;
                    break;
                case 13:
                    t.preventDefault();
                    break;
                case 38:
                    t.preventDefault(), this.keyup_arrow();
                    break;
                case 40:
                    t.preventDefault(), this.keydown_arrow()
            }
        }, i.prototype.search_field_scale = function () {
            var e, i, n, o, a, s, r, l, c;
            if (this.is_multiple) {
                for (n = 0, r = 0, a = "position:absolute; left: -1000px; top: -1000px; display:none;", s = ["font-size", "font-style", "font-weight", "font-family", "line-height", "text-transform", "letter-spacing"], l = 0, c = s.length; l < c; l++) o = s[l], a += o + ":" + this.search_field.css(o) + ";";
                return e = t("<div />", {style: a}), e.text(this.search_field.val()), t("body").append(e), r = e.width() + 25, e.remove(), i = this.container.outerWidth(), r > i - 10 && (r = i - 10), this.search_field.css({width: r + "px"})
            }
        }, i
    }(e), i.DEFAULTS = l, i.LANGUAGES = r, t.fn.chosen.Constructor = i
}.call(this), function (t) {
    "use strict";
    var e = "zui.selectable", i = function (i, n) {
        this.name = e, this.$ = t(i), this.id = t.zui.uuid(), this.selectOrder = 1, this.selections = {}, this.getOptions(n), this._init()
    }, n = function (t, e, i) {
        return t >= i.left && t <= i.left + i.width && e >= i.top && e <= i.top + i.height
    }, o = function (t, e) {
        var i = Math.max(t.left, e.left), o = Math.max(t.top, e.top), a = Math.min(t.left + t.width, e.left + e.width),
            s = Math.min(t.top + t.height, e.top + e.height);
        return n(i, o, t) && n(a, s, t) && n(i, o, e) && n(a, s, e)
    };
    i.DEFAULTS = {
        selector: "li,tr,div",
        trigger: "",
        selectClass: "active",
        rangeStyle: {
            border: "1px solid " + (t.zui.colorset ? t.zui.colorset.primary : "#3280fc"),
            backgroundColor: t.zui.colorset ? new t.zui.Color(t.zui.colorset.primary).fade(20).toCssStr() : "rgba(50, 128, 252, 0.2)"
        },
        clickBehavior: "toggle",
        ignoreVal: 3,
        listenClick: !0
    }, i.prototype.getOptions = function (e) {
        this.options = t.extend({}, i.DEFAULTS, this.$.data(), e)
    }, i.prototype.select = function (t) {
        this.toggle(t, !0)
    }, i.prototype.unselect = function (t) {
        this.toggle(t, !1)
    }, i.prototype.toggle = function (e, i, n) {
        var o, a, s = this.options.selector, r = this;
        if (void 0 === e) return void this.$.find(s).each(function () {
            r.toggle(this, i)
        });
        if ("object" == typeof e ? (o = t(e).closest(s), a = o.data("id")) : (a = e, o = r.$.find('.selectable-item[data-id="' + a + '"]')), o && o.length) {
            if (a || (a = t.zui.uuid(), o.attr("data-id", a)), void 0 !== i && null !== i || (i = !r.selections[a]), !!i != !!r.selections[a]) {
                var l;
                "function" == typeof n && (l = n(i)), l !== !0 && (r.selections[a] = !!i && r.selectOrder++, r.callEvent(i ? "select" : "unselect", {
                    id: a,
                    selections: r.selections,
                    target: o,
                    selected: r.getSelectedArray()
                }, r))
            }
            r.options.selectClass && o.toggleClass(r.options.selectClass, i)
        }
    }, i.prototype.getSelectedArray = function () {
        var e = [];
        return t.each(this.selections, function (t, i) {
            i && e.push(t)
        }), e
    }, i.prototype.syncSelectionsFromClass = function () {
        var e = this, i = e.$children = e.$.find(e.options.selector);
        e.selections = {}, i.each(function () {
            var i = t(this);
            e.selections[i.data("id")] = i.hasClass(e.options.selectClass)
        })
    }, i.prototype._init = function () {
        var e, i, n, a, s, r, l, c = this.options, h = this, d = c.ignoreVal, u = !0,
            p = "." + this.name + "." + this.id, f = "function" == typeof c.checkFunc ? c.checkFunc : null,
            g = "function" == typeof c.rangeFunc ? c.rangeFunc : null, m = !1, v = null, y = "mousedown" + p,
            b = function () {
                a && h.$children.each(function () {
                    var e = t(this), i = e.offset();
                    i.width = e.outerWidth(), i.height = e.outerHeight();
                    var n = g ? g.call(this, a, i) : o(a, i);
                    if (f) {
                        var s = f.call(h, {intersect: n, target: e, range: a, targetRange: i});
                        s === !0 ? h.select(e) : s === !1 && h.unselect(e)
                    } else n ? h.select(e) : h.multiKey || h.unselect(e)
                })
            }, w = function (o) {
                m && (s = o.pageX, r = o.pageY, a = {
                    width: Math.abs(s - e),
                    height: Math.abs(r - i),
                    left: s > e ? e : s,
                    top: r > i ? i : r
                }, u && a.width < d && a.height < d || (n || (n = t('.selectable-range[data-id="' + h.id + '"]'), n.length || (n = t('<div class="selectable-range" data-id="' + h.id + '"></div>').css(t.extend({
                    zIndex: 1060,
                    position: "absolute",
                    top: e,
                    left: i,
                    pointerEvents: "none"
                }, h.options.rangeStyle)).appendTo(t("body")))), n.css(a), clearTimeout(l), l = setTimeout(b, 10), u = !1))
            }, x = 0, C = function (e) {
                x && (t.zui.clearAsap || clearTimeout)(x), x = (t.zui.asap || setTimeout)(function () {
                    x = 0, w(e)
                }, 0)
            }, _ = function (e) {
                t(document).off(p), clearTimeout(v), m && (m = !1, n && n.remove(), u || a && (clearTimeout(l), b(), a = null), h.callEvent("finish", {
                    selections: h.selections,
                    selected: h.getSelectedArray()
                }), e.preventDefault())
            }, k = function (o) {
                if (m) return _(o);
                var a = t.zui.getMouseButtonCode(c.mouseButton);
                if (!(a > -1 && o.button !== a || t(o.target).closest("input,select,textarea,label").length || h.altKey || 3 === o.which || h.callEvent("start", o) === !1)) {
                    var s = h.$children = h.$.find(c.selector);
                    s.addClass("selectable-item");
                    var r = h.multiKey ? "multi" : c.clickBehavior;
                    if ("single" === r && h.unselect(), c.listenClick && ("multi" === r ? h.toggle(o.target) : "single" === r ? h.select(o.target) : "toggle" === r && h.toggle(o.target, null, function (t) {
                        h.unselect()
                    })), h.callEvent("startDrag", o) === !1) return void h.callEvent("finish", {
                        selections: h.selections,
                        selected: h.getSelectedArray()
                    });
                    e = o.pageX, i = o.pageY, n = null, u = !0, m = !0, t(document).on("mousemove" + p, C).on("mouseup" + p, _), v = setTimeout(function () {
                        t(document).on(y, _)
                    }, 10), o.preventDefault()
                }
            }, T = c.container && "default" !== c.container ? t(c.container) : this.$;
        c.trigger ? T.on(y, c.trigger, k) : T.on(y, k), t(document).on("keydown", function (t) {
            var e = t.keyCode;
            17 === e || 91 == e ? h.multiKey = e : 18 === e && (h.altKey = !0)
        }).on("keyup", function (t) {
            h.multiKey = !1, h.altKey = !1
        })
    }, i.prototype.callEvent = function (e, i) {
        var n = t.Event(e + "." + this.name);
        this.$.trigger(n, i);
        var o = n.result, a = this.options[e];
        return "function" == typeof a && (o = a.apply(this, Array.isArray(i) ? i : [i])), o
    }, t.fn.selectable = function (n) {
        return this.each(function () {
            var o = t(this), a = o.data(e), s = "object" == typeof n && n;
            a || o.data(e, a = new i(this, s)), "string" == typeof n && a[n]()
        })
    }, t.fn.selectable.Constructor = i, t(function () {
        t('[data-ride="selectable"]').selectable()
    })
}(jQuery), +function (t, e, i) {
    "use strict";
    if (!t.fn.droppable) return void console.error("Sortable requires droppable.js");
    var n = "zui.sortable", o = {selector: "li,div", dragCssClass: "invisible", sortingClass: "sortable-sorting"},
        a = "order", s = function (e, i) {
            var n = this;
            n.$ = t(e), n.options = t.extend({}, o, n.$.data(), i), n.init()
        };
    s.DEFAULTS = o, s.NAME = n, s.prototype.init = function () {
        var e, i, n = this, o = n.$, s = n.options, r = s.selector, l = s.containerSelector, c = s.sortingClass,
            h = s.dragCssClass, d = s.targetSelector, u = s.reverse, p = s.moveDirection, f = function (e) {
                e = e || n.getItems(1);
                var i = e.length;
                i && e.each(function (e) {
                    var n = u ? i - e : e;
                    t(this).attr("data-" + a, n).data(a, n)
                })
            };
        d || f(), o.droppable({
            handle: s.trigger,
            target: d ? d : l ? r + "," + l : r,
            selector: r,
            container: s.container || o,
            always: s.always,
            flex: !0,
            lazy: s.lazy,
            canMoveHere: s.canMoveHere,
            dropToClass: s.dropToClass,
            before: s.before,
            nested: !!l,
            mouseButton: s.mouseButton,
            noShadow: s.noShadow,
            dropOnMouseleave: s.dropOnMouseleave,
            stopPropagation: s.stopPropagation,
            start: function (t) {
                if (h && t.element.addClass(h), e = !1, n.$element = t.element, !p && t.targets.length > 1) {
                    var i = t.targets.eq(0).offset(), o = t.targets.eq(1).offset();
                    p = Math.abs(i.left - o.left) > Math.abs(i.top - o.top) ? "h" : "v"
                }
                f(), n.trigger("start", t)
            },
            drag: function (t) {
                if (o.addClass(c), t.isIn) {
                    var s = t.target, h = t.element, d = l && s.is(l);
                    if (d) return void (s.children(r).filter(".dragging").length || (s.append(h), f(w), n.trigger(a, {
                        list: w,
                        element: h
                    })));
                    var g = h.data(a), m = s.data(a);
                    if (g !== m) {
                        var v = "h" === p ? "left" : "top", y = t.mouseOffset[v] - t.lastMouseOffset[v];
                        if (0 !== y) {
                            var b = g > m ? u : !u;
                            if (!(y < 0 && b || y > 0 && !b)) {
                                i = b ? "after" : "before", s[i](h), e = !0, n.$target = s, n.$element = h;
                                var w = n.getItems(1);
                                f(w), n.trigger(a, {insert: i, target: s, list: w, element: h})
                            }
                        }
                    }
                }
            },
            finish: function (t) {
                h && t.element && t.element.removeClass(h), o.removeClass(c), n.trigger("finish", {
                    insert: i,
                    target: n.$target,
                    list: n.getItems(),
                    element: n.$element,
                    changed: e
                }), n.$element = null, n.$target = null
            }
        })
    }, s.prototype.destroy = function () {
        this.$.droppable("destroy"), this.$.data(n, null)
    }, s.prototype.reset = function () {
        this.destroy(), this.init()
    }, s.prototype.getItems = function (e) {
        var i, n = this, o = n.options.targetSelector;
        return i = o ? "function" == typeof o ? o(n.$element, n.$) : n.$.find(o) : n.$.find(n.options.selector), i = i.not(".drag-shadow"), e ? i : i.map(function () {
            var e = t(this);
            return {item: e, order: e.data("order")}
        })
    }, s.prototype.trigger = function (e, i) {
        return t.zui.callEvent(this.options[e], i, this)
    }, t.fn.sortable = function (e) {
        return this.each(function () {
            var i = t(this), o = i.data(n), a = "object" == typeof e && e;
            o ? "object" == typeof e && o.reset() : i.data(n, o = new s(this, a)), "string" == typeof e && o[e]()
        })
    }, t.fn.sortable.Constructor = s
}(jQuery, window, document), function (t, e) {
    "use strict";

    function i(e, i) {
        if ("string" == typeof e && (e = "seperator" === e || "divider" === e || "-" === e || "|" === e ? {type: "seperator"} : {
            label: e,
            id: i
        }), "seperator" === e.type || "divider" === e.type) return t('<li class="divider"></li>');
        var n = t("<a/>").attr(t.extend({
            href: e.url || "###",
            "class": e.className,
            style: e.style
        }, e.attrs)).data("item", e);
        e.html ? e.html === !0 ? n.html(e.label || e.text) : n = t(e.html) : n.text(e.label || e.text), e.icon && n.prepend('<i class="icon icon-' + e.icon + '"></i>'), e.onClick && n.on("click", e.onClick);
        var o = t("<li />").toggleClass("disabled", e.disabled === !0).append(n);
        return e.items && o.data("item", e).addClass("dropdown-submenu"), o
    }

    function n(e, n, o) {
        var a = o.itemCreator || i, s = typeof e;
        return "string" === s ? e = e.split(",") : "function" === s && (e = e(o)), !!e && (t.each(e, function (t, e) {
            n.append(a(e, t, o))
        }), !0)
    }

    var o = "zui.contextmenu",
        a = {animation: "fade", menuTemplate: '<ul class="dropdown-menu"></ul>', toggleTrigger: !1, duration: 200},
        s = !1, r = {}, l = "zui-contextmenu-" + t.zui.uuid(), c = 0, h = 0, d = function () {
            return t(document).off("mousemove." + o).on("mousemove." + o, function (t) {
                c = t.clientX, h = t.clientY
            }), r
        }, u = function (e) {
            var i = t("#" + l);
            return i.length && i.hasClass("contextmenu-show") && (!e || (i.data("options") || {}).id === e)
        }, p = null, f = function (e, i) {
            "function" == typeof e && (i = e, e = null), p && (clearTimeout(p), p = null);
            var n = t("#" + l);
            if (n.length) {
                var o = n.removeClass("contextmenu-show").data("options");
                if (!e || o.id === e) {
                    var a = function () {
                        n.find(".contextmenu-menu").removeClass("open"), o.onHidden && o.onHidden(), i && i()
                    };
                    o.onHide && o.onHide();
                    var s = o.animation;
                    n.find(".contextmenu-menu").removeClass("in"), s ? p = setTimeout(a, o.duration) : a()
                }
            }
            return r
        }, g = function (i, d, u) {
            t.isPlainObject(i) && (u = d, d = i, i = d.items), s = !0, d = t.extend({}, a, d);
            var g = t("#" + l);
            g.length || (g = t('<div style="position: fixed; z-index: 2000;" class="contextmenu" id="' + l + '"><div class="contextmenu-menu"></div></div>').appendTo("body"));
            var m = g.find(".contextmenu-menu").empty();
            m.off("click." + o).on("click." + o, "a,.contextmenu-item", function (e) {
                var i = t(this), n = d.onClickItem && d.onClickItem(i.data("item"), i, e, d);
                n !== !1 && f()
            }).off("mouseenter." + o).on("mouseenter." + o, ".dropdown-submenu", function (e) {
                var i = t(this), o = i.data("item"), a = i.children(".dropdown-menu");
                if (o && (o.items && (a.length || (a = t(d.menuTemplate).appendTo(i)), n(o.items, a, d)), i.removeData("item")), a.length) {
                    a.removeClass("pull-left").css("top", 0);
                    var s = (i[0].getBoundingClientRect(), a[0].getBoundingClientRect()), r = window.innerWidth,
                        l = window.innerHeight;
                    if (s.bottom > l) {
                        var c = Math.max(-s.top, l - s.bottom);
                        a.css("top", c)
                    }
                    s.right > r && a.addClass("pull-left")
                }
            }), m.attr("class", "contextmenu-menu" + (d.className ? " " + d.className : "")), g.attr("class", "contextmenu contextmenu-show");
            var v = d.menuCreator;
            if (v) m.append(v(i, d)); else {
                m.append(d.menuTemplate);
                var y = m.children().first(), b = n(i, y, d);
                if (b === !1) return b
            }
            var w = d.animation, x = d.duration;
            w === !0 && (d.animation = w = "fade"), p && (clearTimeout(p), p = null);
            var C = function () {
                m.addClass("in"), d.onShown && d.onShown(), u && u()
            };
            d.onShow && d.onShow(), g.data("options", {
                animation: w,
                onHide: d.onHide,
                onHidden: d.onHidden,
                id: d.id,
                duration: x
            });
            var _ = d.x, k = d.y;
            _ === e && (_ = (d.event || d).clientX), _ === e && (_ = c), k === e && (k = (d.event || d).clientY), k === e && (k = h);
            var T = window.innerHeight, S = window.innerWidth, y = m.children().first(), D = y.outerWidth(),
                M = y.outerHeight();
            if (d.position) {
                var L = d.position({x: _, y: k, width: D, height: M, winHeight: T, winWidth: S}, d, m);
                L && (_ = L.x, k = L.y)
            }
            return _ = Math.max(0, Math.min(_, S - D)), k = Math.max(0, Math.min(k, T - M)), g.css({
                left: _,
                top: k
            }).show(), m.addClass("open"), w ? (m.addClass(w), p = setTimeout(function () {
                C(), s = !1
            }, 10)) : (C(), s = !1), r
        };
    t.extend(r, {NAME: o, DEFAULTS: a, show: g, hide: f, listenMouse: d, isShow: u}), t.zui({ContextMenu: r});
    var m = function (e, i) {
        var n = this;
        n.name = o, n.$ = t(e), n.id = t.zui.uuid(), i = n.options = t.extend({trigger: "contextmenu"}, r.DEFAULTS, this.$.data(), i);
        var a = function (t) {
            if ("mousedown" !== t.type || 2 === t.button) {
                if (i.toggleTrigger && n.isShow()) n.hide(); else {
                    var e = {x: t.clientX, y: t.clientY, event: t};
                    if (n.show(e) === !1) return
                }
                return t.preventDefault(), t.returnValue = !1, !1
            }
        }, s = i.trigger, l = s + "." + o;
        i.selector ? n.$.on(l, i.selector, a) : n.$.on(l, a), i.show && n.show("object" == typeof i.show ? i.show : null)
    };
    m.prototype.destory = function () {
        that.$.off("." + o)
    }, m.prototype.hide = function (t) {
        return r.hide(this.id, t)
    }, m.prototype.show = function (e, i) {
        return e = t.extend({id: this.id, $toggle: this.$}, this.options, e), r.show(e, i)
    }, m.prototype.isShow = function () {
        return u(this.id)
    }, t.fn.contextmenu = function (e) {
        return this.each(function () {
            var i = t(this), n = i.data(o), a = "object" == typeof e && e;
            n || i.data(o, n = new m(this, a)), "string" == typeof e && n[e]()
        })
    }, t.fn.contextmenu.Constructor = m, t.fn.contextDropdown = function (e) {
        t(this).contextmenu(t.extend({
            trigger: "click", animation: "fade", toggleTrigger: !0, menuCreator: function (e, i) {
                var n = i.$toggle, o = n.attr("data-target");
                o || (o = n.attr("href"), o = o && /#/.test(o) && o.replace(/.*(?=#[^\s]*$)/, ""));
                var a = o ? t(o) : n.next(".dropdown-menu"), s = i.transferEvent;
                if (s !== !1) {
                    var r = "data-contextmenu-index";
                    a.find("a,.contextmenu-item").each(function (e) {
                        t(this).attr(r, e)
                    });
                    var l = a.clone();
                    return l.on("string" == typeof s ? s : "click", "a,.contextmenu-item", function (e) {
                        var i = a.find("[" + r + '="' + t(this).attr(r) + '"]'), n = i[0];
                        if (n) return n[e.type] ? n[e.type]() : i.trigger(e.type), e.preventDefault(), e.stopPropagation(), !1
                    }), l
                }
                return a.clone()
            }, position: function (t, e, i) {
                var n = e.placement, o = e.$toggle;
                if (!n) {
                    var a = i.find(".dropdown-menu"), s = a.hasClass("pull-right"), r = o.parent().hasClass("dropup");
                    n = s ? r ? "top-right" : "bottom-right" : r ? "top-left" : "bottom-left", s && a.removeClass("pull-right")
                }
                var l = o[0].getBoundingClientRect();
                switch (n) {
                    case"top-left":
                        return {x: l.left, y: Math.floor(l.top - t.height)};
                    case"top-right":
                        return {x: Math.floor(l.right - t.width), y: Math.floor(l.top - t.height)};
                    case"bottom-left":
                        return {x: l.left, y: l.bottom};
                    case"bottom-right":
                        return {x: Math.floor(l.right - t.width), y: l.bottom}
                }
                return t
            }
        }, e))
    }, t(document).on("click", function (e) {
        var i = t(e.target), n = i.closest('[data-toggle="context-dropdown"]');
        if (n.length) {
            var a = n.data(o);
            a || n.contextDropdown({show: !0})
        } else s || i.closest(".contextmenu").length || f()
    })
}(jQuery, void 0), function (t) {
    "function" == typeof define && define.amd ? define(["jquery"], t) : "object" == typeof module && module.exports ? module.exports = function (e, i) {
        return "undefined" == typeof i && (i = "undefined" != typeof window ? require("jquery") : require("jquery")(e)), t(i), i
    } : t(jQuery)
}(function (t) {
    "use strict";

    function e(e) {
        var i = e.data;
        e.isDefaultPrevented() || (e.preventDefault(), t(e.target).closest("form").ajaxSubmit(i))
    }

    function i(e) {
        var i = e.target, n = t(i);
        if (!n.is("[type=submit],[type=image]")) {
            var o = n.closest("[type=submit]");
            if (0 === o.length) return;
            i = o[0]
        }
        var a = i.form;
        if (a.clk = i, "image" === i.type) if ("undefined" != typeof e.offsetX) a.clk_x = e.offsetX, a.clk_y = e.offsetY; else if ("function" == typeof t.fn.offset) {
            var s = n.offset();
            a.clk_x = e.pageX - s.left, a.clk_y = e.pageY - s.top
        } else a.clk_x = e.pageX - i.offsetLeft, a.clk_y = e.pageY - i.offsetTop;
        setTimeout(function () {
            a.clk = a.clk_x = a.clk_y = null
        }, 100)
    }

    function n() {
        if (t.fn.ajaxSubmit.debug) {
            var e = "[jquery.form] " + Array.prototype.join.call(arguments, "");
            window.console && window.console.log ? window.console.log(e) : window.opera && window.opera.postError && window.opera.postError(e)
        }
    }

    var o = /\r?\n/g, a = {};
    a.fileapi = void 0 !== t('<input type="file">').get(0).files, a.formdata = "undefined" != typeof window.FormData;
    var s = !!t.fn.prop;
    t.fn.attr2 = function () {
        if (!s) return this.attr.apply(this, arguments);
        var t = this.prop.apply(this, arguments);
        return t && t.jquery || "string" == typeof t ? t : this.attr.apply(this, arguments)
    }, t.fn.ajaxSubmit = function (e, i, o, r) {
        function l(i) {
            var n, o, a = t.param(i, e.traditional).split("&"), s = a.length, r = [];
            for (n = 0; n < s; n++) a[n] = a[n].replace(/\+/g, " "), o = a[n].split("="), r.push([decodeURIComponent(o[0]), decodeURIComponent(o[1])]);
            return r
        }

        function c(i) {
            for (var n = new FormData, o = 0; o < i.length; o++) n.append(i[o].name, i[o].value);
            if (e.extraData) {
                var a = l(e.extraData);
                for (o = 0; o < a.length; o++) a[o] && n.append(a[o][0], a[o][1])
            }
            e.data = null;
            var s = t.extend(!0, {}, t.ajaxSettings, e, {
                contentType: !1,
                processData: !1,
                cache: !1,
                type: d || "POST"
            });
            e.uploadProgress && (s.xhr = function () {
                var i = t.ajaxSettings.xhr();
                return i.upload && i.upload.addEventListener("progress", function (t) {
                    var i = 0, n = t.loaded || t.position, o = t.total;
                    t.lengthComputable && (i = Math.ceil(n / o * 100)), e.uploadProgress(t, n, o, i)
                }, !1), i
            }), s.data = null;
            var r = s.beforeSend;
            return s.beforeSend = function (t, i) {
                e.formData ? i.data = e.formData : i.data = n, r && r.call(this, t, i)
            }, t.ajax(s)
        }

        function h(i) {
            function o(t) {
                var e = null;
                try {
                    t.contentWindow && (e = t.contentWindow.document)
                } catch (i) {
                    n("cannot get iframe.contentWindow document: " + i)
                }
                if (e) return e;
                try {
                    e = t.contentDocument ? t.contentDocument : t.document
                } catch (i) {
                    n("cannot get iframe.contentDocument: " + i), e = t.document
                }
                return e
            }

            function a() {
                function e() {
                    try {
                        var t = o(m).readyState;
                        n("state = " + t), t && "uninitialized" === t.toLowerCase() && setTimeout(e, 50)
                    } catch (i) {
                        n("Server abort: ", i, " (", i.name, ")"), r(M), C && clearTimeout(C), C = void 0
                    }
                }

                var i = f.attr2("target"), a = f.attr2("action"), s = "multipart/form-data",
                    l = f.attr("enctype") || f.attr("encoding") || s;
                _.setAttribute("target", p), d && !/post/i.test(d) || _.setAttribute("method", "POST"), a !== h.url && _.setAttribute("action", h.url), h.skipEncodingOverride || d && !/post/i.test(d) || f.attr({
                    encoding: "multipart/form-data",
                    enctype: "multipart/form-data"
                }), h.timeout && (C = setTimeout(function () {
                    x = !0, r(D)
                }, h.timeout));
                var c = [];
                try {
                    if (h.extraData) for (var u in h.extraData) h.extraData.hasOwnProperty(u) && (t.isPlainObject(h.extraData[u]) && h.extraData[u].hasOwnProperty("name") && h.extraData[u].hasOwnProperty("value") ? c.push(t('<input type="hidden" name="' + h.extraData[u].name + '">', T).val(h.extraData[u].value).appendTo(_)[0]) : c.push(t('<input type="hidden" name="' + u + '">', T).val(h.extraData[u]).appendTo(_)[0]));
                    h.iframeTarget || g.appendTo(S), m.attachEvent ? m.attachEvent("onload", r) : m.addEventListener("load", r, !1), setTimeout(e, 15);
                    try {
                        _.submit()
                    } catch (v) {
                        var y = document.createElement("form").submit;
                        y.apply(_)
                    }
                } finally {
                    _.setAttribute("action", a), _.setAttribute("enctype", l), i ? _.setAttribute("target", i) : f.removeAttr("target"), t.each(c, function () {
                        this.remove()
                    })
                }
            }

            function r(e) {
                if (!v.aborted && !I) {
                    if ($ = o(m), $ || (n("cannot access response document"), e = M), e === D && v) return v.abort("timeout"), void k.reject(v, "timeout");
                    if (e === M && v) return v.abort("server abort"), void k.reject(v, "error", "server abort");
                    if ($ && $.location.href !== h.iframeSrc || x) {
                        m.detachEvent ? m.detachEvent("onload", r) : m.removeEventListener("load", r, !1);
                        var i, a = "success";
                        try {
                            if (x) throw"timeout";
                            var s = "xml" === h.dataType || $.XMLDocument || t.isXMLDoc($);
                            if (n("isXml=" + s), !s && window.opera && (null === $.body || !$.body.innerHTML) && --F) return n("requeing onLoad callback, DOM not available"), void setTimeout(r, 250);
                            var l = $.body ? $.body : $.documentElement;
                            v.responseText = l ? l.innerHTML : null, v.responseXML = $.XMLDocument ? $.XMLDocument : $, s && (h.dataType = "xml"), v.getResponseHeader = function (t) {
                                var e = {"content-type": h.dataType};
                                return e[t.toLowerCase()]
                            }, l && (v.status = Number(l.getAttribute("status")) || v.status, v.statusText = l.getAttribute("statusText") || v.statusText);
                            var c = (h.dataType || "").toLowerCase(), d = /(json|script|text)/.test(c);
                            if (d || h.textarea) {
                                var p = $.getElementsByTagName("textarea")[0];
                                if (p) v.responseText = p.value, v.status = Number(p.getAttribute("status")) || v.status, v.statusText = p.getAttribute("statusText") || v.statusText; else if (d) {
                                    var f = $.getElementsByTagName("pre")[0], y = $.getElementsByTagName("body")[0];
                                    f ? v.responseText = f.textContent ? f.textContent : f.innerText : y && (v.responseText = y.textContent ? y.textContent : y.innerText)
                                }
                            } else "xml" === c && !v.responseXML && v.responseText && (v.responseXML = A(v.responseText));
                            try {
                                P = O(v, c, h)
                            } catch (b) {
                                a = "parsererror", v.error = i = b || a
                            }
                        } catch (b) {
                            n("error caught: ", b), a = "error", v.error = i = b || a
                        }
                        v.aborted && (n("upload aborted"), a = null), v.status && (a = v.status >= 200 && v.status < 300 || 304 === v.status ? "success" : "error"), "success" === a ? (h.success && h.success.call(h.context, P, "success", v), k.resolve(v.responseText, "success", v), u && t.event.trigger("ajaxSuccess", [v, h])) : a && ("undefined" == typeof i && (i = v.statusText), h.error && h.error.call(h.context, v, a, i), k.reject(v, "error", i), u && t.event.trigger("ajaxError", [v, h, i])), u && t.event.trigger("ajaxComplete", [v, h]), u && !--t.active && t.event.trigger("ajaxStop"), h.complete && h.complete.call(h.context, v, a), I = !0, h.timeout && clearTimeout(C), setTimeout(function () {
                            h.iframeTarget ? g.attr("src", h.iframeSrc) : g.remove(), v.responseXML = null
                        }, 100)
                    }
                }
            }

            var l, c, h, u, p, g, m, v, b, w, x, C, _ = f[0], k = t.Deferred();
            if (k.abort = function (t) {
                v.abort(t)
            }, i) for (c = 0; c < y.length; c++) l = t(y[c]), s ? l.prop("disabled", !1) : l.removeAttr("disabled");
            h = t.extend(!0, {}, t.ajaxSettings, e), h.context = h.context || h, p = "jqFormIO" + (new Date).getTime();
            var T = _.ownerDocument, S = f.closest("body");
            if (h.iframeTarget ? (g = t(h.iframeTarget, T), w = g.attr2("name"), w ? p = w : g.attr2("name", p)) : (g = t('<iframe name="' + p + '" src="' + h.iframeSrc + '" />', T), g.css({
                position: "absolute",
                top: "-1000px",
                left: "-1000px"
            })), m = g[0], v = {
                aborted: 0,
                responseText: null,
                responseXML: null,
                status: 0,
                statusText: "n/a",
                getAllResponseHeaders: function () {
                },
                getResponseHeader: function () {
                },
                setRequestHeader: function () {
                },
                abort: function (e) {
                    var i = "timeout" === e ? "timeout" : "aborted";
                    n("aborting upload... " + i), this.aborted = 1;
                    try {
                        m.contentWindow.document.execCommand && m.contentWindow.document.execCommand("Stop")
                    } catch (o) {
                    }
                    g.attr("src", h.iframeSrc), v.error = i, h.error && h.error.call(h.context, v, i, e), u && t.event.trigger("ajaxError", [v, h, i]), h.complete && h.complete.call(h.context, v, i)
                }
            }, u = h.global, u && 0 === t.active++ && t.event.trigger("ajaxStart"), u && t.event.trigger("ajaxSend", [v, h]), h.beforeSend && h.beforeSend.call(h.context, v, h) === !1) return h.global && t.active--, k.reject(), k;
            if (v.aborted) return k.reject(), k;
            b = _.clk, b && (w = b.name, w && !b.disabled && (h.extraData = h.extraData || {}, h.extraData[w] = b.value, "image" === b.type && (h.extraData[w + ".x"] = _.clk_x, h.extraData[w + ".y"] = _.clk_y)));
            var D = 1, M = 2, L = t("meta[name=csrf-token]").attr("content"),
                z = t("meta[name=csrf-param]").attr("content");
            z && L && (h.extraData = h.extraData || {}, h.extraData[z] = L), h.forceSync ? a() : setTimeout(a, 10);
            var P, $, I, F = 50, A = t.parseXML || function (t, e) {
                return window.ActiveXObject ? (e = new ActiveXObject("Microsoft.XMLDOM"), e.async = "false", e.loadXML(t)) : e = (new DOMParser).parseFromString(t, "text/xml"), e && e.documentElement && "parsererror" !== e.documentElement.nodeName ? e : null
            }, E = t.parseJSON || function (t) {
                return window.eval("(" + t + ")")
            }, O = function (e, i, n) {
                var o = e.getResponseHeader("content-type") || "", a = ("xml" === i || !i) && o.indexOf("xml") >= 0,
                    s = a ? e.responseXML : e.responseText;
                return a && "parsererror" === s.documentElement.nodeName && t.error && t.error("parsererror"), n && n.dataFilter && (s = n.dataFilter(s, i)), "string" == typeof s && (("json" === i || !i) && o.indexOf("json") >= 0 ? s = E(s) : ("script" === i || !i) && o.indexOf("javascript") >= 0 && t.globalEval(s)), s
            };
            return k
        }

        if (!this.length) return n("ajaxSubmit: skipping submit process - no element selected"), this;
        var d, u, p, f = this;
        "function" == typeof e ? e = {success: e} : "string" == typeof e || e === !1 && arguments.length > 0 ? (e = {
            url: e,
            data: i,
            dataType: o
        }, "function" == typeof r && (e.success = r)) : "undefined" == typeof e && (e = {}), d = e.method || e.type || this.attr2("method"), u = e.url || this.attr2("action"), p = "string" == typeof u ? t.trim(u) : "", p = p || window.location.href || "", p && (p = (p.match(/^([^#]+)/) || [])[1]), e = t.extend(!0, {
            url: p,
            success: t.ajaxSettings.success,
            type: d || t.ajaxSettings.type,
            iframeSrc: /^https/i.test(window.location.href || "") ? "javascript:false" : "about:blank"
        }, e);
        var g = {};
        if (this.trigger("form-pre-serialize", [this, e, g]), g.veto) return n("ajaxSubmit: submit vetoed via form-pre-serialize trigger"), this;
        if (e.beforeSerialize && e.beforeSerialize(this, e) === !1) return n("ajaxSubmit: submit aborted via beforeSerialize callback"), this;
        var m = e.traditional;
        "undefined" == typeof m && (m = t.ajaxSettings.traditional);
        var v, y = [], b = this.formToArray(e.semantic, y, e.filtering);
        if (e.data) {
            var w = "function" == typeof e.data ? e.data(b) : e.data;
            e.extraData = w, v = t.param(w, m)
        }
        if (e.beforeSubmit && e.beforeSubmit(b, this, e) === !1) return n("ajaxSubmit: submit aborted via beforeSubmit callback"), this;
        if (this.trigger("form-submit-validate", [b, this, e, g]), g.veto) return n("ajaxSubmit: submit vetoed via form-submit-validate trigger"), this;
        var x = t.param(b, m);
        v && (x = x ? x + "&" + v : v), "GET" === e.type.toUpperCase() ? (e.url += (e.url.indexOf("?") >= 0 ? "&" : "?") + x, e.data = null) : e.data = x;
        var C = [];
        if (e.resetForm && C.push(function () {
            f.resetForm()
        }), e.clearForm && C.push(function () {
            f.clearForm(e.includeHidden)
        }), !e.dataType && e.target) {
            var _ = e.success || function () {
            };
            C.push(function (i, n, o) {
                var a = arguments, s = e.replaceTarget ? "replaceWith" : "html";
                t(e.target)[s](i).each(function () {
                    _.apply(this, a)
                })
            })
        } else e.success && (Array.isArray(e.success) ? t.merge(C, e.success) : C.push(e.success));
        if (e.success = function (t, i, n) {
            for (var o = e.context || this, a = 0, s = C.length; a < s; a++) C[a].apply(o, [t, i, n || f, f])
        }, e.error) {
            var k = e.error;
            e.error = function (t, i, n) {
                var o = e.context || this;
                k.apply(o, [t, i, n, f])
            }
        }
        if (e.complete) {
            var T = e.complete;
            e.complete = function (t, i) {
                var n = e.context || this;
                T.apply(n, [t, i, f])
            }
        }
        var S = t("input[type=file]:enabled", this).filter(function () {
                return "" !== t(this).val()
            }), D = S.length > 0, M = "multipart/form-data", L = f.attr("enctype") === M || f.attr("encoding") === M,
            z = a.fileapi && a.formdata;
        n("fileAPI :" + z);
        var P, $ = (D || L) && !z;
        e.iframe !== !1 && (e.iframe || $) ? e.closeKeepAlive ? t.get(e.closeKeepAlive, function () {
            P = h(b)
        }) : P = h(b) : P = (D || L) && z ? c(b) : t.ajax(e), f.removeData("jqxhr").data("jqxhr", P);
        for (var I = 0; I < y.length; I++) y[I] = null;
        return this.trigger("form-submit-notify", [this, e]), this
    }, t.fn.ajaxForm = function (o, a, s, r) {
        if (("string" == typeof o || o === !1 && arguments.length > 0) && (o = {
            url: o,
            data: a,
            dataType: s
        }, "function" == typeof r && (o.success = r)), o = o || {}, o.delegation = o.delegation && "function" == typeof t.fn.on, !o.delegation && 0 === this.length) {
            var l = {s: this.selector, c: this.context};
            return !t.isReady && l.s ? (n("DOM not ready, queuing ajaxForm"), t(function () {
                t(l.s, l.c).ajaxForm(o)
            }), this) : (n("terminating; zero elements found by selector" + (t.isReady ? "" : " (DOM not ready)")), this)
        }
        return o.delegation ? (t(document).off("submit.form-plugin", this.selector, e).off("click.form-plugin", this.selector, i).on("submit.form-plugin", this.selector, o, e).on("click.form-plugin", this.selector, o, i), this) : this.ajaxFormUnbind().on("submit.form-plugin", o, e).on("click.form-plugin", o, i)
    }, t.fn.ajaxFormUnbind = function () {
        return this.off("submit.form-plugin click.form-plugin")
    }, t.fn.formToArray = function (e, i, n) {
        var o = [];
        if (0 === this.length) return o;
        var s, r = this[0], l = this.attr("id"),
            c = e || "undefined" == typeof r.elements ? r.getElementsByTagName("*") : r.elements;
        if (c && (c = t.makeArray(c)), l && (e || /(Edge|Trident)\//.test(navigator.userAgent)) && (s = t(':input[form="' + l + '"]').get(), s.length && (c = (c || []).concat(s))), !c || !c.length) return o;
        "function" == typeof n && (c = t.map(c, n));
        var h, d, u, p, f, g, m;
        for (h = 0, g = c.length; h < g; h++) if (f = c[h], u = f.name, u && !f.disabled) if (e && r.clk && "image" === f.type) r.clk === f && (o.push({
            name: u,
            value: t(f).val(),
            type: f.type
        }), o.push({name: u + ".x", value: r.clk_x}, {
            name: u + ".y",
            value: r.clk_y
        })); else if (p = t.fieldValue(f, !0), p && p.constructor === Array) for (i && i.push(f), d = 0, m = p.length; d < m; d++) o.push({
            name: u,
            value: p[d]
        }); else if (a.fileapi && "file" === f.type) {
            i && i.push(f);
            var v = f.files;
            if (v.length) for (d = 0; d < v.length; d++) o.push({
                name: u,
                value: v[d],
                type: f.type
            }); else o.push({name: u, value: "", type: f.type})
        } else null !== p && "undefined" != typeof p && (i && i.push(f), o.push({
            name: u,
            value: p,
            type: f.type,
            required: f.required
        }));
        if (!e && r.clk) {
            var y = t(r.clk), b = y[0];
            u = b.name, u && !b.disabled && "image" === b.type && (o.push({
                name: u,
                value: y.val()
            }), o.push({name: u + ".x", value: r.clk_x}, {name: u + ".y", value: r.clk_y}))
        }
        return o
    }, t.fn.formSerialize = function (e) {
        return t.param(this.formToArray(e))
    }, t.fn.fieldSerialize = function (e) {
        var i = [];
        return this.each(function () {
            var n = this.name;
            if (n) {
                var o = t.fieldValue(this, e);
                if (o && o.constructor === Array) for (var a = 0, s = o.length; a < s; a++) i.push({
                    name: n,
                    value: o[a]
                }); else null !== o && "undefined" != typeof o && i.push({name: this.name, value: o})
            }
        }), t.param(i)
    }, t.fn.fieldValue = function (e) {
        for (var i = [], n = 0, o = this.length; n < o; n++) {
            var a = this[n], s = t.fieldValue(a, e);
            null === s || "undefined" == typeof s || s.constructor === Array && !s.length || (s.constructor === Array ? t.merge(i, s) : i.push(s))
        }
        return i
    }, t.fieldValue = function (e, i) {
        var n = e.name, a = e.type, s = e.tagName.toLowerCase();
        if ("undefined" == typeof i && (i = !0), i && (!n || e.disabled || "reset" === a || "button" === a || ("checkbox" === a || "radio" === a) && !e.checked || ("submit" === a || "image" === a) && e.form && e.form.clk !== e || "select" === s && e.selectedIndex === -1)) return null;
        if ("select" === s) {
            var r = e.selectedIndex;
            if (r < 0) return null;
            for (var l = [], c = e.options, h = "select-one" === a, d = h ? r + 1 : c.length, u = h ? r : 0; u < d; u++) {
                var p = c[u];
                if (p.selected && !p.disabled) {
                    var f = p.value;
                    if (f || (f = p.attributes && p.attributes.value && !p.attributes.value.specified ? p.text : p.value), h) return f;
                    l.push(f)
                }
            }
            return l
        }
        return t(e).val().replace(o, "\r\n")
    }, t.fn.clearForm = function (e) {
        return this.each(function () {
            t("input,select,textarea", this).clearFields(e)
        })
    }, t.fn.clearFields = t.fn.clearInputs = function (e) {
        var i = /^(?:color|date|datetime|email|month|number|password|range|search|tel|text|time|url|week)$/i;
        return this.each(function () {
            var n = this.type, o = this.tagName.toLowerCase();
            i.test(n) || "textarea" === o ? this.value = "" : "checkbox" === n || "radio" === n ? this.checked = !1 : "select" === o ? this.selectedIndex = -1 : "file" === n ? /MSIE/.test(navigator.userAgent) ? t(this).replaceWith(t(this).clone(!0)) : t(this).val("") : e && (e === !0 && /hidden/.test(n) || "string" == typeof e && t(this).is(e)) && (this.value = "")
        })
    }, t.fn.resetForm = function () {
        return this.each(function () {
            var e = t(this), i = this.tagName.toLowerCase();
            switch (i) {
                case"input":
                    this.checked = this.defaultChecked;
                case"textarea":
                    return this.value = this.defaultValue, !0;
                case"option":
                case"optgroup":
                    var n = e.parents("select");
                    return n.length && n[0].multiple ? "option" === i ? this.selected = this.defaultSelected : e.find("option").resetForm() : n.resetForm(), !0;
                case"select":
                    return e.find("option").each(function (t) {
                        if (this.selected = this.defaultSelected, this.defaultSelected && !e[0].multiple) return e[0].selectedIndex = t, !1
                    }), !0;
                case"label":
                    var o = t(e.attr("for")), a = e.find("input,select,textarea");
                    return o[0] && a.unshift(o[0]), a.resetForm(), !0;
                case"form":
                    return ("function" == typeof this.reset || "object" == typeof this.reset && !this.reset.nodeType) && this.reset(), !0;
                default:
                    return e.find("form,input,label,select,textarea").resetForm(), !0
            }
        })
    }, t.fn.enable = function (t) {
        return "undefined" == typeof t && (t = !0), this.each(function () {
            this.disabled = !t
        })
    }, t.fn.selected = function (e) {
        return "undefined" == typeof e && (e = !0), this.each(function () {
            var i = this.type;
            if ("checkbox" === i || "radio" === i) this.checked = e; else if ("option" === this.tagName.toLowerCase()) {
                var n = t(this).parent("select");
                e && n[0] && "select-one" === n[0].type && n.find("option").selected(!1), this.selected = e
            }
        })
    }, t.fn.ajaxSubmit.debug = !1
}), function (t) {
    function e(e) {
        if ("string" == typeof e.data) {
            var i = e.handler, n = e.data.toLowerCase().split(" ");
            e.handler = function (e) {
                if (this === e.target || !/textarea|select/i.test(e.target.nodeName) && "text" !== e.target.type) {
                    var o = "keypress" !== e.type && t.hotkeys.specialKeys[e.which],
                        a = String.fromCharCode(e.which).toLowerCase(), s = "", r = {};
                    e.altKey && "alt" !== o && (s += "alt+"), e.ctrlKey && "ctrl" !== o && (s += "ctrl+"), e.metaKey && !e.ctrlKey && "meta" !== o && (s += "meta+"), e.shiftKey && "shift" !== o && (s += "shift+"), o ? r[s + o] = !0 : (r[s + a] = !0, r[s + t.hotkeys.shiftNums[a]] = !0, "shift+" === s && (r[t.hotkeys.shiftNums[a]] = !0));
                    for (var l = 0, c = n.length; l < c; l++) if (r[n[l]]) return i.apply(this, arguments)
                }
            }
        }
    }

    t.hotkeys = {
        version: "0.8",
        specialKeys: {
            8: "backspace",
            9: "tab",
            13: "return",
            16: "shift",
            17: "ctrl",
            18: "alt",
            19: "pause",
            20: "capslock",
            27: "esc",
            32: "space",
            33: "pageup",
            34: "pagedown",
            35: "end",
            36: "home",
            37: "left",
            38: "up",
            39: "right",
            40: "down",
            45: "insert",
            46: "del",
            96: "0",
            97: "1",
            98: "2",
            99: "3",
            100: "4",
            101: "5",
            102: "6",
            103: "7",
            104: "8",
            105: "9",
            106: "*",
            107: "+",
            109: "-",
            110: ".",
            111: "/",
            112: "f1",
            113: "f2",
            114: "f3",
            115: "f4",
            116: "f5",
            117: "f6",
            118: "f7",
            119: "f8",
            120: "f9",
            121: "f10",
            122: "f11",
            123: "f12",
            144: "numlock",
            145: "scroll",
            191: "/",
            224: "meta"
        },
        shiftNums: {
            "`": "~",
            1: "!",
            2: "@",
            3: "#",
            4: "$",
            5: "%",
            6: "^",
            7: "&",
            8: "*",
            9: "(",
            0: ")",
            "-": "_",
            "=": "+",
            ";": ": ",
            "'": '"',
            ",": "<",
            ".": ">",
            "/": "?",
            "\\": "|"
        }
    }, t.each(["keydown", "keyup", "keypress"], function () {
        t.event.special[this] = {add: e}
    })
}(jQuery), function (t, e, i) {
    "use strict";
    var n = "zui.picker", o = {}, a = {
        lang: null,
        remote: null,
        remoteConverter: null,
        remoteOnly: !1,
        onRemoteError: null,
        disableEmptySearch: !1,
        textKey: "text",
        valueKey: "value",
        keysKey: "keys",
        multi: "auto",
        formItem: "auto",
        list: null,
        allowSingleDeselect: null,
        autoSelectFirst: !1,
        maxSelectedCount: 0,
        maxListCount: 100,
        hideEmptyTextOption: !0,
        searchValueKey: !0,
        emptyResultHint: null,
        hideOnScroll: !0,
        inheritFormItemClasses: !1,
        emptySearchResultHint: null,
        accurateSearchHint: null,
        remoteErrorHint: null,
        deleteByBackspace: !0,
        disableScrollOnShow: !0,
        maxDropHeight: 250,
        dropDirection: "auto",
        dropWidth: "100%",
        maxAutoDropWidth: 450,
        minAutoDropWidth: 100,
        multiValueSplitter: ",",
        multiSelectActions: 5,
        searchDelay: 200,
        autoClearDrop: 6e4,
        fixLabelFor: !0,
        hotkey: !0,
        onSelect: null,
        onDeselect: null,
        onBeforeChange: null,
        onChange: null,
        onReady: null,
        onNoResults: null,
        onShowingDrop: null,
        onHidingDrop: null,
        onShowedDrop: null,
        onHiddenDrop: null,
        valueMustInList: !0
    }, s = {
        zh_cn: {
            emptyResultHint: "没有可选项",
            emptySearchResultHint: "没有找到 “{0}”",
            accurateSearchHint: "请提供更多关键词缩小匹配范围",
            remoteErrorHint: "无法从服务器获取结果 - {0}",
            selectAll: "全选",
            deselectAll: "取消选择"
        },
        zh_tw: {
            emptyResultHint: "沒有可選項",
            emptySearchResultHint: "沒有找到 “{0}”",
            accurateSearchHint: "請提供更多關鍵詞縮小匹配範圍",
            remoteErrorHint: "無法從服務器獲取結果 - {0}",
            selectAll: "全選",
            deselectAll: "取消選擇"
        },
        en: {
            emptyResultHint: "No options",
            emptySearchResultHint: 'Cannot found "{0}"',
            accurateSearchHint: "Suggest to provide more keywords",
            remoteErrorHint: "Unable to get result from server: {0}",
            selectAll: "Select all",
            deselectAll: "Deselect all"
        }
    }, r = function (o, a) {
        var l = this;
        l.name = n, l.$ = t(o), l.id = "pk_" + (l.$.attr("id") || t.zui.uuid()), a = l.options = t.extend({}, r.DEFAULTS, this.$.data(), a), void 0 !== a.hideOnWindowScroll && (a.hideOnScroll = a.hideOnWindowScroll);
        var c = t.zui.clientLang ? t.zui.clientLang() : "en", h = a.lang || c;
        l.lang = t.zui.getLangData ? t.zui.getLangData(n, h, s) : s[h] || s[c];
        var d, u, p = a.formItem, f = '.form-item,input[type="hidden"],select,input[type="text"]';
        if (d = "self" === p ? l.$ : "auto" !== p && p ? l.$.find(p) : l.$.is(f) ? l.$ : l.$.find(f).first(), !d.length) return console.error && console.error("Cannot found form item for picker.");
        if (d.is('input[type="hidden"]')) u = "hidden"; else if (d.is("select")) u = "select"; else {
            if (!d.is('input[type="text"]')) return console.error && console.error("Unknown form type for picker.");
            u = "text"
        }
        a.inheritFormItemClasses && v.addClass(d.attr("class")), l.formType = u, l.$formItem = d.removeClass("picker").hide(), l.selfFormItem = d.is(l.$);
        var g = a.multi;
        g && "auto" !== g || (g = "select" === u && "multiple" === d.attr("multiple")), g = !!g, l.multi = g, g || (l.options.checkable = !1);
        var m = a.list;
        m ? l.setList("function" == typeof m ? m({
            search: l.search,
            limit: a.maxListCount
        }) : m, !0) : "select" === u ? l.updateFromSelect() : l.setList([], !0);
        var v;
        v = !l.selfFormItem && l.$.hasClass("picker") ? l.$ : t('<div class="picker" />').insertAfter(l.$), v.addClass("picker").toggleClass("picker-multi", g).toggleClass("picker-single", !g);
        var y = v.children(".picker-selections");
        y.length ? y.empty() : y = t('<div class="picker-selections" />');
        var b = l.id + "-search",
            w = t('<input autocomplete="off" id="' + b + '" type="text" class="picker-search">').appendTo(y);
        if (!g) {
            var x = t('<div class="picker-selection picker-selection-single"><span class="picker-selection-text"></span></div>');
            a.allowSingleDeselect && x.append('<span class="picker-selection-remove"></span>'), x.appendTo(y), l.$singleSelection = x
        }
        v.toggleClass("picker-input-empty", !w.val().length).append(y), l.$container = v, l.$selections = y, l.$search = w, l.search = "";
        var C = a.placeholder;
        if (void 0 === C && (C = d.attr("placeholder")), "string" == typeof C && C.length && y.append(t('<div class="picker-placeholder" />').text(C)), a.placeholder = C, a.fixLabelFor) {
            var _ = d.attr("id");
            _ && t('label[for="' + _ + '"]').attr("for", b)
        }
        var k = void 0 !== a.defaultValue ? a.defaultValue : d.val();
        if (null === k && (k = ""), l.setValue(k, !0), l.setDisabled(), w.on("focus", function () {
            l.disabled || (l._blurTimer && (clearTimeout(l._blurTimer), l._blurTimer = 0), v.addClass("picker-focus"), l.options.disableEmptySearch && "string" == typeof l.search && !l.search.length || l.showDropList())
        }).on("blur", function () {
            l.disabled || (l._blurTimer && clearTimeout(l._blurTimer), l._blurTimer = setTimeout(function () {
                l._blurTimer = 0, w.is(":focus") || v.removeClass("picker-focus")
            }, 100))
        }).on("input change", function () {
            if (!l.disabled) {
                var t = w.val();
                if (g && w.width(14 * t.length), v.toggleClass("picker-input-empty", !t.length), l.tryUpdateList(t), a.disableEmptySearch) {
                    const e = "string" != typeof t || t.length;
                    !l.dropListShowed && e ? l.showDropList() : l.dropListShowed && !e && l.hideDropList()
                }
            }
        }), a.hotkey && w.on("keydown", function (t) {
            if (!l.disabled) {
                var e = t.key || t.which;
                if (l.dropListShowed) {
                    var i = l.activeValue, n = "string" == typeof i;
                    if ("Enter" === e || 13 === e) n && (l.select(i, g), g ? (l.$search.val(""), l.tryUpdateList("")) : w.blur(), t.preventDefault(), t.stopPropagation()); else if ("ArrowDown" === e || 40 === e) {
                        var o, s = l.$activeOption;
                        if (s && (o = s.next(".picker-option"), g)) for (; o.length && o.hasClass("picker-option-selected");) o = o.next(".picker-option");
                        o && o.length || (o = l.$optionsList.children(g ? ".picker-option:not(.picker-option-selected)" : ".picker-option").first()), o.length && l.activeOption(o), t.preventDefault(), t.stopPropagation()
                    } else if ("ArrowUp" === e || 30 === e) {
                        var r, s = l.$activeOption;
                        if (s && (r = s.prev(".picker-option"), g)) for (; r.length && r.hasClass("picker-option-selected");) r = r.prev(".picker-option");
                        r && r.length || (r = l.$optionsList.children(g ? ".picker-option:not(.picker-option-selected)" : ".picker-option").last()), r.length && l.activeOption(r), t.preventDefault(), t.stopPropagation()
                    } else "Escape" === e || 27 === e ? l.hideDropList(!0) : a.deleteByBackspace && g && ("Backspace" === e || 8 === e) && l.value && l.value.length && !w.val().length && l.deselect(l.value[l.value.length - 1])
                }
            }
        }), g) {
            y.on("mousedown", function (t) {
                if (!l.disabled) return l.dropListShowed && !a.checkable ? (t.preventDefault(), void t.stopPropagation()) : void 0
            }).on("mouseup", function (e) {
                l.disabled || y.hasClass("sortable-sorting") || t(e.target).closest(".picker-selection-remove").length || l.dropListShowed && !a.checkable || l.focus()
            });
            var T = a.sortValuesByDnd;
            if (T && t.fn.sortable) {
                v.addClass("picker-sortable");
                var S = {
                    selector: ".picker-selection", stopPropagation: !0, start: function () {
                        l.hideDropList(!0)
                    }, finish: function (e) {
                        var i = [];
                        t.each(e.list, function (t, e) {
                            i.push(e.item.data("value"))
                        }), l.setValue(i.slice(), !1, !0)
                    }
                };
                "object" == typeof T && t.extend(S, T), y.sortable(S)
            }
        }
        if (y.on("click", ".picker-selection-remove", function (e) {
            if (!l.disabled) {
                if (l.multi) {
                    var i = t(this).closest(".picker-selection");
                    l.deselect(i.data("value"))
                } else l.deselect();
                e.stopPropagation()
            }
        }), d.on("chosen:updated", function () {
            l.updateFromSelect(!1), l.setValue(d.val(), !0), l.setDisabled(), l.updateList()
        }).on("chosen:activate", l.focus).on("chosen:open", l.showDropList).on("chosen:close", l.hideDropList), v.addClass("picker-ready"), t.zui.asap(function () {
            l.triggerEvent("ready", {picker: l}, "", "chosen:ready")
        }), !a.disableScrollOnShow) {
            var D = a.hideOnScroll;
            D && ![e, i, !0].includes(D) && t(D).on("scroll", this.handleParentScroll.bind(this))
        }
    };
    r.prototype.destroy = function () {
        var e = this, i = e.options;
        e.hideDropList(!0);
        var o = e.$search;
        o.off("focus blur input change"), i.hotkey && o.off("keydown"), o.remove();
        var a = e.$selections;
        a.off("click"), e.multi && a.off("mousedown mouseup"), a.remove();
        var s = e.$formItem;
        e.selectOptionsBackup && (s.empty(), t.each(e.selectOptionsBackup, function (e, n) {
            var o = {value: n[i.valueKey]}, a = n[i.keysKey];
            void 0 !== a && (o["data-" + i.keysKey] = a), s.append(t("<option />").attr(o).text(n[i.textKey]))
        })), s.off("chosen:updated chosen:activate chosen:open chosen:close").val(e.value).show(), !e.selfFormItem && e.$.hasClass("picker") || e.$container.remove(), this.destroyDropList(0), e.$.data(n, null)
    }, r.prototype.focus = function () {
        this.$search.focus()
    }, r.prototype.select = function (t, e) {
        var i = this;
        if (i.$search.val() && i.$search.val(""), !i.isSelectedValue(t)) {
            if (i.triggerEvent("select", {value: t, picker: i}) === !1) return;
            if (i.multi) {
                var n = i.value;
                n = n ? n.slice() : [], n.push(t), i.setValue(n)
            } else i.setValue(t)
        }
        e || i.hideDropList()
    }, r.prototype.deselect = function (t) {
        var e = this;
        if (e.multi) {
            if (!e.isSelectedValue(t)) return;
            if (e.triggerEvent("deselect", {value: t, picker: e}) === !1) return;
            var i = e.value;
            if (i && i.length) for (var n = 0; n < i.length; ++n) if (i[n] === t) {
                i = i.slice(), i.splice(n, 1), e.setValue(i);
                break
            }
        } else e.setValue("")
    }, r.prototype.selectAll = function (t) {
        var e = this;
        if (e.multi && !e.options.remote) {
            for (var i = [], n = 0; n < e.list.length; ++n) {
                var o = e.list[n];
                if (!o.disabled) {
                    var a = o[e.options.valueKey];
                    i.push(a)
                }
            }
            e.setValue(i), t || e.hideDropList()
        }
    }, r.prototype.deselectAll = function (t) {
        var e = this;
        e.multi && !e.options.remote && (e.setValue([]), t || e.hideDropList())
    }, r.prototype.updateMessage = function (t, e, i) {
        var n = this, o = n.$message, a = "string" == typeof t && t.length;
        t = a ? t : "", n.hasMessage = a, o.attr("title", t).text(t).attr("data-type", e), n.$dropMenu.toggleClass("picker-has-message", !!a), i || "top" !== n.dropDirection || n.layoutDropList()
    }, r.prototype.getRemoteList = function (e, i) {
        var n = this, o = n.options.remote;
        if (o) {
            var a = n.options, s = n.search;
            if ("string" == typeof s && !s.length && a.disableEmptySearch) return n.setList([]), void e(!1);
            var r, l = {search: s, limit: a.maxListCount};
            if (r = "string" == typeof o ? {url: o} : "function" == typeof o ? o(l, n) : o, !r.url) return void console.warn("Remote url must provide to get remote list in picker.");
            var c = !1;
            r.url.indexOf("{search}") > -1 && (r.url = r.url.replace(/\{search\}/g, s), c = !0), r.url.indexOf("{limit}") > -1 && (r.url = r.url.replace(/\{limit\}/g, a.maxListCount), c = !0), n.updateMessage(""), n.$container.addClass("picker-loading"), n.remoteXhr && n.remoteXhr.abort(), n.remoteXhr = t.ajax(t.extend({
                dataType: "json",
                dataFilter: a.remoteConverter,
                data: c ? null : l
            }, r)).done(function (i, o, s) {
                var r = !1;
                if (i) {
                    if (t.isPlainObject(i)) if ("success" !== i.result && "ok" !== i.result || !Array.isArray(i.data)) if ("fail" === i.result) n.updateMessage(i.message || JSON.stringify(i), "danger"); else {
                        var l = [];
                        t.each(i, function (e, i) {
                            var n = {};
                            n[a.valueKey] = e, "object" == typeof i ? t.extend(n, i) : n[a.textKey] = i, l.push(n)
                        }), i = l
                    } else i = i.data;
                    Array.isArray(i) && (r = i.length, n.setList(i, a.remoteOnly))
                }
                e && e(r)
            }).fail(function (t, e) {
                var o, s = a.onRemoteError;
                o = "function" == typeof s ? s(t, e) : "string" == typeof s ? s : (a.remoteErrorHint || n.lang.remoteErrorHint).format(e || ""), n.updateMessage(o, "danger"), i && i()
            }).always(function () {
                n.remoteXhr = null, n.$container.removeClass("picker-loading")
            })
        }
    }, r.prototype.layoutDropList = function (i, n, o) {
        var a = this;
        if (a.$dropMenu) {
            var s, r = a.options, l = r.maxDropHeight || Number.MAX_VALUE, c = a.$dropMenu, h = a.$optionsList;
            i ? s = h.scrollTop() : c.css({
                opacity: 0,
                width: "auto",
                "max-width": "none"
            }), h.css({"max-height": l}), t.zui.asap(function () {
                var i = a.$selections[0].getBoundingClientRect(),
                    d = n ? r.dropDirection : a.dropDirection || r.dropDirection;
                "function" == typeof d && (d = d(i, a));
                var u = t(e), p = u.height(), f = a.hasMessage ? a.$message.outerHeight() : 0,
                    g = a.showActions ? a.$actions.outerHeight() : 0, m = Math.max(g, f, c.height()),
                    v = r.dropWidth || "auto", y = {left: i.left, opacity: 1, maxWidth: "initial", minWidth: "initial"};
                "auto" === d && (d = i.top + i.height + m > p && i.top > p - i.top - i.height ? "top" : "bottom"), a.dropDirection = d;
                var b = Math.min(l, "bottom" === d ? p - i.top - i.height : i.top);
                if (m = Math.min(m, b), y.top = "bottom" === d ? i.top + i.height : i.top - m, "100%" === v) y.width = i.width; else if ("auto" === v) {
                    var w = r.maxAutoDropWidth, x = r.minAutoDropWidth;
                    if (y.width = "auto", y.maxWidth = "auto" === w ? i.width : w, y.minWidth = "100%" === x ? i.width : x, a.multi) {
                        var C = a.$search[0].getBoundingClientRect();
                        y.left = C.left
                    }
                } else y.width = v;
                var _ = m - f - g;
                h.css("max-height", _), c.css(y), s && h.scrollTop(s), o && o()
            })
        }
    }, r.prototype.tryUpdateList = function (t) {
        var e = this;
        e.search !== t && (e.search = t, e.updateListTimer && clearTimeout(e.updateListTimer), e.updateListTimer = setTimeout(function () {
            e.updateListTimer = null, e.updateList()
        }, e.options.searchDelay))
    }, r.prototype.renderOptionsList = function (e, i) {
        var n = this, o = n.$optionsList;
        if (void 0 === e ? e = n.optionsList : n.optionsList = e, o) {
            var a = "", s = n.options, r = n.search, l = "string" == typeof r && r.length, c = 0;
            if (e.length) {
                for (var h, d, u, p, f = s.maxListCount, g = s.valueKey, m = s.textKey, v = s.checkable || s.showMultiSelectedOptions, y = f ? Math.min(e.length, f) : e.length, b = r.toLowerCase(), w = o.children(".picker-option").addClass("picker-expired"), x = n.activeValue, C = void 0 !== x && null !== x, _ = 0; _ < y; ++_) {
                    var k = e[_], T = k[g], S = n.isSelectedValue(T);
                    if (v || !S || !n.multi) {
                        var D = k[m];
                        if (T.length && (!s.hideEmptyTextOption || D && D.length)) {
                            c++;
                            var M = n.getItemID(k, "option"), L = o.children("#" + M), z = !L.length;
                            z ? (L = t('<a class="picker-option" id="' + M + '" data-value="' + T + '"><span class="picker-option-text"></span><span class="picker-option-keys"></span></a>'), s.checkable && L.prepend('<div class="checkbox-primary"><label></label></div>')) : L.removeClass("picker-expired"), L.attr("title", D).removeClass("picker-option-active").toggleClass("disabled", !!k.disabled).toggleClass("picker-option-selected", S), s.checkable && L.find(".checkbox-primary").toggleClass("checked", S);
                            var P = L.find(".picker-option-text");
                            if (l) {
                                var $ = D.toLowerCase(), I = $.split(b);
                                if (I.length > 1) {
                                    P.empty();
                                    var F = 0, A = I[0].length;
                                    A && (P.append(t("<span>").text(D.substr(F, A))), F += A);
                                    for (var E = 1; E < I.length; ++E) P.append(t('<span class="picker-option-text-matched">').text(D.substr(F, r.length))), F += r.length, A = I[E].length, A && (P.append(t("<span>").text(D.substr(F, A))), F += A)
                                } else P.text(D)
                            } else P.text(D);
                            if (s.optionRender) {
                                var O = s.optionRender(L, k, n);
                                O instanceof t && (L = O)
                            }
                            p ? (z || L.prev(".picker-option")[0] !== p[0]) && L.insertAfter(p) : z && L.prependTo(o), p = L, n.multi ? S || d || (d = k) : !u && C && T === x ? u = k : S ? h = k : d || (d = k)
                        }
                    }
                }
                w.filter(".picker-expired").remove(), !i && y < e.length && (a = s.accurateSearchHint || n.lang.accurateSearchHint), n.options.checkable || n.activeOption(u || h || d)
            } else o.empty();
            c || i || (a = l ? (s.emptySearchResultHint || n.lang.emptySearchResultHint).format(r) : s.emptyResultHint || n.lang.emptyResultHint, l && n.triggerEvent("noResults", {
                search: r,
                picker: n
            }, "", "chosen:no_results"));
            var R = !1;
            if (n.multi && !s.remote) {
                var N = s.multiSelectActions;
                N && ("number" != typeof N && (N = 1), e.length >= N && (R = !0, n.$actions.find('[data-type="select-all"]').attr("disabled", o.children(".picker-option").length ? null : "disabled"), n.$actions.find('[data-type="deselect-all"]').attr("disabled", n.value && n.value.length ? null : "disabled")))
            }
            n.showActions = R, n.$dropMenu.toggleClass("picker-no-actions", !R), i || n.updateMessage(a, "info"), n.$dropMenu.toggleClass("picker-no-options", !c), n.layoutDropList(n.listRendered), n.listRendered = !0
        }
    }, r.prototype.activeOption = function (e, i) {
        var n = this;
        e && (e instanceof t ? e = e.attr("data-value") : "object" == typeof e && (e = e[n.options.valueKey])), n.$optionsList.find(".picker-option-active").removeClass("picker-option-active");
        var o = n.getListItem(e);
        if (o) {
            if (o.disabled) return;
            n.activeValue = e
        } else e = n.activeValue;
        var a = n.$optionsList.find('[data-value="' + e + '"]');
        if (a.length) {
            if (a.addClass("picker-option-active"), !i) {
                var s = a[0];
                s.scrollIntoViewIfNeeded ? s.scrollIntoViewIfNeeded() : s.scrollIntoView && s.scrollIntoView()
            }
            n.$activeOption = a
        } else n.$activeOption = null
    }, r.prototype.updateList = function (t, e, i) {
        var n = this;
        void 0 !== t ? n.search = t : t = n.search;
        var o = n.options.remoteOnly;
        if (o) n.layoutDropList(!1, !0); else {
            var a = [];
            if (null === t || void 0 === t || "string" == typeof t && !t.length) a = n.list || []; else if ("function" == typeof n.options.list) a = n.options.list({
                search: t,
                limit: n.options.maxListCount
            }); else if (n.list && n.list.length) {
                var s = n.options.maxListCount, r = n.options.keysKey, l = n.options.textKey, c = n.options.valueKey,
                    h = n.options.searchValueKey, d = {};
                t = t.toLowerCase();
                for (var u = 0; u < n.list.length; ++u) {
                    var p = n.list[u], f = p[c];
                    if (!n.multi || !n.isSelectedValue(f)) {
                        var g = 0, m = p[l];
                        if (null !== m && void 0 !== m && "" !== m) {
                            m = m.toLowerCase();
                            var v = m.indexOf(t);
                            v > -1 && (g += 0 === v ? 20 : 10)
                        }
                        if (!g) {
                            var y = p[r];
                            if (null !== y && void 0 !== y && "" !== y) {
                                y = y.toLowerCase();
                                var v = y.indexOf(t);
                                v > -1 && (g += 0 === v ? 8 : 4)
                            }
                        }
                        if (!g && h && null !== f && void 0 !== f && "" !== f) {
                            f = f.toLowerCase();
                            var v = f.indexOf(t);
                            v > -1 && (g += 0 === v ? 3 : 1)
                        }
                        if (g && (d[f] = g + (n.list.length - u) / n.list.length, a.push(p)), s && a.length >= s) break
                    }
                }
                a.length && (a = a.sort(function (t, e) {
                    return d[e[c]] - d[t[c]]
                }))
            }
            n.renderOptionsList(a, !1, i)
        }
        e || n.getRemoteList(function (e) {
            o ? n.renderOptionsList(n.list, !1, i) : n.updateList(t, !0)
        }, o ? function () {
            n.renderOptionsList([], !0, i)
        } : null)
    }, r.prototype.destroyDropList = function (t) {
        var e = this;
        e._clearTimer && clearTimeout(e._clearTimer), e.$dropMenu && (t ? e._clearTimer = setTimeout(e.destroyDropList.bind(e, 0), t) : (e.$optionsList.off("click mouseenter"), e.$optionsList = null, e.$dropMenu.remove(), e.$dropMenu = null, e.$message = null))
    }, r.prototype.showDropList = function () {
        var e = this;
        if (e.triggerEvent("showingDrop", {picker: e}) !== !1) {
            if (e._clearTimer && clearTimeout(e._clearTimer), e.dropListShowed = !0, e.dropDirection = null, e.listRendered = !1, e.activeValue = null, o[e.id] = e, e.options.disableScrollOnShow && t.zui.fixBodyScrollbar(), !e.$dropMenu) {
                var i = t('<div class="picker-drop-menu" id="pickerDropMenu-' + e.id + '"></div>').attr("data-id", e.id),
                    a = t('<div class="picker-option-list"></div>').appendTo(i), s = e.options.checkable;
                i.data(n, e).toggleClass("picker-multi", e.multi).toggleClass("picker-single", !e.multi).toggleClass("picker-checkable", !!s).appendTo("body"), e.options.chosenMode && i.addClass("chosen-up"), a.on("click", ".picker-option:not(.disabled)", function () {
                    var i = t(this), n = i.hasClass("picker-option-selected");
                    if (!n || s) {
                        var o = i.attr("data-value");
                        n ? e.deselect(o) : e.select(o, s)
                    }
                }).on("mouseenter", ".picker-option:not(.disabled)", function () {
                    s || e.activeOption(t(this), !0)
                }), e.multi && !e.options.remote && (e.$actions = t(['<div class="picker-actions">', '<button type="button" class="btn btn-sm btn-link picker-action" data-type="select-all">' + e.lang.selectAll + "</button>", '<button type="button" class="btn btn-sm btn-link picker-action" data-type="deselect-all">' + e.lang.deselectAll + "</button>", "</div>"].join("")).appendTo(i), e.$actions.on("click", ".picker-action", function (i) {
                    var n = t(this).data("type");
                    "select-all" === n ? e.selectAll(s) : "deselect-all" === n && e.deselectAll(s)
                })), e.$message = t('<div class="picker-message"></div>').appendTo(i), e.$dropMenu = i, e.$optionsList = a
            }
            e.updateList(e.search, !1, function () {
                e.triggerEvent("showedDrop", {picker: e}, "", "chosen:showing_dropdown")
            }), e.$dropMenu.addClass("picker-drop-show")
        }
    }, r.prototype.hideDropList = function (e) {
        var i = this;
        if (i.triggerEvent("hidingDrop", {picker: i}) !== !1) {
            i.dropListShowed = !1, i.$activeOption = null, i.activeValue = null, i.$search.val(""), i.search = "", delete o[i.id], i.$dropMenu && i.$dropMenu.removeClass("picker-drop-show"), i.options.disableScrollOnShow && t.zui.resetBodyScrollbar(), e && this.$search.blur(), i.triggerEvent("hiddenDrop", {picker: i}, "", "chosen:hiding_dropdown");
            var n = i.options.autoClearDrop;
            n && i.destroyDropList(n)
        }
    }, r.prototype.updateFromSelect = function (e) {
        var i = this, n = i.options, o = [];
        void 0 === e && (e = !0);
        var a = i.$formItem.children("option");
        a.length && (a.each(function () {
            var e = t(this), a = e.val(), s = e.text();
            if (n.onUpdateSelectOption) {
                var r = n.onUpdateSelectOption(e, i);
                r && o.push(r)
            } else if (s.length || a.length) {
                var r = {};
                r[n.valueKey] = a, r[n.textKey] = s, r[n.keysKey] = e.data(n.keysKey), r.disabled = e.attr("disabled"), o.push(r)
            }
            var l = n.allowSingleDeselect;
            "auto" !== l && null !== l && void 0 !== l || a.length || (n.allowSingleDeselect = !0)
        }), i.selectOptionsBackup = o.slice()), i.setList(o, e)
    }, r.prototype.setList = function (t, e) {
        var i = this, n = i.options, o = e ? [] : i.list || [], a = e ? {} : i.listMap || {};
        "string" == typeof t && (t = t.split(n.multiValueSplitter));
        for (var s = 0; s < t.length; ++s) {
            var r = t[s];
            if ("string" == typeof r) {
                var l = {};
                l[n.textKey] = r, l[n.valueKey] = String(s), r = l
            } else if (Array.isArray(r)) {
                var l = {};
                l[n.textKey] = r[0], l[n.valueKey] = r[1], l[n.keysKey] = r[2], r = l
            }
            var c = r[n.valueKey];
            "string" != typeof c && (c = String(c), r[n.valueKey] = c);
            var h = a[c];
            h ? (r.index = h.$_index, o[h.$_index] = r, a[c] = r) : (r.$_index = o.length, a[c] = r, o.push(r))
        }
        i.list = o, i.listMap = a
    }, r.prototype.updateOptionList = function (t, e) {
        var i = this;
        i.setList(t, e), i.dropListShowed && i.renderOptionsList()
    }, r.prototype.removeFromList = function (t) {
        var e = this, i = e.list || [];
        if (i.length) {
            var n = e.options;
            "string" == typeof t && (t = t.split(n.multiValueSplitter));
            for (var o = {}, a = 0; a < t.length; ++a) {
                var s = t[a];
                o["object" == typeof s ? s[n.valueKey] : s] = !0
            }
            for (var r = [], l = {}, a = 0; a < i.length; ++a) {
                var s = i[a], c = s[n.valueKey];
                o[c] || (r.push(s), l[c] = s)
            }
            e.list = r, e.listMap = l, e.setValue(e.multi ? e.value.slice() : e.value)
        }
    }, r.prototype.getItemID = function (t, e) {
        var i = this.id + "-item-" + btoa(encodeURIComponent(t[this.options.valueKey])).replace(/\+/g, "_").replace(/=/g, "-");
        return void 0 !== e ? i + "-" + e : i
    }, r.prototype.isSelectedValue = function (e) {
        var i = this;
        if (void 0 === i.value || null === i.value) return !1;
        if ("string" != typeof e && (e = String(e)), i.multi) {
            if (!i.valueSet) if (void 0 !== typeof Set) i.valueSet = new Set(i.value); else {
                i.valueSet = {};
                for (var n = 0; n < i.value.length; ++n) i.valueSet[i.value[n]] = !0
            }
            return t.isPlainObject(i.valueSet) ? !!i.valueSet[e] : i.valueSet.has(e)
        }
        return e === i.value
    }, r.prototype.getValue = function () {
        return this.value
    }, r.prototype.getListItem = function (t) {
        return this.listMap[t]
    }, r.prototype.hasListItem = function (t) {
        return void 0 !== this.listMap[t]
    }, r.prototype.triggerEvent = function (t, e, i, n) {
        var o = this;
        if (Array.isArray(e) || (e = [e]), o.$.trigger(t, e), o.options.chosenMode && n && o.$.trigger(n, e), i = i === !0 ? t : i || "on" + t[0].toUpperCase() + t.substr(1), "function" == typeof o.options[i]) return o.options[i].apply(o, e)
    }, r.prototype.setDisabled = function (t) {
        var e = this;
        void 0 === t ? t = "disabled" === e.$formItem.attr("disabled") : e.$formItem.attr("disabled", t ? "disabled" : null), e.disabled = t, e.$.toggleClass("disabled", t), e.multi || e.$search.attr("disabled", t ? "disabled" : null)
    }, r.prototype.setValue = function (e, i, n) {
        var o, a = this, s = a.options, r = a.multi;
        if (void 0 === e && (e = a.$formItem.val()), null === e && (e = ""), r && "string" == typeof e ? e = e.split(s.multiValueSplitter) : r || "string" == typeof e || (e = String(e)), s.valueMustInList && !s.remoteOnly) if (r && e) {
            for (var l = [], c = 0; c < e.length; ++c) {
                var h = e[c];
                a.hasListItem(h) && l.push(h)
            }
            l.length !== e.length && (e = l)
        } else r || a.hasListItem(e) || (e = void 0 !== s.defaultValue ? s.defaultValue : "");
        var d = a.value;
        if (r && d && e ? d.join(s.multiValueSplitter) !== e.join(s.multiValueSplitter) : d !== e) {
            if (!i && a.triggerEvent("beforeChange", {value: e, oldValue: d, picker: a}, !0) === !1) return;
            a.value = e, o = !0
        }
        r && (a.valueSet = null);
        var u = a.$formItem;
        if ("select" === a.formType) {
            var p = s.chosenMode;
            p || u.empty(), r ? t.each(e, function (t, e) {
                p && u.find('option[value="' + e + '"]').length || u.append('<option value="' + e + '">')
            }) : p && u.find('option[value="' + e + '"]').length || u.append('<option value="' + e + '">')
        }
        if (u.val(e), !n) {
            var f = !1, g = s.selectionTextRender || function (t, e, i) {
                t.text(e)
            };
            if (r) {
                var m = a.$selections, v = m.children(".picker-selection").addClass("picker-expired");
                t.each(e, function (e, i) {
                    void 0 === i || null === i ? i = "" : "string" != typeof i && (i = String(i));
                    var n = a.getListItem(i);
                    if (n) {
                        f = !0;
                        var o = n[s.textKey], r = a.getItemID(n, "selection"), l = v.filter("#" + r);
                        l.length ? l.removeClass("picker-expired") : l = t('<div class="picker-selection" id="' + r + '"><span class="picker-selection-text"></span><span class="picker-selection-remove"></span></div>').data("value", i), g(l.find(".picker-selection-text"), o, n), l.attr("title", o).insertBefore(a.$search)
                    }
                }), v.filter(".picker-expired").remove()
            } else {
                var y = a.getListItem(e);
                f = !!y, g(a.$singleSelection.find(".picker-selection-text"), f ? y[s.textKey] : "", y)
            }
            a.$container.toggleClass("picker-no-value", !f).toggleClass("picker-has-value", f)
        }
        a.dropListShowed && a.renderOptionsList(), o && (i || a.triggerEvent("change", {
            value: e,
            oldValue: d,
            picker: a
        }), a.$[0] !== u[0] && u.change()), a.$search.is(":focus") || a.$container.removeClass("picker-focus")
    }, r.prototype.handleParentScroll = function (e, n) {
        var o = this;
        if (!o.options.disableScrollOnShow && o.dropListShowed) {
            var a = o.options.hideOnScroll && (!n || e.target === i);
            o.scrollEventTimer && t.zui.clearAsap(o.scrollEventTimer), a && o.$dropMenu.css("opacity", 0), o.scrollEventTimer = t.zui.asap(function () {
                if (o.scrollEventTimer = null, o.dropListShowed) {
                    var t = (e.target === i ? i.body : e.target).getBoundingClientRect(),
                        n = o.$selections[0].getBoundingClientRect();
                    n.bottom < t.top || n.top > t.bottom ? o.hideDropList(!0) : o.layoutDropList(!0, !0)
                }
            }, a ? 500 : 0)
        }
    }, r.DEFAULTS = a, r.NAME = n, r.SHOWS = o, r.convertChosenOptions = function (e) {
        var i = !1;
        return t.each({
            allow_single_deselect: "allowSingleDeselect",
            inherit_select_classes: "inheritFormItemClasses",
            max_selected_options: "maxSelectedCount",
            no_results_text: "emptySearchResultHint",
            placeholder_text: "placeholder",
            placeholder_text_multiple: "placeholder",
            placeholder_text_single: "placeholder",
            single_backstroke_delete: "deleteByBackspace",
            display_selected_options: "showMultiSelectedOptions",
            drop_direction: "dropDirection",
            drop_width: "dropWidth",
            max_drop_width: "maxAutoDropWidth",
            highlight_selected: "autoSelectFirst",
            sort_value_splitter: "multiValueSplitter"
        }, function (t, n) {
            var o = e[t];
            void 0 !== o && (e[n] = o, delete e[t], i = !0)
        }), i && (e.chosenMode = !0), e
    }, t.fn.picker = function (e, i) {
        return this.each(function () {
            var o = t(this), a = o.data(n), s = "object" == typeof e && e;
            a ? "string" == typeof e && a[e](i) : ((r.enabledChosenMode || s && s.chosenMode) && (s = r.convertChosenOptions(t.extend({}, o.data(), s))), o.data(n, a = new r(this, s)))
        })
    }, t.fn.picker.Constructor = r, t.Picker = t.zui.Picker = r, r.enableChosen = function () {
        r.enabledChosenMode || (t.fn.chosen = function (e, i) {
            return this.each(function () {
                var o = t(this), a = o.data(n);
                if (!a) {
                    var s = t.extend({}, o.data(), "object" == typeof e ? e : null);
                    return a = new r(this, r.convertChosenOptions(s)), void o.data(n, a)
                }
                "string" == typeof e && a[e](i)
            })
        }, t.fn._chosen = t.fn.chosen, r.enabledChosenMode = !0)
    }, t.zui.fixBodyScrollbar && t.zui({
        _scrollbarWidth: 0, checkBodyScrollbar: function () {
            if (i.body.clientWidth >= e.innerWidth) return 0;
            if (!t.zui._scrollbarWidth) {
                var n = i.createElement("div");
                n.className = "modal-scrollbar-measure scrollbar-measure", i.body.appendChild(n), t.zui._scrollbarWidth = n.offsetWidth - n.clientWidth, i.body.removeChild(n)
            }
            return t.zui._scrollbarWidth
        }, fixBodyScrollbar: function () {
            if (t.zui.checkBodyScrollbar()) {
                var e = t("body"), i = parseInt(e.css("padding-right") || 0, 10);
                return t.zui._scrollbarWidth && e.css({
                    paddingRight: i + t.zui._scrollbarWidth,
                    overflowY: "hidden"
                }), !0
            }
        }, resetBodyScrollbar: function () {
            t("body").css({paddingRight: "", overflowY: ""})
        }
    }), t(function () {
        t('[data-toggle="picker"]').picker(), t(i).on("mousedown", function (e) {
            var i = t(e.target).closest(".picker,.picker-drop-menu"), n = i.length;
            t.each(o, function (t, e) {
                n && (i.is(e.$container) || e.$dropMenu && i.is(e.$dropMenu)) || e.hideDropList()
            })
        }), t(e).on("scroll", function (e) {
            t.each(o, function (t, i) {
                i.handleParentScroll(e, !0)
            })
        })
    })
}(jQuery, window, document), function (t) {
    "use strict";

    function e(e, i) {
        if (e === !1) return e;
        if (!e) return i;
        e === !0 ? e = {add: !0, "delete": !0, edit: !0, sort: !0} : "string" == typeof e && (e = e.split(","));
        var n;
        return Array.isArray(e) && (n = {}, t.each(e, function (e, i) {
            t.isPlainObject(i) ? n[i.action] = i : n[i] = !0
        }), e = n), t.isPlainObject(e) && (n = {}, t.each(e, function (e, i) {
            i ? n[e] = t.extend({type: e}, s[e], t.isPlainObject(i) ? i : null) : n[e] = !1
        }), e = n), i ? t.extend(!0, {}, i, e) : e
    }

    function i(e, i, n) {
        return i = i || e.type, t(n || e.template).addClass("tree-action").attr(t.extend({
            "data-type": i,
            title: e.title || ""
        }, e.attr)).data("action", e)
    }

    var n = "zui.tree", o = 0, a = function (e, i) {
        this.name = n, this.$ = t(e), this.getOptions(i), this._init()
    }, s = {
        sort: {template: '<a class="sort-handler" href="javascript:;"><i class="icon icon-move"></i></a>'},
        add: {template: '<a href="javascript:;"><i class="icon icon-plus"></i></a>'},
        edit: {template: '<a href="javascript:;"><i class="icon icon-pencil"></i></a>'},
        "delete": {template: '<a href="javascript:;"><i class="icon icon-trash"></i></a>'}
    };
    a.DEFAULTS = {
        animate: null,
        initialState: "normal",
        toggleTemplate: '<i class="list-toggle icon"></i>'
    }, a.prototype.add = function (e, i, n, o, a) {
        var s, r = t(e), l = this.options;
        if (r.is("li") ? (s = r.children("ul"), s.length || (s = t("<ul/>"), r.append(s), this._initList(s, r))) : s = r, s) {
            var c = this;
            Array.isArray(i) || (i = [i]), t.each(i, function (e, i) {
                var n = t("<li/>").data(i).appendTo(s);
                void 0 !== i.id && n.attr("data-id", i.id);
                var o = l.itemWrapper ? t(l.itemWrapper === !0 ? '<div class="tree-item-wrapper"/>' : l.itemWrapper).appendTo(n) : n;
                if (i.html) o.html(i.html); else if ("function" == typeof c.options.itemCreator) {
                    var a = c.options.itemCreator(n, i);
                    a !== !0 && a !== !1 && o.html(a)
                } else i.url ? o.append(t("<a/>", {href: i.url}).text(i.title || i.name)) : o.append(t("<span/>").text(i.title || i.name));
                c._initItem(n, i.idx || e, s, i), i.children && i.children.length && c.add(n, i.children)
            }), this._initList(s), n && !s.hasClass("tree") && c.expand(s.parent("li"), o, a)
        }
    }, a.prototype.reload = function (e) {
        var i = this;
        e && (i.$.empty(), i.add(i.$, e)), i.isPreserve && i.store.time && i.$.find("li:not(.tree-action-item)").each(function () {
            var e = t(this);
            i[i.store[e.data("id")] ? "expand" : "collapse"](e, !0, !0)
        })
    }, a.prototype._initList = function (n, o, a, s) {
        var r = this;
        n.hasClass("tree") ? (a = 0, o = null) : (o = (o || n.closest("li")).addClass("has-list"), o.find(".list-toggle").length || o.prepend(this.options.toggleTemplate), a = a || o.data("idx")), n.removeClass("has-active-item");
        var l = n.attr("data-idx", a || 0).children("li:not(.tree-action-item)").each(function (e) {
            r._initItem(t(this), e + 1, n)
        });
        1 !== l.length || l.find("ul").length || l.addClass("tree-single-item"), s = s || (o ? o.data() : null);
        var c = e(s ? s.actions : null, this.actions);
        if (c) {
            if (c.add && c.add.templateInList !== !1) {
                var h = n.children("li.tree-action-item");
                h.length ? h.detach().appendTo(n) : t('<li class="tree-action-item"/>').append(i(c.add, "add", c.add.templateInList)).appendTo(n)
            }
            c.sort && n.sortable(t.extend({
                dragCssClass: "tree-drag-holder",
                trigger: ".sort-handler",
                selector: "li:not(.tree-action-item)",
                finish: function (t) {
                    r.callEvent("action", {action: c.sort, $list: n, target: t.target, item: s})
                }
            }, c.sort.options, t.isPlainObject(this.options.sortable) ? this.options.sortable : null))
        }
        o && (o.hasClass("open") || s && s.open) && o.addClass("open in")
    }, a.prototype._initItem = function (n, o, a, s) {
        if (void 0 === o) {
            var r = n.prev("li");
            o = r.length ? r.data("idx") + 1 : 1
        }
        if (a = a || n.closest("ul"), n.attr("data-idx", o).removeClass("tree-single-item"), !n.data("id")) {
            var l = o;
            a.hasClass("tree") || (l = a.parent("li").data("id") + "-" + l), n.attr("data-id", l)
        }
        n.hasClass("active") && a.parent("li").addClass("has-active-item"), s = s || n.data();
        var c = e(s.actions, this.actions);
        if (c) {
            var h = n.find(".tree-actions");
            h.length || (h = t('<div class="tree-actions"/>').appendTo(this.options.itemWrapper ? n.find(".tree-item-wrapper") : n), t.each(c, function (t, e) {
                e && h.append(i(e, t))
            }))
        }
        var d = n.children("ul");
        d.length && this._initList(d, n, o, s)
    }, a.prototype._init = function () {
        var i = this.options, a = this;
        this.actions = e(i.actions), this.$.addClass("tree"), i.animate && this.$.addClass("tree-animate"), this._initList(this.$);
        var s = i.initialState, r = t.zui && t.zui.store && t.zui.store.enable;
        r && (this.selector = n + "::" + (i.name || "") + "#" + (this.$.attr("id") || o++), this.store = t.zui.store[i.name ? "get" : "pageGet"](this.selector, {})), "preserve" === s && (r ? this.isPreserve = !0 : this.options.initialState = s = "normal"), this.reload(i.data), r && (this.isPreserve = !0), "expand" === s ? this.expand() : "collapse" === s ? this.collapse() : "active" === s && this.expandSelect(".active"), this.$.on("click", '.list-toggle,a[href="#"],.tree-toggle', function (e) {
            var i = t(this), n = i.parent("li");
            a.callEvent("hit", {target: n, item: n.data()}), a.toggle(n), i.is("a") && e.preventDefault()
        }).on("click", ".tree-action", function () {
            var e = t(this), i = e.data();
            if (i.action && (i = i.action), "sort" !== i.type) {
                var n = e.closest("li:not(.tree-action-item)");
                a.callEvent("action", {action: i, target: this, $item: n, item: n.data()})
            }
        })
    }, a.prototype.preserve = function (e, i, n) {
        if (this.isPreserve) if (e) i = i || e.data("id"), n = void 0 === n && e.hasClass("open"), n ? this.store[i] = n : delete this.store[i], this.store.time = (new Date).getTime(), t.zui.store[this.options.name ? "set" : "pageSet"](this.selector, this.store); else {
            var o = this;
            this.store = {}, this.$.find("li").each(function () {
                o.preserve(t(this))
            })
        }
    }, a.prototype.expandSelect = function (t) {
        this.show(t, !0)
    }, a.prototype.expand = function (t, e, i) {
        t ? (t.addClass("open"), !e && this.options.animate ? setTimeout(function () {
            t.addClass("in")
        }, 10) : t.addClass("in")) : t = this.$.find("li.has-list").addClass("open in"), i || this.preserve(t), this.callEvent("expand", t, this)
    }, a.prototype.show = function (e, i, n) {
        var o = this;
        e instanceof t || (e = o.$.find("li").filter(e)), e.each(function () {
            var e = t(this);
            if (o.expand(e, i, n), e) for (var a = e.parent("ul"); a && a.length && !a.hasClass("tree");) {
                var s = a.parent("li");
                s.length ? (o.expand(s, i, n), a = s.parent("ul")) : a = !1
            }
        })
    }, a.prototype.collapse = function (t, e, i) {
        t ? !e && this.options.animate ? (t.removeClass("in"), setTimeout(function () {
            t.removeClass("open")
        }, 300)) : t.removeClass("open in") : t = this.$.find("li.has-list").removeClass("open in"), i || this.preserve(t), this.callEvent("collapse", t, this)
    }, a.prototype.toggle = function (t) {
        var e = t && t.hasClass("open") || t === !1 || void 0 === t && this.$.find("li.has-list.open").length;
        this[e ? "collapse" : "expand"](t)
    }, a.prototype.getOptions = function (e) {
        this.options = t.extend({}, a.DEFAULTS, this.$.data(), e), null === this.options.animate && this.$.hasClass("tree-animate") && (this.options.animate = !0)
    }, a.prototype.toData = function (e, i) {
        "function" == typeof e && (i = e, e = null), e = e || this.$;
        var n = this;
        return e.children("li:not(.tree-action-item)").map(function () {
            var e = t(this), o = e.data();
            delete o["zui.droppable"];
            var a = e.children("ul");
            return a.length && (o.children = n.toData(a)), "function" == typeof i ? i(o, e) : o
        }).get()
    }, a.prototype.callEvent = function (e, i) {
        var n;
        return "function" == typeof this.options[e] && (n = this.options[e](i, this)), this.$.trigger(t.Event(e + "." + this.name, i)), n
    }, t.fn.tree = function (e, i) {
        return this.each(function () {
            var o = t(this), s = o.data(n), r = "object" == typeof e && e;
            s || o.data(n, s = new a(this, r)), "string" == typeof e && s[e](i)
        })
    }, t.fn.tree.Constructor = a, t(function () {
        t('[data-ride="tree"]').tree()
    })
}(jQuery), function (t) {
    "use strict";
    var e = "zui.colorPicker",
        i = '<div class="colorpicker"><button type="button" class="btn dropdown-toggle" data-toggle="dropdown"><span class="cp-title"></span><i class="ic"></i></button><ul class="dropdown-menu clearfix"></ul></div>',
        n = {
            zh_cn: {errorTip: "不是有效的颜色值"},
            zh_tw: {errorTip: "不是有效的顏色值"},
            en: {errorTip: "Not a valid color value"}
        }, o = function (i, n) {
            this.name = e, this.$ = t(i), this.getOptions(n), this.init()
        };
    o.prototype.init = function () {
        var e = this, n = e.options, o = e.$, a = o.parent(), s = !1;
        a.hasClass("colorpicker") ? e.$picker = a : (e.$picker = t(n.template || i), s = !0), e.$picker.addClass(n.wrapper).find(".cp-title").toggle(void 0 !== n.title).text(n.title), e.$menu = e.$picker.find(".dropdown-menu").toggleClass("pull-right", n.pullMenuRight), e.$btn = e.$picker.find(".btn.dropdown-toggle"), e.$btn.find(".ic").addClass("icon-" + n.icon), n.btnTip && e.$picker.attr("data-toggle", "tooltip").tooltip({
            title: n.btnTip,
            placement: n.tooltip,
            container: "body"
        }), o.attr("data-provide", null), s && o.after(e.$picker), e.colors = {}, t.each(n.colors, function (i, n) {
            if (t.zui.Color.isColor(n)) {
                var o = new t.zui.Color(n);
                e.colors[o.toCssStr()] = o
            }
        }), e.updateColors(), e.$picker.on("click", ".cp-tile", function () {
            e.setValue(t(this).data("color"))
        });
        var r = function () {
            var i = o.val(), a = t.zui.Color.isColor(i);
            o.parent().toggleClass("has-error", !(a || n.optional && "" === i)), a ? e.setValue(i, !0) : n.optional && "" === i ? o.tooltip("hide") : o.is(":focus") || o.tooltip("show", n.errorTip)
        };
        o.is("input:not([type=hidden])") ? (n.tooltip && o.attr("data-toggle", "tooltip").tooltip({
            trigger: "manual",
            placement: n.tooltip,
            tipClass: "tooltip-danger",
            container: "body"
        }), o.on("keyup paste input change", r)) : o.appendTo(e.$picker), r()
    }, o.prototype.addColor = function (e) {
        e instanceof t.zui.Color || (e = new t.zui.Color(e));
        var i = e.toCssStr(), n = this.options;
        this.colors[i] || (this.colors[i] = e);
        var o = t('<a href="###" class="cp-tile"></a>', {titile: e}).data("color", e).css({
            color: e.contrast().toCssStr(),
            background: i,
            "border-color": e.luma() > .43 ? "#ccc" : "transparent"
        }).attr("data-color", i);
        this.$menu.append(t("<li/>").css({
            width: n.tileSize,
            height: n.tileSize
        }).append(o)), n.optional && this.$menu.find(".cp-tile.empty").parent().detach().appendTo(this.$menu)
    }, o.prototype.updateColors = function (e) {
        var i = this.$menu, n = this.options, e = e || this.colors, o = this, a = 0;
        if (i.children("li:not(.heading)").remove(), t.each(e, function (t, e) {
            o.addColor(e), a++
        }), n.optional) {
            var s = t('<li><a class="cp-tile empty" href="###"></a></li>').css({width: n.tileSize, height: n.tileSize});
            this.$menu.append(s), a++
        }
        i.css("width", Math.min(a, n.lineCount) * n.tileSize + 6)
    }, o.prototype.setValue = function (e, i) {
        var n = this, o = n.options, a = n.$btn, s = "";
        n.$menu.find(".cp-tile.active").removeClass("active");
        var r = o.updateBtn;
        if ("auto" === r) {
            var l = a.find(".color-bar");
            r = !l.length || function (t) {
                l.css("background", t || "")
            }
        }
        if (e) {
            var c = new t.zui.Color(e);
            s = c.toCssStr().toLowerCase(), r && ("function" == typeof r ? r(s, a, n) : a.css({
                background: s,
                color: c.contrast().toCssStr(),
                borderColor: c.luma() > .43 ? "#ccc" : s
            })), n.colors[s] || n.addColor(c), i || n.$.val().toLowerCase() === s || n.$.val(s).trigger("change"), n.$menu.find('.cp-tile[data-color="' + s + '"]').addClass("active"), n.$.tooltip("hide"), n.$.trigger("colorchange", c)
        } else r && ("function" == typeof r ? r(null, a, n) : a.attr("style", null)), i || "" === n.$.val() || n.$.val(s).trigger("change"), o.optional && n.$.tooltip("hide"), n.$menu.find(".cp-tile.empty").addClass("active"), n.$.trigger("colorchange", null);
        o.updateBorder && t(o.updateBorder).css("border-color", s), o.updateBackground && t(o.updateBackground).css("background-color", s), o.updateColor && t(o.updateColor).css("color", s), o.updateText && t(o.updateText).text(s)
    }, o.prototype.getOptions = function (i) {
        var a = t.extend({}, o.DEFAULTS, this.$.data(), i);
        "string" == typeof a.colors && (a.colors = a.colors.split(","));
        var s = a.lang || t.zui.clientLang(),
            r = this.lang = t.zui.getLangData ? t.zui.getLangData(e, s, n) : n[s] || n.en;
        a.errorTip || (a.errorTip = r.errorTip), t.fn.tooltip || (a.btnTip = !1), this.options = a
    }, o.DEFAULTS = {
        colors: ["#00BCD4", "#388E3C", "#3280fc", "#3F51B5", "#9C27B0", "#795548", "#F57C00", "#F44336", "#E91E63"],
        pullMenuRight: !0,
        wrapper: "btn-wrapper",
        tileSize: 30,
        lineCount: 5,
        optional: !0,
        tooltip: "top",
        icon: "caret-down",
        updateBtn: "auto"
    }, o.LANG = n, t.fn.colorPicker = function (e) {
        return this.each(function () {
            var i = t(this), n = i.data(name), a = "object" == typeof e && e;
            n || i.data(name, n = new o(this, a)), "string" == typeof e && n[e]()
        })
    }, t.fn.colorPicker.Constructor = o, t(function () {
        t('[data-provide="colorpicker"]').colorPicker()
    })
}(jQuery), function (t, e) {
    function i(t) {
        return t === e && (t = o += 1), a[t % a.length]
    }

    function n(e, i) {
        var n = t(e);
        i = t.extend({
            percent: 0,
            size: 20,
            backColor: "#eee",
            color: "#00da88",
            borderColor: "#ccc",
            borderSize: 1,
            rotate: -90,
            doughnut: 8
        }, n.data(), i);
        var o = i.percent, a = i.size;
        "string" == typeof o && (o = Number.parseFloat(o, 10)), "string" == typeof a && (a = Number.parseFloat(a, 10)), a = Math.floor(a);
        var s = a / 2, r = 3.14 * s, l = "http://www.w3.org/2000/svg", c = document.createElementNS(l, "svg"),
            h = document.createElementNS(l, "circle"), d = document.createElementNS(l, "circle"),
            u = document.createElementNS(l, "circle");
        d.setAttribute("r", s), d.setAttribute("cx", s), d.setAttribute("cy", s), d.setAttribute("fill", i.backColor), d.setAttribute("stroke", i.borderColor), d.setAttribute("stroke-width", i.borderSize), u.setAttribute("r", i.doughnut), u.setAttribute("cx", s), u.setAttribute("cy", s), u.setAttribute("fill", i.backColor), h.setAttribute("r", s / 2), h.setAttribute("cx", s), h.setAttribute("cy", s), h.setAttribute("fill", "transparent"), h.setAttribute("stroke-dasharray", (o * r / 100).toFixed(1) + " " + r), h.setAttribute("stroke-width", s), h.setAttribute("stroke", i.color), h.setAttribute("transform", "rotate(-90) translate(-" + a + ")"), c.setAttribute("viewBox", "0 0 " + a + " " + a), c.setAttribute("width", a), c.setAttribute("height", a), c.setAttribute("transform", "rotate(180)"), c.appendChild(d), c.appendChild(h), c.appendChild(u), n[0].appendChild(c);
        var p = {width: a, height: a};
        "inline" === n.css("display") && (p.display = "inline-block", p.verticalAlign = "middle"), n.css(p)
    }

    var o = 0,
        a = ["#00a9fc", "#ff5d5d", "#fdc137", "#00da88", "#7ec5ff", "#8666b8", "#bd7b46", "#ff9100", "#ff3d00", "#f57f17", "#00e5ff", "#00b0ff", "#2979ff", "#3d5afe", "#651fff", "#d500f9", "#f50057", "#ff1744"];
    jQuery.fn.tableChart = function () {
        t(this).each(function () {
            var e = t(this), n = e.data(), o = n.chart || "pie", a = t(n.target);
            if (a.length) {
                var s = null;
                if ("pie" === o) {
                    n = t.extend({scaleShowLabels: !0, scaleLabel: "<%=label%>: <%=value%>"}, n);
                    var r = [], l = e.find("tbody > tr").each(function (e) {
                        var n = t(this), o = n.data("color") || i();
                        n.attr("data-id", e).find(".chart-color-dot").css("background", o), r.push({
                            label: n.find(".chart-label").text(),
                            value: parseFloat(n.data("value") || n.find(".chart-value").text()),
                            color: o,
                            id: e
                        })
                    });
                    r.length > 1 ? n.scaleLabelPlacement = "outside" : 1 === r.length && (n.scaleLabelPlacement = "inside", r.push({
                        label: "",
                        value: r[0].value / 2e3,
                        color: "#fff",
                        showLabel: !1
                    })), s = a.pieChart(r, n), a.on("mousemove", function (t) {
                        var e = s.getSegmentsAtEvent(t);
                        l.removeClass("active"), e.length && l.filter('[data-id="' + e[0].id + '"]').addClass("active")
                    })
                } else if ("bar" === o) {
                    var c = n.color || i(), h = [],
                        d = {label: e.find("thead .chart-label").text(), color: c, data: []},
                        l = e.find("tbody > tr").each(function (e) {
                            var i = t(this);
                            h.push(i.find(".chart-label").text()), d.data.push(i.data("value") || parseFloat(i.find(".chart-value").text())), i.find(".chart-color-dot").css("background", c)
                        }), r = {labels: h, datasets: [d]};
                    h.length && (n.barValueSpacing = 5), s = a.barChart(r, n)
                } else if ("line" === o) {
                    var c = n.color || i(), h = [],
                        d = {label: e.find("thead .chart-label").text(), color: c, data: []},
                        l = e.find("tbody > tr").each(function (e) {
                            var i = t(this);
                            h.push(i.find(".chart-label").text()), d.data.push(parseInt(i.find(".chart-value").text())), i.find(".chart-color-dot").css("background", c)
                        }), r = {labels: h, datasets: [d]};
                    h.length && (n.barValueSpacing = 5), s = a.lineChart(r, n)
                }
                null !== s && e.data("zui.chart", s)
            }
        })
    }, t(".table-chart").tableChart();
    var s = function (i, n) {
        var o = t(i);
        if (!o.data("pieChart")) {
            var a = o.is("canvas") ? o : o.find("canvas"), s = t.extend({
                value: 0,
                color: t.getThemeColor("primary") || "#006af1",
                backColor: t.getThemeColor("pale") || "#E9F2FB",
                doughnut: !0,
                doughnutSize: 85,
                width: 20,
                height: 20,
                showTip: !1,
                name: "",
                tipTemplate: "<%=value%>%",
                animation: "auto",
                realValue: parseFloat(o.find(".progress-value").text())
            }, n, o.data()), r = a.length;
            r || (a = t("<canvas>").appendTo(o)), a.attr("width") !== e ? s.width = a.width() : a.attr("width", s.width), a.attr("height") !== e ? s.height = a.height() : a.attr("height", s.height), r || 8 != t.zui.browser.ie || G_vmlCanvasManager.initElement(a[0]), "auto" === s.animation && (s.animation = s.width > 30), o.addClass("progress-pie-" + s.width).css({
                width: s.width,
                height: s.height
            }), s.value = Math.max(0, Math.min(100, s.value));
            var l = [{value: s.value, label: s.name, color: s.color, circleBeginEnd: !0}, {
                value: 100 - s.value,
                label: "",
                color: s.backColor
            }], c = a[s.doughnut ? "doughnutChart" : "pieChart"](l, t.extend({
                segmentShowStroke: !1,
                animation: s.animation,
                showTooltips: s.showTip,
                tooltipTemplate: s.tipTemplate,
                percentageInnerCutout: s.doughnutSize,
                reverseDrawOrder: !0,
                animationEasing: "easeInOutQuart",
                onAnimationProgress: s.realValue ? function (t) {
                    o.find(".progress-value").text(Math.floor(s.realValue * t))
                } : e,
                onAnimationComplete: s.realValue ? function (t) {
                    o.find(".progress-value").text(s.realValue)
                } : e
            }, s.chartOptions));
            o.data("pieChart", c)
        }
    };
    jQuery.fn.progressPie = function (e) {
        t(this).each(function () {
            var i = t(this);
            if (!i.closest(".hidden,.datatable-origin").length) {
                var n = i.closest(".tab-pane");
                n.length && !n.hasClass("active") ? t('[data-toggle="tab"][data-target="#' + n.attr("id") + '"]').one("shown.zui.tab", function () {
                    s(i, e)
                }) : s(this, e)
            }
        })
    }, t.fn.pieIcon = function (e) {
        t(this).each(function () {
            n(this, e)
        })
    }, t(function () {
        t(".table-chart").tableChart();
        var e = t(".progress-pie:visible");
        e.length < 100 && t(".progress-pie:visible").progressPie(), setTimeout(function () {
            t(".progress-pie:visible").progressPie()
        }, e.length > 100 ? 1e3 : 50), t(".pie-icon:visible").pieIcon()
    })
}(jQuery, void 0), function (t) {
    jQuery.fn.sparkline = function (e) {
        t(this).each(function () {
            var i = t(this),
                n = t.extend({values: i.attr("values"), width: i.width() - 4, height: i.height() - 4}, i.data(), e),
                o = n.height, a = [], s = n.width, r = n.values.split(","), l = 0;
            for (var c in r) {
                var h = parseFloat(r[c]);
                isNaN(h) ? h = null : l = Math.max(h, l), a.push(h)
            }
            var d = Math.min(s, Math.max(20, a.length * s / 30)), d = s, u = i.children("canvas");
            u.length || (i.append('<canvas class="projectline-canvas"></canvas>'), u = i.children("canvas")), u.attr("width", d).attr("height", o);
            var p = {
                labels: a, datasets: [{
                    strokeColor: "#ccc", pointColor: "#ccc", data: a.map(function () {
                        return 0
                    })
                }, {
                    fillColor: t.getThemeColor("pale") || "rgba(0,0,255,0.05)",
                    strokeColor: t.getThemeColor("primary") || "#0054EC",
                    pointColor: t.getThemeColor("secondary") || "rgba(255,136,0,1)",
                    pointStrokeColor: "#fff",
                    data: a
                }]
            }, f = {
                animation: !0,
                scaleOverride: !0,
                scaleStepWidth: Math.ceil(l / 10),
                scaleSteps: 10,
                scaleStartValue: 0,
                showScale: !1,
                showTooltips: !1,
                pointDot: !1,
                scaleShowGridLines: !1,
                datasetStrokeWidth: 1
            }, g = t(u).lineChart(p, f);
            i.data("sparklineChart", g)
        })
    }, t(function () {
        t(".sparkline").sparkline()
    })
}(jQuery), function (t) {
    t.fn.fixedDate = function () {
        return t(this).each(function () {
            var e = t(this).attr("autocomplete", "off");
            "0000-00-00" == e.val() && e.focus(function () {
                "0000-00-00" == e.val() && e.val("").datetimepicker("update")
            }).blur(function () {
                "" == e.val() && e.val("0000-00-00")
            })
        })
    }, window.datepickerOptions = {
        language: t("html").attr("lang"),
        weekStart: 1,
        todayBtn: 1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        forceParse: 0,
        showMeridian: 1,
        format: "yyyy-mm-dd hh:ii",
        startDate: "1970-1-1"
    }, t.extend(t.fn.datetimepicker.defaults, window.datepickerOptions), t(function () {
        var e = {minView: 2, format: "yyyy-mm-dd"}, i = {startView: 1, minView: 0, maxView: 1, format: "hh:ii"},
            n = {minView: 3, startView: 3, format: "yyyy-mm"};
        t(".datepicker-wrapper").click(function () {
            t(this).find(".form-date, .form-datetime, .form-time, .form-month").datetimepicker("show").focus()
        }), t.fn.datepicker = function (i) {
            return this.datetimepicker(t.extend({}, e, i))
        }, t.fn.timepicker = function (e) {
            return this.datetimepicker(t.extend({}, i, e))
        }, t.fn.monthpicker = function (e) {
            return this.datetimepicker(t.extend({}, n, e))
        }, t.fn.datepickerAll = function () {
            return this.find(".form-datetime").fixedDate().datetimepicker(), this.find(".form-date").fixedDate().datepicker(), this.find(".form-time").fixedDate().timepicker(), this.find(".form-month").fixedDate().monthpicker(), this
        }, t("body").datepickerAll()
    })
}(jQuery), function (t) {
    var e = function (e, i) {
        i = t.extend({idStart: 0, idEnd: 9, chosen: !0, datetimepicker: !0, colorPicker: !0, hotkeys: !0}, i, e.data());
        var n = e.find(".template");
        !n.length && i.template && (n = t(i.template));
        var o = 0, a = 0, s = function (t) {
            t.is("select.chosen") ? t.next(".chosen-container").find("input").focus() : t.focus()
        }, r = function (t) {
            var i = e.find("[data-ctrl-index]:focus,.chosen-container-active").first();
            if (i.length) {
                if (i.is(".chosen-container-active")) {
                    if (i.hasClass("chosen-with-drop") && ("down" === t || "up" === t)) return;
                    i = i.prev("select.chosen")
                }
                var n = i.data("ctrlIndex"), r = i.closest("tr").data("row");
                "down" === t ? r < a - 1 ? r += 1 : r = 0 : "up" === t ? r > 0 ? r -= 1 : r = a - 1 : "left" === t ? n > 0 ? n -= 1 : n = o - 1 : "right" === t && (n < o - 1 ? n += 1 : n = 0), s(e.find('tr[data-row="' + r + '"]').find('[data-ctrl-index="' + n + '"]'))
            }
        }, l = {options: i, focusNext: r, focusControl: s}, c = e.find("tbody,.batch-rows"), h = function (e) {
            t.fn.chosen && i.chosen && e.find(".chosen").chosen(t.isPlainObject(i.chosen) ? i.chosen : null), t.fn.datetimepicker && i.datetimepicker && e.datepickerAll(t.isPlainObject(i.datetimepicker) ? i.datetimepicker : null), t.fn.colorPicker && i.colorPicker && e.find("input.colorpicker").colorPicker(t.isPlainObject(i.colorPicker) ? i.colorPicker : null);
            var n = 0;
            e.find('input[type!="hidden"],textarea,select').each(function () {
                var e = t(this);
                e.parent().hasClass("chosen-search") || e.attr("data-ctrl-index", n++)
            }), o = Math.max(o, n)
        };
        if (n.length) {
            var d = n.remove().html(), u = function (e, o) {
                var s = d;
                "number" != typeof e && (e = a), a = Math.max(e + 1, a), s = s.replace(/\$idPlus/g, e + 1).replace(/\$id/g, e);
                var r = t("<" + n[0].tagName.toLowerCase() + " />").html(s);
                return r.attr("data-row", e).addClass(n.attr("class")).removeClass("template"), i.rowCreator && i.rowCreator(r, e, i), o ? o.after(r) : c.append(r), h(r), r
            };
            t.extend(l, {createRow: u, template: d});
            for (var p = i.idStart; p <= i.idEnd; ++p) u(p)
        } else h(e);
        e.on("click", ".btn-copy", function () {
            var e = t(this), i = t(e.data("copyFrom")).val(), n = t(e.data("copyTo")).val(i).addClass("highlight");
            setTimeout(function () {
                n.removeClass("highlight")
            }, 2e3)
        }), i.hotkeys && t(document).on("keydown", function (t) {
            var e = {
                "Ctrl+#37": "left",
                "Ctrl+#39": "right",
                "#38": "up",
                "#40": "down",
                "Ctrl+#38": "up",
                "Ctrl+#40": "down"
            }, i = [];
            t.ctrlKey && i.push("Ctrl"), i.push("#" + t.keyCode);
            var n = e[i.join("+")];
            n && (r(n), t.ctrlKey && (t.stopPropagation(), t.preventDefault()))
        }), e.data("zui.batchActionForm", l), setTimeout(t.fixTableResponsive, 0)
    };
    t.fn.batchActionForm = function (i) {
        return this.each(function () {
            e(t(this), i)
        })
    }
}(jQuery), function (t, e) {
    "use strict";
    var i = "zui.table", n = {
            zh_cn: {selectedItems: "已选择 <strong>{0}</strong> 项", attrTotal: "{0}总计 <strong>{1}</strong>"},
            zh_tw: {selectedItems: "已选择 <strong>{0}</strong> 项", attrTotal: "{0}总计 <strong>{1}</strong>"},
            en: {selectedItems: "Seleted <strong>{0}</strong> items", attrTotal: "{0} total <strong>{1}</strong>"},
            de: {selectedItems: "<strong>{0}</strong> ausgewählt", attrTotal: "{0} insgesamt <strong>{1}</strong>"},
            fr: {selectedItems: "<strong>{0}</strong> sélectionnés", attrTotal: "{0} total <strong>{1}</strong>"}
        }, o = /^((?!chrome|android).)*safari/i.test(navigator.userAgent), a = t.zui.browser.isIE(), s = a ? 200 : 100,
        r = function (e, o) {
            var a = this;
            a.name = i;
            var s = a.$ = t(e);
            o = a.options = t.extend({}, r.DEFAULTS, this.$.data(), o), a.langName = o.lang || t.zui.clientLang(), a.lang = t.zui.getLangData(i, a.langName, n), a.id = s.attr("id"), a.id || (a.id = o.id || "table-" + t.zui.uuid(), a.noID = !0, s.attr("id", a.id), o.hot && console.warn("ZUI: table hot replace id not defined, the element id attribute should be set.")), s.attr("data-ride") || s.attr("data-ride", "table");
            var l = a.getTable();
            if (l.length) {
                l.find("thead>tr>th").each(function () {
                    var e = t(this);
                    if (!e.attr("title")) {
                        var i = t.trim(e.find("a:first").text() || e.text() || "");
                        i.length && e.attr("title", i)
                    }
                }), a.$.toggleClass("no-animation", l.find("tbody>tr").length >= 30), o.nested && a.initNestedList(), o.checkable && (s.on("click", ".check-all", function () {
                    a.checkAll(!t(this).hasClass("checked"))
                }), o.checkOnClickRow && s.on("click", "tbody>tr", function (e) {
                    t(e.target).closest('.btn,a,.not-check,.form-control,input[type="text"],.table-nest-toggle,.chosen-container').length || a.checkRow(t(this))
                }), s.on("click", 'tbody input[type="checkbox"],tbody label[for]', function (e) {
                    e.stopPropagation();
                    var i = t(this);
                    i.is("label") && (i = i.closest(".checkbox-primary").find('input[type="checkbox"]')), a.checkRow(i.closest("tr"), i.is(":checked"))
                }), o.selectable && s.selectable(t.extend({}, {
                    selector: a.isDataTable ? ".fixed-left tbody>tr" : "tbody>tr",
                    selectClass: "",
                    trigger: "td.c-id",
                    clickBehavior: "multi",
                    listenClick: !1,
                    start: function () {
                        this.syncSelectionsFromClass()
                    },
                    select: function (e) {
                        a.checkRow(e.target, !0), t.cookie("ajax_dragSelected") || (t.cookie("ajax_dragSelected", "on", {
                            expires: config.cookieLife,
                            path: config.webRoot
                        }), t.ajaxSendScore("dragSelected"))
                    },
                    unselect: function (t) {
                        a.checkRow(t.target, !1)
                    },
                    rangeStyle: {
                        border: "1px solid #006af1",
                        backgroundColor: "rgba(50,128,252,0.2)",
                        borderRadius: "2px"
                    }
                }, t.isPlainObject(o.selectable) ? o.selectable : null)));
                var c = a.$form = s.is("form") ? s : s.find("form");
                c.length && (o.ajaxForm ? c.ajaxForm(t.isPlainObject(o.ajaxForm) ? o.ajaxForm : null) : c.on("click", "[data-form-action]", function () {
                    c.attr("action", t(this).data("formAction")).submit()
                })), (o.fixFooter || o.fixHeader) && (a.pageFooterHeight = t("#footer").outerHeight(), a.updateFixUI(!0), a.updateFixUITimer = 0, t(window).on("scroll resize", function () {
                    a.updateFixUITimer && t.zui.clearAsap(a.updateFixUITimer), a.updateFixUITimer = t.zui.asap(function () {
                        a.updateFixUI(), a.updateFixUITimer = 0
                    })
                }).on("sidebar.toggle", function () {
                    setTimeout(function () {
                        a.updateFixUI()
                    }, 200)
                })), o.group && (s.on("click", ".group-toggle", function () {
                    a.toggleRowGroup(t(this).closest("tr").data("id"))
                }), t(document).on("click", ".group-collapse-all", function () {
                    a.toggleGroups(!1)
                }).on("click", ".group-expand-all", function () {
                    a.toggleGroups(!0)
                })), a.defaultStatistic = s.find(".table-statistic").html(), a.updateStatistic(), a.initModals(), a.checkItems = {}, a.updateCheckUI()
            }
        };
    r.prototype.initNestedList = function () {
        var e = this, i = e.options, n = e.getTable().addClass("table-nested"), o = n.find("tbody"),
            a = o.children("tr[data-id]"), s = {}, r = [], l = i.preserveNested, c = i.enableEmptyNestedRow;
        n.toggleClass("disable-empty-nest-row", !c), a.each(function (e) {
            var i = t(this), n = i.data();
            n.realOrder = e, n.$row = i, n.nestPath ? (n.nestPathList = n.nestPath.split(","), n.nestPathList[0] || n.nestPathList.shift(), n.nestPathList[n.nestPathList.length - 1] || n.nestPathList.pop(), n.nestPathLevel = n.nestPathList.length, i.attr("data-level", n.nestPathLevel)) : (n.nestPath = "," + n.id + ",", n.nestPathList = [n.id], n.nestPathLevel = 1), s[n.id] = n, delete n.children, r.push(n)
        });
        var h = [];
        t.each(r, function (t, n) {
            return n.nestParent && (n.parent = s[n.nestParent], n.parent) ? (n.parent.children ? n.parent.children.push(n) : n.parent.children = [n], void (i.expandNestChild || e._initedNestedList || (n.$row.addClass("table-nest-hide"), n.parent.$row.addClass("table-nest-child-hide")))) : (n.$row.removeClass("table-nest-hide"), void h.push(n))
        }), e.nestRowsMap = s, e.$nestBody = o;
        var d = function (e) {
            for (var n = 0; n < e.length; ++n) {
                var a = e[n];
                o.append(a.$row), a.children ? (a.$row.addClass("has-nest-child"), d(a.children), a.nestPathLevel < 2 && a.$row.addClass("is-top-level")) : a.parent ? a.$row.addClass("is-nest-child") : c || a.$row.addClass("no-nest");
                var s = a.$row.find(".table-nest-title");
                s.length || (s = a.$row.find("td:first"));
                var r = s.find(".table-nest-icon");
                r.length || (r = t('<span class="table-nest-icon icon"></span>').prependTo(s)), r.toggleClass("table-nest-toggle", !!a.children || c && a.nested).css("marginLeft", (a.nestPathLevel - 1) * i.nestLevelIndent), delete a.$row
            }
        };
        d(h), e.nestConfigStoreName = "/" + window.config.currentModule + "/" + window.config.currentMethod + "/table." + e.id + ".nestConfig", e.nestConfig = l ? t.zui.store.get(e.nestConfigStoreName, {}) : {}, e.nestState = {}, e.updateNestState(), e._initedNestedList || (o.on("click", ".table-nest-toggle", function () {
            e.toggleNestedRows(t(this).closest("tr").data("id"))
        }), o.on("mouseenter", "tr.has-nest-child", function () {
            o.find(".table-nest-hover").removeClass("table-nest-hover"), o.find(".table-nest-child-hover").removeClass("table-nest-child-hover");
            var e = t(this).addClass("table-nest-hover"), i = e.closest("tr").data("id");
            o.find('[data-nest-path*=",' + i + ',"]').addClass("table-nest-child-hover")
        }).on("mouseleave", "tr.table-nest-hover", function () {
            o.find(".table-nest-hover").removeClass("table-nest-hover"), o.find(".table-nest-child-hover").removeClass("table-nest-child-hover")
        }), e.$.on("click", ".table-nest-toggle-global", function () {
            for (var t = e.$.hasClass("table-nest-collapsed"), n = 0; n < h.length; ++n) {
                var o = h[n];
                (o.children || o.nested && i.enableEmptyNestedRow) && e.toggleNestedRows(o.id, t, !0)
            }
            e.updateNestState()
        }), e._initedNestedList = !0)
    }, r.prototype.toggleNestedRows = function (i, n, o) {
        var a = this, s = a.nestConfig;
        if (n === e && (n = !s[i]), n ? s[i] = !0 : delete s[i], o) {
            var r = a.nestRowsMap[i];
            t.each(a.nestRowsMap, function (t, e) {
                0 === e.nestPath.indexOf(r.nestPath) && (n ? s[t] = !0 : delete s[t])
            })
        }
        t.zui.store.set(a.nestConfigStoreName, s), this.updateNestState()
    }, r.prototype.getNestState = function () {
        function i(a, s) {
            t.each(a, function (t, a) {
                if (o[a.id] = s, a.children) {
                    var r = s;
                    r && (r = n.nestConfig[a.id], r === e && (r = !1)), i(a.children, r)
                }
            })
        }

        var n = this, o = {};
        return t.each(n.nestRowsMap, function (t, e) {
            if (!e.parent) {
                var o = !!n.nestConfig[t];
                e.children && e.children.length && i(e.children, o)
            }
        }), o
    }, r.prototype.updateNestState = function () {
        var e = this, i = e.nestState, n = e.getNestState();
        e.nestState = n, t.each(e.nestRowsMap, function (t, o) {
            var a = e.$nestBody.find('[data-id="' + t + '"]'), s = !!e.nestConfig[t];
            (o.children || o.nested) && a.toggleClass("table-nest-child-hide", !s);
            var r = n[t];
            if (o.parent) {
                if (r === i[t]) return;
                a.toggleClass("table-nest-hide", !r)
            }
        });
        var o = !e.$nestBody.find("tr.is-top-level.has-nest-child:not(.table-nest-child-hide)").length;
        e.$.toggleClass("table-nest-collapsed", o), e.$.find(".table-nest-toggle-global").each(function () {
            var e = t(this);
            e.attr("title", e.data(o ? "expandText" : "collapseText"))
        }), e.$.trigger("tableNestStateChanged")
    }, r.prototype.reload = function (e) {
        var i = this, n = i.options, o = n.replaceId;
        if (!o) return e && e();
        var a = i.id;
        if ("self" === o) {
            if (i.noID) return;
            o = a
        }
        var s = t("<div></div>");
        i.$.addClass("load-indicator loading"), s.load(window.location.href + " #" + o, function (r) {
            if (a === o) i.$.empty().html(s.children().html()), i.$.find('[data-ride="pager"]').pager(); else {
                i.$.find("#" + o).empty().html(s.children().html());
                try {
                    var l = t(r), c = l.find("#" + o).closest('[data-ride="table"],#' + a);
                    if (c.length) {
                        var h = c.find(".table-statistic");
                        h.length && (i.defaultStatistic = h.html());
                        var d = i.$.find('[data-ride="pager"]').data("zui.pager"), u = c.find('[data-ride="pager"]');
                        d && u.length && d.set(u.data())
                    }
                } catch (p) {
                    console.error(p)
                }
            }
            i.$.removeClass("load-indicator loading").trigger("beforeTableReload"), delete i.defaultStatistic, i.updateStatistic(), i.initModals(), i.$.datepickerAll();
            var f = i.$.find("tbody>tr"), g = !1;
            t.each(i.checkItems, function (t, e) {
                e && (i.checkRow(f.filter('[data-id="' + t + '"]'), !0, !0), g = !0)
            }), g && i.updateCheckUI(), n.nested && i.initNestedList(), i.$.trigger("tableReload");
            var m = t("#mainMenu>.btn-toolbar>.btn-active-text>.label");
            if (m.length) {
                var u = i.$.find(".pager[data-rec-total]"),
                    v = u.length ? u.attr("data-rec-total") : i.getTable().find("tbody:first>tr:not(.table-children)").length;
                m.text(v)
            }
            e && e(), n.afterReload && n.afterReload()
        })
    }, r.prototype.initModals = function () {
        var e = this, i = e.options, n = e.$.find(i.iframeModalTrigger);
        if (n.length) {
            var o = {
                type: "iframe", onHide: i.replaceId ? function () {
                    var n = t.cookie("selfClose");
                    (1 == n || i.hot) && (t("#triggerModal").data("cancel-reload", 1), e.reload(function () {
                        t.cookie("selfClose", 0)
                    }))
                } : null
            };
            n.modalTrigger(o)
        }
    }, r.prototype.getTable = function () {
        var t = this.$;
        if (this.isDataTable) return t.find("div.datatable");
        var e = t.is("table") ? t : t.find("table:not(.fixed-header-copy)").first();
        return e.is(".datatable") && (this.isDataTable = !0, e.data("zui.datatable") || window.initDatatable(e), e = t.find("div.datatable")), e
    }, r.prototype.toggleGroups = function (e) {
        var i = this, n = {};
        i.$.find("tbody>tr").each(function () {
            var o = t(this).closest("tr").data("id");
            n[o] || i.toggleRowGroup(o, e)
        })
    }, r.prototype.toggleRowGroup = function (i, n) {
        var o = this.$.find('tbody>tr[data-id="' + i + '"]'), a = o.filter(".group-summary"),
            s = n === e ? !a.hasClass("hidden") : !!n;
        o.not(".group-summary").toggleClass("hidden", !s), a.toggleClass("hidden", s), t("body").toggleClass("table-group-collapsed", !this.$.find("tbody>tr.group-summary.hidden").length)
    }, r.prototype.updateStatistic = function () {
        var i = this, n = i.$.find(".table-statistic");
        if (n.length) {
            if (i.defaultStatistic === e && (i.defaultStatistic = n.html()), i.options.statisticCreator) return void n.html(i.options.statisticCreator(i) || i.defaultStatistic);
            var o = i.statisticCols;
            if (!o && o !== !1) {
                o = {};
                var a = !1;
                i.getTable().find("thead th").each(function (e) {
                    var i = t(this), n = i.data("statistic");
                    n && (a = !0, o[e] = {format: n, name: i.text()})
                }), i.statisticCols = !!a && o
            }
            var s = 0;
            o && t.each(o, function (t) {
                o[t].total = 0, o[t].checkedTotal = 0
            }), i.$.find(i.isDataTable ? ".fixed-left tbody>tr" : "tbody>tr").each(function () {
                var e = t(this), i = e.hasClass("checked"), n = e.children("td");
                i && s++, o && t.each(o, function (t) {
                    var e = parseFloat(n.eq(t).text());
                    isNaN(e) && (e = 0), o[t].total += e, i && (o[t].checkedTotal += e)
                })
            });
            var r = [];
            if (s) r.push(i.lang.selectedItems.format(s)); else if (i.defaultStatistic) return void n.html(i.defaultStatistic);
            o && t.each(o, function (t) {
                var e = o[t], n = e[s ? "checkedTotal" : "total"];
                e.format && (n = e.format.format(n)), r.push(i.lang.attrTotal.format(e.name, n))
            }), n.html(r.join(", "))
        }
    }, r.prototype.updateFixUI = function (e) {
        var i = this, n = (new Date).getTime();
        if (!e && (i.lastUpdateCall && clearTimeout(i.lastUpdateCall), !i.lastUpdateTime || n - i.lastUpdateTime < s)) return void (i.lastUpdateCall = setTimeout(function () {
            i.updateFixUI(!0)
        }, s / 2));
        if (i.lastUpdateTime = n, i.lastUpdateCall && (clearTimeout(i.lastUpdateCall), i.lastUpdateCall = null), o) {
            var a = i.getTable();
            if (a.parent().is(".table-responsive")) {
                var r = a.find("thead"), l = 0;
                r.find("th").each(function () {
                    l += t(this).outerWidth()
                }), a.css("min-width", l)
            }
        }
        i.options.fixHeader && !i.isDataTable && i.fixHeader(), i.options.fixFooter && i.fixFooter()
    }, r.prototype.fixHeader = function () {
        var e = this, i = e.getTable(), n = i.find("thead"), o = n[0].getBoundingClientRect(), s = e.options.fixFooter,
            r = "function" == typeof s ? s(o, n) : o.top < ("number" == typeof s ? s : -5),
            l = e.$.find(".fix-table-copy-wrapper"), c = i.parent(), h = c.is(".table-responsive");
        if (e.$.toggleClass("table-header-fixed", !!r), e.$.find(".table-header").css("width", r ? o.width : ""), r) {
            if (l.length || (l = t('<div class="fix-table-copy-wrapper" style="position:fixed; z-index: 3; top: 0;"></div>').append(t('<table class="fixed-header-copy"></table>').addClass(i.attr("class")).append(n.clone())).insertAfter(i)), h) {
                var d = c[0].getBoundingClientRect();
                l.css({
                    left: d.left,
                    width: c.width(),
                    overflow: "hidden"
                }), l.find(".fixed-header-copy").css({
                    left: o.left - d.left,
                    position: "relative",
                    minWidth: i.width()
                }), a || c.data("fixHeaderScroll") || (c.data("fixHeaderScroll", 1), i.width() > c.width() && c.on("scroll", function () {
                    e.fixHeader()
                }))
            } else l.css({left: o.left, width: o.width});
            var u = l.find("th");
            n.find("th").each(function (e) {
                u.eq(e).css("width", t(this).outerWidth())
            })
        } else l.remove()
    }, r.prototype.fixFooter = function () {
        var e, i = this, n = i.getTable(), o = i.$.find(".table-footer");
        if (i.isDataTable) e = n[0].getBoundingClientRect(); else {
            var a = n.find("tbody");
            if (!a.length) return;
            e = a[0].getBoundingClientRect()
        }
        var s = i.options.fixFooter;
        o.toggleClass("fixed-footer", !!r);
        var r = "function" == typeof s ? s(e, o) : e.bottom > window.innerHeight - 50 - ("number" == typeof s ? s : i.pageFooterHeight || 5);
        o.toggleClass("fixed-footer", !!r), n.toggleClass("with-footer-fixed", !!r), n.trigger("fixFooter", r);
        var l = t("body"), c = l.hasClass("body-modal");
        if (r) {
            var h = n.parent(), d = h.is(".table-responsive");
            o.css({
                bottom: i.pageFooterHeight || 0,
                left: d ? h[0].getBoundingClientRect().left : e.left,
                width: d ? h.width() : e.width
            }), c && l.css("padding-bottom", 40)
        } else o.css({width: "", left: 0, bottom: 0}), c && l.css("padding-bottom", 0)
    }, r.prototype.checkAll = function (e) {
        var i = this, n = i.$.find(i.isDataTable ? ".fixed-left tbody>tr" : "tbody>tr");
        n.each(function () {
            i.checkRow(t(this), e, !0)
        }), i.updateCheckUI()
    }, r.prototype.checkRow = function (i, n, o) {
        var a = this, s = a.getTable();
        a.isDataTable && !i.is(".datatable-row-left") && (i = s.find('.datatable-row-left[data-index="' + i.data("index") + '"]'));
        var r = i.find('input[type="checkbox"]');
        if (r.length && !r.is(":disabled")) {
            n === e && (n = !r.is(":checked")), a.isDataTable ? s.find('.datatable-row[data-index="' + i.data("index") + '"]').toggleClass("checked", n) : i.toggleClass("checked", n);
            var l = i.data("id");
            this.checkItems[l] = n, r.prop("checked", n).trigger("change"), o || (i.hasClass("table-parent") && s.find((a.isDataTable ? ".fixed-left " : "") + "tbody>tr.parent-" + l).each(function () {
                a.checkRow(t(this), n, !0)
            }), a.updateCheckUI())
        }
    }, r.prototype.updateCheckUI = function () {
        var e = this, i = e.getTable(),
            n = i.find(e.isDataTable ? ".fixed-left tbody>tr" : "tbody>tr").not(".group-summary"), o = !1, a = null,
            s = 0, r = !1, l = n.length;
        n.each(function (n) {
            var c = t(this), h = c.find('input[type="checkbox"]');
            if (!h.length) return void l--;
            r = h.is(":checked");
            var d = e.isDataTable ? i.find('.datatable-row[data-index="' + c.data("index") + '"]') : c;
            d.toggleClass("checked", r), d.toggleClass("row-check-begin", r && !o), a && a.toggleClass("row-check-end", !r && o), r && (s += 1), a = d, o = r, l === n + 1 && d.toggleClass("row-check-end", r)
        }), e.$.toggleClass("has-row-checked", s > 0).find(".check-all").toggleClass("checked", !(!l || s !== l)), e.updateStatistic(), e.options.onCheckChange && e.options.onCheckChange(), i.trigger("checkChange")
    }, r.DEFAULTS = {
        checkable: !0,
        checkOnClickRow: !0,
        ajaxForm: !1,
        selectable: !0,
        fixHeader: !a,
        fixFooter: !a,
        iframeWidth: 900,
        replaceId: "self",
        nestLevelIndent: 18,
        nested: !1,
        preserveNested: !0,
        hot: !1,
        iframeModalTrigger: ".iframe:not(.disabled,[disabled])"
    }, t.fn.table = function (e) {
        return this.each(function () {
            var n = t(this), o = n.data(i), a = "object" == typeof e && e;
            o || n.data(i, o = new r(this, a)), "string" == typeof e && o[e]()
        })
    }, r.NAME = i, t.fn.table.Constructor = r, t(function () {
        t('[data-ride="table"]').table()
    })
}(jQuery, void 0), function (t, e, i) {
    t.fn._ajaxForm = t.fn.ajaxForm;
    var n = {timeout: e.config ? e.config.timeout : 0, dataType: "json", method: "post"}, o = "";
    t.fn.enableForm = function (e, n, o) {
        return e === i && (e = !0), this.each(function () {
            var i = t(this);
            n || i.find('[type="submit"]').attr("disabled", e ? null : "disabled"), !o && i.hasClass("load-indicator") && i.toggleClass("loading", !e), i.toggleClass("form-disabled", !e)
        })
    }, t.enableForm = function (e, i, n, o) {
        "string" == typeof e || e instanceof t ? e = t(e) : (o = n, n = i, i = e, e = t("form")), e.enableForm(i !== !1, n, o)
    }, t.disableForm = function (e, i, n) {
        t.enableForm(e, !1, i, n)
    };
    var a = function (e, i, n) {
        i = i || "show", t.zui.messager ? (n ? n.html = !0 : n = {html: !0}, e = e.toString().replace(/\n/g, "<br/>"), t.zui.messager[i](e, n)) : alert(e)
    };
    t.ajaxForm = function (s, r) {
        var l = t(s);
        if (l.length > 1) return l.each(function () {
            t.ajaxForm(this, r)
        });
        "function" == typeof r && (r = {complete: r}), r = t.extend({}, n, l.data(), r);
        var c = r.beforeSubmit, h = r.error, d = r.success, u = r.finish;
        delete r.finish, delete r.success, delete r.onError, delete r.beforeSubmit, r = t.extend({
            beforeSubmit: function (n, a, s) {
                if ((c && c(n, a, s)) === !1) return !1;
                l.removeClass("form-watched").enableForm(!1);
                var r = {}, h = a.find('[type="file"]');
                r.fileapi = h.length && h[0].files !== i, r.formdata = e.FormData !== i;
                var d = r.fileapi && a.find('input[type="file"]:enabled').filter(function () {
                        return "" !== t(this).val()
                    }), u = d.length, p = "multipart/form-data", f = a.attr("enctype") == p || a.attr("encoding") == p,
                    g = r.fileapi && r.formdata, m = u && !g || f && !r.formdata;
                m && ("" == o && (o = s.url), s.url != o && (s.url = o), s.url = s.url.indexOf("&") >= 0 ? s.url + "&HTTP_X_REQUESTED_WITH=XMLHttpRequest" : s.url + "?HTTP_X_REQUESTED_WITH=XMLHttpRequest")
            }, success: function (i, n, o) {
                if ((d && d(i, n, o, l)) !== !1) {
                    try {
                        "string" == typeof i && (i = JSON.parse(i))
                    } catch (s) {
                    }
                    if (null === i || "object" != typeof i) return i ? alert(i) : a("No response.", "danger");
                    var c = r.responser ? t(r.responser) : l.find(".form-responser");
                    c.length || (c = t("#responser"));
                    var h = i.message, p = function () {
                        var n = i.callback;
                        if (n) if ("object" == typeof n) {
                            var o = n.target ? e[n.target] : e, a = o[n.name];
                            a.apply(l, Array.isArray(n.params) ? n.params : [n.params])
                        } else {
                            var s = n.indexOf("("), r = (s > 0 ? n.substr(0, s) : n).split("."), c = e, h = r[0];
                            r.length > 1 && (h = r[1], "top" === r[0] ? c = e.top : "parent" === r[0] && (c = e.parent));
                            var a = c[h];
                            if ("function" == typeof a) {
                                var d = [];
                                return s > 0 && ")" == n[n.length - 1] && (d = t.parseJSON("[" + n.substring(s + 1, n.length - 1) + "]")), d.push(i), a.apply(l, d)
                            }
                        }
                    };
                    if ("success" === i.result) {
                        var f = r.locate || i.locate, g = r.closeModal || i.closeModal,
                            m = r.ajaxReload || i.ajaxReload;
                        if (l.enableForm(!0, !!(f || g || m)), h) {
                            var v = l.find('[type="submit"]').first(), y = !1;
                            v.length && (v.popover({
                                container: "body",
                                trigger: "manual",
                                content: h,
                                tipClass: "popover-in-modal popover-success popover-form-result",
                                placement: i.placement || v.data("placement") || r.popoverPlacement || "right"
                            }).popover("show"), setTimeout(function () {
                                v.popover("destroy")
                            }, r.popoverTime || 2e3), y = !0), c.length && (c.html('<span class="small text-success">' + h + "</span>").show().delay(3e3).fadeOut(100), y = !0), y || a(h, "success")
                        }
                        if (u) return u(i, !0, l);
                        if (g && setTimeout(t.zui.closeModal, "number" == typeof g ? g : r.closeModalTime || 2e3), p() === !1) return;
                        if (f) if ("loadInModal" == f) {
                            var b = t(".modal");
                            setTimeout(function () {
                                b.load(b.attr("ref"), function () {
                                    t(this).find(".modal-dialog").css("width", t(this).data("width")), t.zui.ajustModalPosition()
                                })
                            }, 1e3)
                        } else "parent" === f || "top" === f ? e[f] && setTimeout(function () {
                            e[f].location.reload()
                        }, 1200) : "reload" === f ? setTimeout(function () {
                            e.location.href = e.location.href
                        }, 1200) : setTimeout(function () {
                            t.apps ? t.apps.open(f) : e.location.href = f
                        }, 1200);
                        if (m) {
                            var w = t(m);
                            w.length && w.load(e.location.href + " " + m, function () {
                                w.find('[data-toggle="modal"]').modalTrigger()
                            })
                        }
                    } else {
                        if (l.enableForm(), "string" == typeof h) c.length ? c.html('<span class="text-small text-red">' + h + "</span>").show().delay(3e3).fadeOut(100) : a(h, "danger"); else if ("object" == typeof h) {
                            var x = !1, C = [];
                            t.each(h, function (e, i) {
                                var n = t.isArray(i) ? i.join("") : i, o = t("#" + e);
                                if (!o.length) return void C.push(n);
                                var a = e + "Label", s = t("#" + a);
                                if (!s.length) {
                                    var r = o.closest(".input-group").length, l = o.closest("td").length;
                                    s = t('<div id="' + a + '" class="text-danger help-text" />').appendTo(l ? o.closest("td") : r ? o.closest(".input-group").parent() : o.parent())
                                }
                                s.empty().append(n), o.addClass("has-error");
                                var c = function () {
                                    var e = t("#" + a);
                                    if (e.length) return e.remove(), o.removeClass("has-error"), !0
                                };
                                o.on("change input mousedown", c);
                                var h = t("#" + e + "_chosen");
                                if (h.length && h.find(".chosen-single,.chosen-choices").addClass("has-error").on("mousedown", function () {
                                    c() === !0 && t(this).removeClass("has-error")
                                }), !x && !o.data("datetimepicker")) {
                                    var d = o[0];
                                    if (o.hasClass("chosen")) o.trigger("chosen:activate").trigger("chosen:open"), d = o.parent().find(".chosen-container")[0]; else if (o.is("textarea") && o.data("keditor")) {
                                        var u = o.data("keditor");
                                        u.focus(), u.edit.doc.body.focus(), d = o.parent().find(".ke-container")[0]
                                    } else o.focus();
                                    d.scrollIntoView && d.scrollIntoView(), x = !0
                                }
                            }), C.length && a(C.join(""), "danger")
                        }
                        if (u) return u(i, !1, l);
                        if (p() === !1) return
                    }
                }
            }, error: function (t, i, n) {
                if ((h && h(t, i, n, l)) !== !1) {
                    l.enableForm();
                    var o = "timeout" == i || "error" == i ? e.lang ? e.lang.timeout : i : t.responseText + i + n;
                    a(o, "danger")
                }
            }
        }, r), l._ajaxForm(r).data("zui.ajaxform", !0), l.on("click", "[data-form-action]", function () {
            l.attr("action", t(this).data("formAction")).submit()
        })
    }, t.setAjaxForm = function (e, i, n) {
        t.ajaxForm(e, t.isPlainObject(i) ? i : {finish: i, beforeSubmit: n})
    }, t.fn.ajaxForm = function (e) {
        return this.each(function () {
            t.ajaxForm(this, e)
        })
    }, t.fn.setInputRequired = function () {
        return this.each(function () {
            var e = t(this), i = e.parent();
            i.is(".input-control,td") ? i.addClass("required") : e.is(".chosen") ? e.attr("required", null).next(".chosen-container").addClass("required") : i.addClass("required"), e.attr("required", null);
            var n = i.closest(".input-group");
            n.length && 1 === n.find(".required,input[required],select[required]").length && n.addClass("required")
        })
    }, t(function () {
        t('.form-ajax,form[data-type="ajax"]').ajaxForm(), setTimeout(function () {
            var i = e.config.requiredFields, n = t("form");
            i && (i = i.split(",")), i && i.length && t.each(i, function (t, e) {
                n.find("#" + e).attr("required", "required")
            }), n.find("input[required],select[required],textarea[required]").setInputRequired()
        }, 400), t('form[target="hiddenwin"]').on("submit", function () {
            var e = t(this);
            e.data("zui.ajaxform") || e.enableForm(!1).data("disabledTime", (new Date).getTime())
        }).on("click", function () {
            var e = t(this), i = e.data("disabledTime");
            i && (new Date).getTime() - i > 1e4 && e.enableForm(!0).data("disabledTime", null)
        })
    })
}(jQuery, window, void 0), function (t) {
    "use strict";
    var e = "zui.searchList", i = function (t, e) {
        if (t && t.length) for (var i = 0; i < t.length; ++i) if (e.indexOf(t[i]) < 0) return !1;
        return !0
    }, n = function (i, o) {
        var a = this;
        a.name = e;
        var s = a.$ = t(i);
        o = a.options = t.extend({}, n.DEFAULTS, this.$.data(), o);
        var r = s.find(o.searchBox);
        r.length && (r.searchBox({
            onSearchChange: function (t) {
                a.search(t)
            }, onKeyDown: function (t) {
                console.log("onKeyDown", a);
                var e = t.which;
                if (13 === e) {
                    var i = a.getActiveItem();
                    console.log("activeItem", i, a), i.length && (o.onSelectItem ? o.onSelectItem(i) : window.location.href = i.attr("href")), t.preventDefault()
                } else if (38 === e) {
                    var i = a.getActiveItem();
                    i.removeClass("active");
                    for (var n = i.prev(); n.length && !n.is(".search-list-item:not(.hidden)");) n = n.prev();
                    n.length || (n = a.getItems().not(".hidden").last()), a.scrollTo(n.addClass("active")), t.preventDefault()
                } else if (40 === e) {
                    var i = a.getActiveItem();
                    i.removeClass("active");
                    for (var s = i.next(); s.length && !s.is(".search-list-item:not(.hidden)");) s = s.next();
                    s.length || (s = a.getItems().not(".hidden").first()), a.scrollTo(s.addClass("active")), t.preventDefault()
                }
            }, onFocus: function () {
                s.addClass("searchbox-focus")
            }, onBlur: function () {
                s.removeClass("searchbox-focus")
            }
        }), a.searchBox = r.data("zui.searchBox"), a.search(a.searchBox.getSearch()));
        var l = a.$menu = s.closest(".dropdown-menu");
        if (l.length) {
            a.isDropdown = !0, s.on("click", function (e) {
                t(e.target).closest(o.selector + ",[data-toggle]").length || e.stopPropagation()
            });
            var c = l.parent();
            c.on(c.hasClass("dropdown-hover") ? "mouseenter" : "shown.zui.dropdown", function () {
                a.tryLoadRemote(function () {
                    if (c.hasClass("dropup")) {
                        var t = null, e = c[0].getBoundingClientRect();
                        e.top < 220 && (t = Math.floor(e.top) - 57), l.find(".list-group").css("max-height", t)
                    }
                    setTimeout(function () {
                        a.searchBox && a.searchBox.focus()
                    }, 50)
                })
            })
        }
        s.on("mouseenter", o.selector, function () {
            s.find(a.options.selector).not(".hidden").removeClass("active"), t(this).addClass("active")
        })
    };
    n.prototype.tryLoadRemote = function (t) {
        var e = this, i = e.options;
        i.url || i.ajax ? e.isLoaded ? t() : e.loadRemote(t) : t()
    }, n.prototype.loadRemote = function (e) {
        var i = this, n = i.options;
        i.$menu.addClass("load-indicator loading").find(".list-group").remove(), i.isLoaded = !1, t.ajax(t.extend({
            url: n.url,
            type: "GET",
            dataType: "html",
            success: function (n, o, a) {
                var s = t(n);
                s.hasClass("list-group") || (s = t('<div class="list-group"></div>').append(s)), i.$menu.append(s), i.$menu.removeClass("loading"), i.isLoaded = !0, e && e(!0)
            },
            error: function () {
                i.$menu.removeClass("loading").append('<div class="list-group"><div class="text-error has-padding">' + (n.errorText || window.lang && window.lang.timeout) + "</div></div>"), e && e(!1)
            }
        }, n.ajax))
    }, n.prototype.scrollTo = function (t) {
        t.length && t[0].scrollIntoViewIfNeeded && t[0].scrollIntoViewIfNeeded({behavior: "smooth"})
    }, n.prototype.getItems = function () {
        return this.$.find(this.options.selector).addClass("search-list-item")
    }, n.prototype.getActiveItem = function () {
        return this.getItems().filter(".active:first")
    }, n.prototype.search = function (e) {
        var n = this, o = void 0 === e || null === e || "" === e;
        n.$.toggleClass("has-search-text", !o);
        var a = n.getItems().removeClass("active");
        if (o) a.removeClass("hidden"); else {
            var s = e.trim().split(" ");
            a.each(function () {
                var e = t(this), n = (e.text() + " " + (e.data("key") || e.data("filter") || "")).trim();
                e.toggleClass("hidden", !i(s, n))
            })
        }
        n.scrollTo(a.not(".hidden").first().addClass("active")), n.$.trigger("onSearchComplete", e)
    }, n.DEFAULTS = {
        selector: ".list-group a:not(.not-list-item)",
        searchBox: ".search-box",
        onSelectItem: null
    }, t.fn.searchList = function (i) {
        return this.each(function () {
            var o = t(this), a = o.data(e), s = "object" == typeof i && i;
            a || o.data(e, a = new n(this, s)), "string" == typeof i && a[i]()
        })
    }, n.NAME = e, t.fn.searchList.Constructor = n, t(function () {
        t('[data-ride="searchList"]').searchList()
    })
}(jQuery), function (t) {
    "use strict";
    var e = "zui.labelSelector", i = function (n, o) {
        var a = this;
        a.name = e, a.$ = t(n), o = a.options = t.extend({}, i.DEFAULTS, this.$.data(), o), a.$.hide(), a.update()
    };
    i.prototype.select = function (t) {
        t += "", this.$wrapper.find(".label.active").removeClass("active"), this.$wrapper.find('.label[data-value="' + t + '"]').addClass("active"), this.$.val(t).trigger("change")
    }, i.prototype.update = function () {
        var e = this, i = e.options, n = e.$wrapper;
        if (!n) {
            if (i.wrapper) n = t(i.wrapper); else {
                var o = e.$.next();
                n = o.hasClass(".label-selector") ? o : t('<div class="label-selector"></div>')
            }
            n.parent().length || e.$.after(n), e.$wrapper = n, n.on("click", ".label", function (i) {
                var n = e.$.val(), o = t(this).data("value");
                e.hasEmptyValue !== !1 && o == n && (o = e.hasEmptyValue), e.select(o), i.preventDefault()
            })
        }
        n.empty();
        var a = e.$.val();
        e.hasEmptyValue = !1, e.$.children("option").each(function () {
            var e = t(this), o = {label: e.text(), value: e.val()}, s = ("" === o.value || "0" === o.value) && !o.label,
                r = t(i.labelTemplate || '<span class="label"></span>');
            i.labelClass && !s && r.addClass(i.labelClass), i.labelCreator ? r = i.labelCreator(r) : (r.data("option", o).attr("data-value", o.value), s ? r.addClass("empty").append('<i class="icon icon-close"></i>') : r.text(o.label).toggleClass("active", a === o.value)), n.append(r)
        })
    }, i.DEFAULTS = {}, t.fn.labelSelector = function (n) {
        return this.each(function () {
            var o = t(this), a = o.data(e), s = "object" == typeof n && n;
            a || o.data(e, a = new i(this, s)), "string" == typeof n && a[n]()
        })
    }, i.NAME = e, t.fn.labelSelector.Constructor = i, t(function () {
        t('[data-provide="labelSelector"]').labelSelector()
    })
}(jQuery), function (t) {
    "use strict";
    var e = "zui.fileInput", i = t.BYTE_UNITS = {B: 1, KB: 1024, MB: 1048576, GB: 1073741824, TB: 1099511627776},
        n = t.formatBytes = function (t, e, n) {
            return void 0 === e && (e = 2), n || (n = t < i.KB ? "B" : t < i.MB ? "KB" : t < i.GB ? "MB" : t < i.TB ? "GB" : "TB"), (t / i[n]).toFixed(e) + n
        }, o = function (t) {
            if ("string" == typeof t) {
                t = t.toUpperCase();
                var e = t.replace(/\d+/, "");
                t = parseFloat(t.replace(e, "")), t *= i[e] || i[e + "B"], t = Math.floor(t)
            }
            return t
        }, a = function (i, n) {
            var s = this;
            s.name = e;
            var r = s.$ = t(i);
            n = s.options = t.extend({}, a.DEFAULTS, this.$.data(), n), n.fileMaxSize && "string" == typeof n.fileMaxSize && (n.fileMaxSize = o(n.fileMaxSize));
            var l = s.$input = r.find('input[type="file"]');
            if (n.file instanceof File) {
                var c = new DataTransfer;
                c.items.add(n.file), l.prop("files", c.files), l.trigger("change")
            }
            r.on("click", ".file-input-rename", function () {
                s.oldName = r.addClass("edit").find(".file-editbox").focus().val(), t.fn.fixInputGroup && r.find(".input-group,.btn-group").fixInputGroup()
            }).on("click", ".file-input-delete", function () {
                l.val(""), s.update(), n.onDelete && n.onDelete(s)
            }).on("click", ".file-name-cancel", function () {
                r.removeClass("edit").find(".file-editbox").focus().val(s.oldName)
            }).on("click", ".file-name-confirm", function () {
                var e = r.find(".file-editbox"), i = t.trim(e.val());
                i.length ? r.removeClass("edit").find(".file-title").text(i).attr("title", i) : e.focus()
            }).on("change input paste", ".file-editbox", function () {
                var e = t(this);
                e.attr("size", Math.max(5, e.val().length))
            }), s.update()
        };
    a.prototype.update = function () {
        var t = this, e = t.$, i = t.options.file, o = !i;
        e.toggleClass("normal", !o).toggleClass("empty", o), i ? (t.oldName = i.name, e.find(".file-title").text(i.name).attr("title", i.name), e.find(".file-size").text(n(i.size)), e.find(".file-editbox").val(i.name).attr("size", i.name.length), t.options.onSelect && t.options.onSelect(i, t)) : e.find(".file-editbox").val("")
    }, a.DEFAULTS = {fileMaxSize: 0, fileSizeError: "无法上传大于 {0} 的文件。"}, t.fn.fileInput = function (i) {
        return this.each(function () {
            var n = t(this), o = n.data(e), s = "object" == typeof i && i;
            o || n.data(e, o = new a(this, s)), "string" == typeof i && o[i]()
        })
    }, a.NAME = e, t.fn.fileInput.Constructor = a;
    var s = "zui.fileInputList", r = function (e, i) {
        var o = this;
        o.name = s;
        var a = o.$ = t(e), l = a.find("#file-input-multiple");
        a.on("click", ".file-input-btn", function () {
            l.trigger("click")
        }), o.$template = a.find(".file-input").detach(), i = o.options = t.extend({}, r.DEFAULTS, o.$.data(), i), l.on("change", function () {
            for (var t = l.prop("files"), e = [], a = 0; a < t.length; a++) {
                var s = t[a];
                s && i.fileMaxSize && s.size > i.fileMaxSize || e.push(s)
            }
            t.length != e.length && (window.bootbox || window).alert(i.fileSizeError.format(n(i.fileMaxSize))), e.forEach(function (t) {
                o.add(t)
            })
        })
    };
    r.prototype.add = function (t) {
        var e = this, i = e.options, n = e.$template.clone();
        "before" === i.appendWay ? e.$.prepend(n) : e.$.append(n), n.fileInput({
            file: t,
            fileMaxSize: i.eachFileMaxSize,
            fileSizeError: i.fileSizeError,
            onDelete: function (t) {
                t.$.remove(), e.options.onDelete && e.options.onDelete(t, e)
            },
            onSelect: function (t, i) {
                e.options.onSelect && e.options.onSelect(t, i, e)
            }
        })
    }, r.DEFAULTS = {
        fileMaxSize: 0,
        eachFileMaxSize: 0,
        appendWay: "after",
        fileSizeError: "无法上传大于 {0} 的文件。"
    }, t.fn.fileInputList = function (e) {
        return this.each(function () {
            var i = t(this), n = i.data(s), o = "object" == typeof e && e;
            n || i.data(s, n = new r(this, o)), "string" == typeof e && n[e]()
        })
    }, r.NAME = s, t.fn.fileInputList.Constructor = r, t(function () {
        t('[data-provide="fileInputList"]').fileInputList()
    })
}(jQuery), function (t) {
    window.config || (window.config = {}), t.createLink = window.createLink = function (e, n, o, a, s, r, l, c) {
        if ("object" == typeof e) return t.createLink(e.moduleName, e.methodName, e.vars, e.viewType, e.isOnlyBody, e.hash, e.tid, e.params);
        if (c && (c.tid & !l && (l = c.tid), void 0 !== c.isOnlyBody && void 0 === s && (s = c.isOnlyBody)), t.tabSession && !l && (l = t.tabSession.getTid()), a || (a = config.defaultView), s || (s = !1), o) for ("string" == typeof o && (o = o.split("&")), i = 0; i < o.length; i++) if ("string" == typeof o[i]) {
            var h = o[i].split("=");
            o[i] = [h.shift(), h.join("=")]
        }
        var d, u = "GET" === config.requestType;
        if (u) {
            if (d = config.router + "?" + config.moduleVar + "=" + e + "&" + config.methodVar + "=" + n, o) for (i = 0; i < o.length; i++) d += "&" + o[i][0] + "=" + o[i][1];
            d += "&" + config.viewVar + "=" + a
        } else {
            if ("PATH_INFO" == config.requestType && (d = config.webRoot + e + config.requestFix + n), "PATH_INFO2" == config.requestType && (d = config.webRoot + "index.php/" + e + config.requestFix + n), o) for (i = 0; i < o.length; i++) d += config.requestFix + o[i][1];
            d += "." + a
        }
        if (void 0 !== config.onlybody && "yes" == config.onlybody || s) {
            var p = (u ? "&" : "?") + "onlybody=yes";
            d += p
        }
        return c && t.each(c, function (t, e) {
            "tid" !== t && "isOnlyBody" !== t && "$" !== t[0] && (d = d + (!u && d.indexOf("?") < 0 ? "?" : "&") + t + "=" + e)
        }), l && config.tabSession && (d = d + (!u && d.indexOf("?") < 0 ? "?" : "&") + "tid=" + l), d + (r ? ("#" === r[0] ? "" : "#") + r : "")
    }, t(function () {
        var e = t("#main,#mainContent,#mainRow,.auto-fade-in");
        e.length && e.hasClass("fade") && setTimeout(function () {
            e.addClass("in")
        }, e.data("fadeTime") || 200)
    }), t.ajaxSendScore = function (e) {
        t.get(t.createLink("score", "ajax", "method=" + e))
    };
    var e = function (t) {
        var e = 0;
        if (t) {
            var i = t.split(":");
            e += 60 * parseInt(i[0]), e += parseInt(i[1])
        }
        return e
    }, n = function (t) {
        t %= 1440;
        var e = Math.floor(t / 60), i = t % 60;
        return e < 10 && (e = "0" + e), i < 10 && (i = "0" + i), e + ":" + i
    }, o = function (t) {
        if ("string" == typeof t && (t = e(t)), "number" == typeof t) if (t < 1e5) {
            var i = new Date;
            i.setHours(Math.floor(t / 60) % 24), i.setMinutes(t % 60), t = i
        } else t = new Date(t);
        return t
    }, a = function (t, i) {
        for (var a = i ? o(i) : new Date, s = a.getHours(), r = 10 * Math.floor(a.getMinutes() / 10) + 10, l = 0; l < 24; ++l) {
            var c = (l + s) % 24;
            if (!(c < 5)) for (var h = 0; h < 6; ++h) {
                var d = n(60 * c + 10 * h + r);
                t.append('<option value="' + d + '">' + d + "</option>")
            }
        }
        t.val() || (time = e(a.format("hh:mm")), time = time - time % 10 + 10, t.val(n(time)))
    };
    t.fn.timeSpanControl = function (i) {
        return this.each(function () {
            var s = t(this), r = t.extend({}, i, s.data()), l = s.find('[name="begin"],.control-time-begin'),
                c = s.find('[name="end"],.control-time-end'), h = function () {
                    var t = l.val();
                    if (s.find(".hide-empty-begin").toggleClass("hide", !t), t) {
                        var i = n(e(t) + 30);
                        c.find('option[value="' + i + '"]').length && c.val(i), r.onChange && r.onChange(c, i)
                    }
                };
            if (s.data("timeSpanControlInit")) {
                if (r.begin) {
                    var d = o(r.begin).format("hh:mm");
                    l.find('option[value="' + d + '"]').length && l.val(d), r.onChange && r.onChange(l, d)
                }
                if (r.end) {
                    var u = o(r.end).format("hh:mm");
                    c.find('option[value="' + u + '"]').length && c.val(u), r.onChange && r.onChange(c, u)
                }
            } else l.on("change", h), a(l, r.begin), a(c, r.end), s.data("timeSpanControlInit", !0);
            r.end || h()
        })
    }, t.timeSpanControl = {convertTimeToNum: e, convertNumToTime: n, initTimeSelect: a, createTime: o};
    var s = t.setSearchType = function (e, i) {
        var n = t("#searchType");
        e || (e = n.val()), e = e || "bug", n.val(e);
        var o = t("#searchTypeMenu");
        o.find("li.selected").removeClass("selected");
        var a = o.find('a[data-value="' + e + '"]'), s = a.text();
        a.parent().addClass("selected"), t("#searchTypeName").text(s), i || t("#searchInput").focus()
    };
    t.gotoObject = function (e, i) {
        if (e || (e = t("#searchType").val()), i || (i = t("#searchInput").val()), i && e) if (i = i.replace(/[^\d]/g, "")) {
            var n = e.split("-");
            e = n[0];
            var o = n.length > 1 ? n[1] : "testsuite" === e ? "library" : "view", a = t.createLink(e, o, "id=" + i);
            t.apps ? t.apps.open(a) : window.location.href = a
        } else {
            var s = {zh_cn: "请输入数字ID进行搜索", zh_tw: "請輸入數值ID行搜索"};
            alert(lang.searchTip || s[t.zui.clientLang()] || "Please enter a numberic id to search")
        }
        t("#searchInput").val(i).focus()
    }, t(function () {
        s(null, !0), t(document).on("keydown", function (e) {
            e.ctrlKey && 71 === e.keyCode && (t("#searchInput").val("").focus(), e.stopPropagation(), e.preventDefault())
        })
    }), t.removeAnchor = window.removeAnchor = function (t) {
        var e = t.lastIndexOf("#");
        return e > -1 ? t.substr(0, e) : t
    }, t.refreshPage = function (t) {
        t ? window.top.location.reload() : window.location.reload()
    }, t.selectLang = window.selectLang = function (e) {
        t.cookie("lang", e, {
            expires: config.cookieLife,
            path: config.webRoot
        }), t.ajaxSendScore("selectLang"), t.refreshPage(1)
    }, t.selectTheme = window.selectTheme = function (e) {
        t.cookie("theme", e, {
            expires: config.cookieLife,
            path: config.webRoot
        }), t.ajaxSendScore("selectTheme"), t.refreshPage(1)
    }, t.zui.Picker && (t.extend(t.zui.Picker.DEFAULTS, {
        optionRender: function (e, i, n) {
            if ("user" === n.options.type) {
                var o = n.options.users;
                if (!o) return;
                var a = o[i.value];
                if (!a) return;
                if (e.find(".picker-option-text").text(a.realname || a.account), e.hasClass("picker-user-option")) return;
                return e.prepend(t('<div class="avatar ' + (n.options.userAvatarClass || "avatar-sm") + ' avatar-circle"/>').avatar({user: a})), a.deptName && e.append(t('<span class="dept-name"></span>').text(a.deptName)), a.roleName && e.append(t('<span class="role-name"></span>').text(a.roleName)), e.addClass("picker-user-option")
            }
        }, checkable: !0, maxListCount: 500, disableScrollOnShow: !1
    }), t.zui.setUserPickerInfos = function (e) {
        t.zui.Picker.DEFAULTS.users = t.extend({}, t.zui.Picker.DEFAULTS.users, e)
    }, t(function () {
        t(".picker-select[data-pickertype!='remote']").picker({chosenMode: !0}), t("[data-pickertype='remote']").each(function () {
            var e = t(this).attr("data-pickerremote");
            t(this).picker({chosenMode: !0, remote: e})
        }), window.pickerUsers && t.zui.setUserPickerInfos(window.pickerUsers), t(".user-picker").picker({type: "user"})
    })), t.chosenDefaultOptions = {
        middle_highlight: !0,
        disable_search_threshold: 1,
        compact_search: !0,
        allow_single_deselect: !0,
        placeholder_text_single: " ",
        placeholder_text_multiple: " ",
        search_contains: !0,
        max_drop_width: 500,
        max_drop_height: 245,
        no_wrap: !0,
        drop_direction: function () {
            var e = t(this.container).closest(".table-responsive:not(.scroll-none)");
            if (e.length) {
                if (this.drop_directionFixed) return this.drop_directionFixed;
                e.css("position", "relative");
                var i = "down", n = this.container.find(".chosen-drop"), o = this.container.position(),
                    a = n.outerHeight();
                return o.top >= a && o.top + 31 + a > e.outerHeight() && (i = "up"), this.drop_directionFixed = i, i
            }
            return "auto"
        }
    }, t.chosenSimpleOptions = t.extend({}, t.chosenDefaultOptions, {disable_search_threshold: 6}), t.fn._chosen = t.fn.chosen, t.fn.chosen = function (e) {
        return "string" == typeof e ? this._chosen(e) : this.each(function () {
            var i = t(this).addClass("chosen-controled");
            return i._chosen(t.extend({}, i.hasClass("chosen-simple") ? t.chosenSimpleOptions : t.chosenDefaultOptions, i.data(), e))
        })
    }, t.fn.chosen.Constructor = t.fn._chosen.Constructor, t(function () {
        t(".chosen,.chosen-simple").each(function () {
            var e = t(this);
            e.closest(".template").length || e.chosen()
        })
    }), t.extend(t.fn.pager.Constructor.DEFAULTS, {
        maxNavCount: 8,
        prevIcon: "icon-angle-left",
        nextIcon: "icon-angle-right",
        firstIcon: "icon-first-page",
        lastIcon: "icon-last-page",
        navEllipsisItem: "…",
        menuDirection: "dropup",
        pageSizeOptions: [5, 10, 15, 20, 25, 30, 35, 40, 45, 50, 100, 200, 500, 1e3, 2e3],
        elements: ["total_text", "size_menu", "first_icon", "prev_icon", '<div class="pager-label"><strong>{page}</strong>/<strong>{totalPage}</strong></div>', "next_icon", "last_icon"],
        onPageChange: function (e, i) {
            e.recPerPage !== i.recPerPage && t.cookie(this.options.pageCookie, e.recPerPage, {
                expires: config.cookieLife,
                path: config.webRoot
            }), e.recPerPage !== i.recPerPage && (window.location.href = this.createLink())
        }
    }), t.extend(!0, t.zui.Messager.DEFAULTS, {
        cssClass: "messagger-zt",
        icons: {success: "check-circle", info: "chat-line", warning: "exclamation-sign", danger: "exclamation-sign"}
    }), t.fn.reverseOrder = function () {
        return this.each(function () {
            var e = t(this);
            e.prependTo(e.parent())
        })
    };
    var r = function (e, i) {
        var n = t(e);
        if (!n.data("historiesInited")) {
            n.data("historiesInited", 1), i = t.extend({}, n.data(), i);
            var o = n.find(".histories-list"), a = !0, s = !1;
            n.on("click", ".btn-reverse", function () {
                o.children("li").reverseOrder(), a = !a, t(this).find(".icon").toggleClass("icon-arrow-up", a).toggleClass("icon-arrow-down", !a);
                var e = "#lastComment", i = t(e);
                i.length && window.KindEditor && (window.KindEditor.remove(e), i.kindeditor())
            }).on("click", ".btn-expand-all", function () {
                var e = t(this).find(".icon");
                s = !s, e.toggleClass("icon-plus", !s).toggleClass("icon-minus", s), o.children("li").toggleClass("show-changes", s)
            }).on("click", ".btn-expand", function () {
                t(this).closest("li").toggleClass("show-changes")
            }).on("click", ".btn-strip", function () {
                var e = t(this), n = e.find(".icon"), o = n.hasClass("icon-code");
                n.toggleClass("icon-code", !o).toggleClass("icon-text", o), e.attr("title", o ? i.original : i.textdiff), e.closest("li").toggleClass("show-original", o)
            }), o.find(".btn-strip").attr("title", i.original);
            var r = n.find(".modal-comment").modal({show: !1}).on("shown.zui.modal", function () {
                var t = r.find("#comment");
                t.length && (t.focus(), window.editor && window.editor.comment && window.editor.comment.focus())
            }).on("show.zui.modal", function () {
                var e = r.find("#comment");
                e.length && !e.data("keditor") && t.fn.kindeditor && e.kindeditor()
            });
            n.on("click", ".btn-comment", function (t) {
                r.modal("toggle"), t.preventDefault()
            }).on("click", ".btn-edit-comment,.btn-hide-form", function () {
                t(this).closest("li").toggleClass("show-form")
            });
            var l = n.find(".comment-edit-form");
            l.ajaxForm({
                success: function (t, e, i, n) {
                    setTimeout(function () {
                        l.closest("li").removeClass("show-form")
                    }, 2e3)
                }
            })
        }
    };
    t.fn.histories = function (t) {
        return this.each(function () {
            r(this, t)
        })
    }, t(function () {
        t(".histories").histories()
    });
    var l = 0, c = 0;
    t.toggleSidebar = function (e) {
        var i = t("#sidebar");
        if (i.length) {
            var n = t("main");
            if (void 0 === e) e = n.hasClass("hide-sidebar"); else if (e && !n.hasClass("hide-sidebar")) return;
            n.toggleClass("hide-sidebar", !e), clearTimeout(l), t.zui.store.set(c, e);
            var o = i.children(".cell"), a = {overflow: "visible", maxHeight: "initial"};
            e ? (i.addClass("showing"), l = setTimeout(function () {
                i.removeClass("showing"), i.trigger("sidebar.toggle", e)
            }, 210)) : (i.trigger("sidebar.toggle", e), t(window).width() < 1900 && (a = {
                overflow: "hidden",
                maxHeight: t(window).height() - 45
            })), o.css(a)
        }
    };
    var h = t.initSidebar = function () {
        var e = t("#sidebar");
        if (e.length) {
            if (e.data("init")) return !0;
            c = "sidebar:" + (e.data("id") || config.currentModule + "/" + config.currentMethod);
            var i = t("main");
            if (i.length) {
                i.on("click", ".sidebar-toggle", function () {
                    t.toggleSidebar(i.hasClass("hide-sidebar"))
                });
                var n = t.zui.store.get(c, e.data("hide") !== !1);
                n === !1 && e.addClass("no-animate"), t.toggleSidebar(n), n === !1 && setTimeout(function () {
                    e.removeClass("no-animate")
                }, 500);
                var o = e.find(".sidebar-toggle");
                if (o.length) {
                    var a = function () {
                        var e = o[0].getBoundingClientRect(), i = t(window).height(),
                            n = Math.max(0, Math.floor(Math.min(i - 40, e.top + e.height) - Math.max(e.top, 0)) / 2) + (e.top < 0 ? 0 - e.top : 0);
                        o.removeClass("fade").find(".icon").css("top", n + (t.zui.browser.isIE() ? (i - 80) / 2 : 0))
                    };
                    a(), e.data("init", 1).on("sidebar.toggle", a);
                    var s = t.zui.browser.isIE() ? 1500 : 0, r = 0, l = null, h = function () {
                        var t = Date.now();
                        return l && (clearTimeout(l), l = null), t - r < s ? (l = setTimeout(h, s / 2), void o.addClass("fade")) : (r = t, void a())
                    };
                    return t(window).on("resize scroll", s ? h : a), !0
                }
            }
        }
    };
    h() || t(h), t.toggleQueryBox = function (e, i) {
        var n = t(i || "#queryBox");
        if (n.length) {
            if (void 0 === e && (e = !n.hasClass("show")), n.toggleClass("show", !!e), !n.data("init")) {
                n.addClass("load-indicator loading").data("init", 1);
                var o = n.data("url") || t.createLink("search", "buildForm", n.data("module") ? "module=" + n.data("module") : "");
                t.get(o, function (t) {
                    n.html(t).removeClass("loading")
                })
            }
            t(".querybox-toggle").toggleClass("querybox-opened", e)
        }
    }, t(function () {
        var e = t("#queryBox");
        e.length && (t(document).on("click", ".querybox-toggle", function () {
            t.toggleQueryBox()
        }), e.hasClass("show") && t.toggleQueryBox(!0))
    }), t.extend(t.fn.colorPicker.Constructor.DEFAULTS, {colors: ["#3DA7F5", "#75C941", "#2DBDB2", "#797EC9", "#FFAF38", "#FF4E3E"]}), window.setCheckedCookie = function () {
        var e = [], i = t('#mainContent .main-table tbody>tr input[type="checkbox"]:checked');
        i.each(function () {
            var i = parseInt(t(this).val(), 10);
            NaN !== i && e.push(i)
        }), t.cookie("checkedItem", e.join(","), {expires: config.cookieLife, path: config.webRoot})
    }, t.extend(t.fn.modal.bs.Constructor.DEFAULTS, {
        scrollInside: !0,
        backdrop: "static",
        headerHeight: 100
    }), t.extend(t.zui.ModalTrigger.DEFAULTS, {
        scrollInside: !0,
        backdrop: "static"
    }), t.fn.initIframeModal = function () {
        return this.each(function () {
            var e = t(this);
            if (!e.is("[disabled],.disabled") && !e.parents('[data-ride="table"],.skip-iframe-modal').length) {
                var i = {type: "iframe"};
                e.hasClass("export") && t.extend(i, {width: 800, shown: setCheckedCookie}, e.data()), e.modalTrigger(i)
            }
        })
    }, t(function () {
        t("a.iframe,.export").initIframeModal()
    }), t.fixedTableHead = window.fixedTableHead = function (e, i) {
        var n = t(e);
        if (n.is("table") || (n = n.find("table")), n.length) {
            var o = t(i || window), a = null, s = function () {
                var e = n.children("thead"), i = e[0].getBoundingClientRect(), o = n.next(".fixed-head-table");
                if (i.top < 0) {
                    var s = e.width();
                    if (o.length) {
                        if (a !== s) {
                            a = s;
                            var r = o.find("th");
                            e.find("th").each(function (e) {
                                r.eq(e).width(t(this).width())
                            })
                        }
                    } else {
                        var o = t("<table class='table fixed-head-table' style='position:fixed; top: 0;'></table>").addClass(n.attr("class")),
                            l = e.clone(), r = l.find("th");
                        e.find("th").each(function (e) {
                            r.eq(e).width(t(this).width())
                        }), o.append(l).insertAfter(n)
                    }
                    o.css({left: i.left, width: i.width}).show()
                } else o.hide()
            };
            o.on("scroll", s).on("resize", s), s()
        }
    }, t(document).on("click", "tr[data-url]", function () {
        var e = t(this), i = e.data("href") || e.data("url");
        i && (window.location.href = i)
    }), "yes" === config.onlybody && self === parent && (window.location.href = window.location.href.replace("?onlybody=yes", "").replace("&onlybody=yes", "")), t(function () {
        t("body").addClass("m-{currentModule}-{currentMethod}".format(config))
    });
    var d, u, p, f, g, m = function () {
        d || (d = t("#subNavbar"), u = t("#pageNav"), p = t("#pageActions"), f = d.children(".nav"), g = f.outerWidth());
        var e = d.outerWidth(), i = u.outerWidth() || 0, n = p.outerWidth() || 0;
        if (i = i ? i + 15 : 0, n = n ? n + 15 : 0, !i && !n) return void f.css({
            maxWidth: null,
            left: null,
            position: "static"
        });
        var o = Math.max(300, e - i - n), a = Math.min(o, g), s = (e - a) / 2,
            r = i && s < i ? i : n && s < n ? e - a - n : 0;
        f.css({maxWidth: o, left: r ? r - s : 0, position: "relative"})
    }, v = function () {
        t.cookie("windowWidth", window.innerWidth), t.cookie("windowHeight", window.innerHeight), m()
    };
    t(v), t(window).on("resize", v);
    var y = function () {
        var e = t("#back").attr("href");
        e && (window.location.href = e)
    }, b = function () {
        t.cookie("ajax_lastNext") || (t.cookie("ajax_lastNext", "on", {
            expires: config.cookieLife,
            path: config.webRoot
        }), t.ajaxSendScore("lastNext"))
    };
    t(document).on("keydown", function (e) {
        if (!t("body").hasClass("modal-open") && !t(e.target).closest("input,textarea").length) if (e.altKey && 38 === e.keyCode) y(); else if (37 === e.keyCode) {
            var i = t("#prevPage").attr("href");
            i && (window.location.href = i), b()
        } else if (39 === e.keyCode) {
            var n = t("#nextPage").attr("href");
            n && (window.location.href = n), b()
        }
    }), t.fn.tree.Constructor.DEFAULTS.initialState = "preserve", t.closeModal = function (e, i, n) {
        t.zui.closeModal(n, e, i)
    }, t.getThemeColor = function (e) {
        if (!t.themeColor) {
            var i = t("#mainHeader");
            i.length && (t.themeColor = {
                primary: i.css("border-top-color"),
                pale: i.css("border-bottom-color"),
                secondary: i.css("background-color")
            })
        }
        return e ? t.themeColor && t.themeColor[e] : t.themeColor
    };
    var w = function (e) {
        var i = t(e);
        if (!i.hasClass("header-angle-btn") && !i.hasClass("not-fix-input-group")) {
            var n, o,
                a = i.children(".input-group-addon,.form-control:not(.chosen-controled),.chosen-container,.btn,.input-control,.input-group-btn,.datepicker-wrapper").not(".hidden"),
                s = 1 === a.length;
            a.each(function (e) {
                var i = t(this),
                    r = i.is(".input-group-addon") ? "addon" : i.is(".chosen-container") ? "chosen" : i.is(".btn") ? "btn" : i.is(".input-control,.datepicker-wrapper") ? "insideInput" : i.is(".input-group-btn") ? "insideBtn" : "input",
                    l = {};
                if (s) l.borderTopLeftRadius = 2, l.borderBottomLeftRadius = 2, l.borderTopRightRadius = 2, l.borderBottomRightRadius = 2; else {
                    var c = !n, h = e === a.length - 1, d = "btn" === r ? 4 : 2;
                    l.borderTopLeftRadius = 0, l.borderBottomLeftRadius = 0, l.borderTopRightRadius = 0, l.borderBottomRightRadius = 0, c && ("addon" === r && (l.borderLeftWidth = 1), l.borderTopLeftRadius = d, l.borderBottomLeftRadius = d), h && ("addon" === r && (l.borderRightWidth = 1), l.borderTopRightRadius = d, l.borderBottomRightRadius = d), o && ("chosen" !== o && "input" !== o && "btn" !== o && "insideInput" !== o && "insideBtn" !== o || "chosen" !== r && "input" !== r && "btn" !== r && "insideInput" !== r && "insideBtn" !== r ? "addon" === o && "addon" === r && (l.borderLeftWidth = 1) : l.borderLeftColor = "transparent")
                }
                ("insideBtn" === r ? i.find(".btn") : "insideInput" === r ? i.find(".form-control") : "chosen" === r ? i.find(".chosen-single,.chosen-choices") : i).css(l), n = i, o = r
            })
        }
    };
    t.fn.fixInputGroup = function () {
        return this.each(function () {
            w(this)
        })
    };
    var x = function () {
        var e = t(".main-actions>.btn-toolbar");
        if (e.length) {
            var i, n, o = e.children(), a = o.length, s = !1, r = null;
            if (a) for (o.each(function (e) {
                i = t(this), n = i.is(".divider"), n && !r && i.hide(), s || n || (s = !0), r = n ? null : i, !n || e !== a - 1 && 0 !== e || i.hide()
            }); i.length && i.is(".divider");) i = i.hide().prev();
            s || e.hide()
        }
    };
    t(function () {
        t(".input-group,.btn-group").fixInputGroup(), x()
    }), window.holders && t.each(window.holders, function (e) {
        var i = t("#" + e);
        i.length && i.is("input") && i.attr("placeholder", window.holders[e])
    }), t(function () {
        var e = t(".table-responsive"), i = t.fixTableResponsive = function () {
            e.each(function () {
                this.scrollHeight - 3 <= this.clientHeight && this.scrollWidth - 3 <= this.clientWidth ? t(this).addClass("scroll-none").css("overflow", "visible") : t(this).removeClass("scroll-none").css("overflow", "auto")
            })
        };
        e.length && (t(window).on("resize", i), setTimeout(i, 100))
    });
    var C = function () {
        var e = this, i = t(e), n = i.closest("tr").find("textarea");
        if (n.length) {
            var o = 32;
            n.each(function () {
                var e = t(this).closest("td"), i = e.css("height");
                e.css("height", this.style.height), this.style.height = "auto";
                var n = this.value ? this.scrollHeight + 2 : 32;
                o = Math.max(o, n), e.css("height", i)
            }), n.css("height", o)
        } else {
            e.style.height = "auto";
            var a = e.value ? e.scrollHeight + 2 : 32;
            e.style.height = a + "px"
        }
    };
    t.autoResizeTextarea = function (e) {
        t(e).each(C)
    }, t(function () {
        t("textarea.autosize").each(C), t(document).on("input paste change", "textarea.autosize", C)
    }), t(function () {
        var e = t("#dropMenu,.drop-menu");
        e.length && e.on("click", ".toggle-right-col", function (e) {
            t(this).closest("#dropMenu,.drop-menu").toggleClass("show-right-col"), e.stopPropagation(), e.preventDefault()
        })
    });
    var _ = "undefined" != typeof InstallTrigger;
    t.zui.browser.firefox = _, t("html").toggleClass("is-firefox", _).toggleClass("not-firefox", !_), t(function () {
        var e = t("#mainContent>.main-col"), i = e.children(".main-actions");
        if (i.length) {
            var n = i.prev();
            if (i.length && n.length) {
                t('<div class="main-actions-holder"></div>').css("height", i.outerHeight()).insertAfter(i);
                var o = 0, a = function () {
                    var e = n[0].getBoundingClientRect(), s = e.top + e.height + 120 > t(window).height();
                    if (t("body").toggleClass("main-actions-fixed", s), s) {
                        var r = n.width();
                        r ? i.width(r) : o < 10 && setTimeout(a, 1e3)
                    }
                    o++
                };
                t.resetToolbarPosition = a, a(), t(window).on("resize scroll", a)
            }
        }
    }), t(document).on("show.zui.modal", function (e) {
        t("body.body-modal").length && window.parent && window.parent !== window && t(e.target).is(".modal") && window.parent.$("body").addClass("hide-modal-close")
    }).on("hidden.zui.modal", function (e) {
        t("body.body-modal").length && window.parent && window.parent !== window && window.parent.$("body").removeClass("hide-modal-close")
    }).on("loaded.zui.modal", function (e) {
        t("body").removeClass("hide-modal-close")
    }), t(function () {
        var e = t(".dropdown-menu.with-search");
        e.length && (e.find(".menu-search").on("click", function (t) {
            return t.stopPropagation(), !1
        }), e.on("keyup change paste", "input", function () {
            var e = t(this), i = e.closest(".dropdown-menu.with-search"), n = e.val().toLowerCase(),
                o = i.find(".option");
            "" == n ? o.removeClass("hide") : o.each(function () {
                var e = t(this);
                e.toggleClass("hide", e.text().toString().toLowerCase().indexOf(n) < 0 && e.data("key").toString().toLowerCase().indexOf(n) < 0)
            })
        }), e.parents(".dropdown-submenu").one("mouseenter", function () {
            var e = t(this).find(".dropdown-list")[0];
            e && e.getBoundingClientRect && setTimeout(function () {
                var i = 270, n = e.getBoundingClientRect();
                n.top < 0 && (i = Math.min(270, n.height) + n.top), e.style.maxHeight = Math.min(270, i, t(window).height() - 28) + "px"
            }, 50)
        })), t(".dropdown-menu.with-search .menu-search").on("click", function (t) {
            return t.stopPropagation(), !1
        })
    })
}(jQuery), function (t) {
    function e() {
        if (!config.skipRedirect && !window.skipRedirect) {
            var e = window.parent, i = config.currentModule, n = config.currentMethod;
            if ("file" !== i || "download" !== n) {
                var o = "index" === i && "index" === n,
                    a = "#_single" === location.hash || /(\?|\&)_single/.test(location.search) || o || !t("#mainHeader,#editorNav").length || "tutorial" === i || "install" === i || "upgrade" === i || "user" === i && ("login" === n || "deny" === n) || "my" === i && "changepassword" === n || t("body").hasClass("allow-self-open"),
                    s = location.href;
                if (e === window && !a) {
                    var r = location.pathname + location.search + location.hash;
                    return void (location.href = t.createLink("index", "index", "") + "#app=" + encodeURIComponent(r))
                }
                if (e !== window && e.$.apps) {
                    o && e.location.reload();
                    var l = window.name;
                    if (0 === l.indexOf("app-")) {
                        t.apps = window.apps = e.$.apps;
                        var c = l.substring(4);
                        t.appCode = c, t(document).on("click", function (t) {
                            var i = e.document.getElementById(window.name);
                            if (i) {
                                var n = e.document.getElementById(i.name) || i;
                                if (n) {
                                    var o;
                                    "function" == typeof Event ? o = new Event(t.type, {bubbles: !0}) : (o = document.createEvent("Event"), o.initEvent(t.type, !0, !0)), n.dispatchEvent(o)
                                }
                            }
                        }).on("click", "a,.open-in-app,.show-in-app", function (e) {
                            var i = t(this);
                            if (!i.is("[data-modal],[data-toggle],[data-ride],[data-tab],.iframe,.not-in-app,[target]") && !i.data("zui.modaltrigger")) {
                                var n = i.hasClass("show-in-app") ? "" : i.attr("href") || (i.is("a") ? "" : i.data("url")),
                                    o = i.data("app") || i.data("group");
                                if (n) {
                                    if (0 === n.indexOf("javascript:") || "#" === n[0]) return;
                                    var a = t.parseLink(n);
                                    if (a.external || "file" === a.moduleName && "download" === a.methodName) return;
                                    if ("index" === a.moduleName && "index" === a.methodName) return window.location.reload(), void e.preventDefault()
                                } else if (!o) return;
                                o || (o = t.apps.getAppCode(n)), o && ("help" === o && (t.apps.appsMap.help.text = i.text(), t.apps.appsMap.help.url || (t.apps.appsMap.help.url = n)), t.apps.open(n, o) && e.preventDefault())
                            }
                        }), t.apps.updateUrl(c, s, document.title)
                    }
                }
            }
        }
    }

    function i() {
        var e = t("#navbar>.nav");
        if (e.length) {
            var i = t("#heading"), n = +i.css("left").replace("px", ""), o = i.outerWidth(), a = e.width(),
                s = t("#mainHeader>.container").width() - 2 * n, r = Math.floor((s - a) / 2);
            e.css("marginLeft", r < o ? 2 * (o - r) : "")
        }
    }

    function n() {
        var e = function (e, i) {
            var n = {
                zh_cn: {modal: "对话框中有未提交的表单，是否关闭？", app: "应用“{0}”中有未提交的表单，是否继续？"},
                zh_tw: {modal: "對話框中有未提交的表單，是否關閉？ ", app: "應用“{0}”中有未提交的表單，是否繼續？ "},
                en: {
                    modal: "There is an uncommitted form in the dialog box. Do you want to close?",
                    app: "There are uncommitted forms in the application '{0}'. Do you want to continue?"
                }
            };
            return t.zui.formatString((n[t.zui.clientLang()] || n.en)[e || "page"], i)
        };
        if (parent === window) return void (t.apps && t(window).on("beforeunload", function (i) {
            var n, o;
            if (t.each(t.apps.openedApps, function (t, e) {
                if (o = e.$iframe && e.$iframe[0].contentWindow.hasFormChanged()) return n = t, !1
            }), n) return t.apps.open(n), o.addClass("form-unsaved"), setTimeout(function () {
                o.removeClass("form-unsaved")
            }, 5e3), i.preventDefault(), e("app", t.apps.appsMap[n].text)
        }));
        t("#main form:not(.not-watch)").each(function () {
            var e = t(this);
            e.hasClass("search-form") || e.closest('[data-ride="table"]').length || e.data("zui.table") || e.find('[data-ride="table"]').length || e.addClass("form-watched").data("originalFormData", e.serialize())
        });
        var i = function () {
            var i = hasFormChanged();
            if (i) {
                i.addClass("form-unsaved");
                var n = !i.closest("body.body-modal").length;
                if (!confirm(i.data("unsavedTip") || e(n ? "app" : "modal", n ? t.apps.appsMap[t.appCode].text : ""))) return setTimeout(function () {
                    i.removeClass("form-unsaved")
                }, 5e3), !1;
                i.removeClass("form-unsaved")
            }
        };
        t(document.body).hasClass("body-modal") ? t("body").on("modalhide.zui.modal", i) : parent.$.apps && t(document).on("openapp.apps closeapp.apps", function (t, e, n) {
            if ("closeapp" === t.type || n) return i()
        })
    }

    Array.prototype.includes || Object.defineProperty(Array.prototype, "includes", {
        value: function (t, e) {
            function i(t, e) {
                return t === e || "number" == typeof t && "number" == typeof e && isNaN(t) && isNaN(e)
            }

            if (null == this) throw new TypeError('"this" is null or not defined');
            var n = Object(this), o = n.length >>> 0;
            if (0 === o) return !1;
            for (var a = 0 | e, s = Math.max(a >= 0 ? a : o - Math.abs(a), 0); s < o;) {
                if (i(n[s], t)) return !0;
                s++
            }
            return !1
        }
    }), t.getSearchParam = function (t, e) {
        e = void 0 === e ? window.location.search : e;
        var i = {};
        return e.length > 1 && ("?" === e[0] && (e = e.substr(1)), e.split("&").forEach(function (t) {
            var e = t.split("=", 2);
            if (e.length > 1) try {
                i[e[0]] = decodeURIComponent(e[1])
            } catch (n) {
                i[e[0]] = ""
            } else i[e[0]] = ""
        })), t ? i[t] : i
    }, t.parseLink = function (e) {
        if (!e) return {};
        var i = 0 === e.indexOf("http:") || 0 === e.indexOf("https:");
        if (i) {
            var n = window.location.origin;
            if (e.indexOf(n) < 0) return {external: !0, url: e};
            e = e.substr((n + config.webRoot).length)
        }
        var o = e.split("#"), a = o[0].split("?"), s = a[1], r = s ? t.getSearchParam("", s) : {}, l = a[0],
            c = {url: e, isOnlyBody: "yes" === r.onlybody, vars: [], hash: o[1] || "", params: r, tid: r.tid || ""};
        if ("GET" === config.requestType) {
            c.moduleName = r[config.moduleVar] || "index", c.methodName = r[config.methodVar] || "index", c.viewType = r[config.viewVar] || config.defaultView;
            for (var h in r) h !== config.moduleVar && h !== config.methodVar && h !== config.viewVar && "onlybody" !== h && "tid" !== h && c.vars.push([h, r[h]])
        } else {
            var d = l.lastIndexOf("/");
            d === l.length - 1 && (l = l.substr(0, d), d = l.lastIndexOf("/")), d >= 0 && (l = l.substr(d + 1));
            var u = l.lastIndexOf(".");
            u >= 0 ? (c.viewType = l.substr(u + 1), l = l.substr(0, u)) : c.viewType = config.defaultView;
            var p = l.split(config.requestFix);
            if (c.moduleName = p[0] || "index", c.methodName = p[1] || "index", p.length > 2) for (var f = 2; f < p.length; f++) c.vars.push(["", p[f]]), r["$" + (f - 1)] = p[f]
        }
        return c
    }, window.hasFormChanged = function (e) {
        var i = t(".modal.in iframe");
        if (i.length) for (var n = 0; n < i.length; ++n) {
            var o = i[n], a = o.contentWindow.hasFormChanged();
            if (a) return a
        }
        e || (e = ".form-watched");
        var s = t(e);
        if (!s.length) return !1;
        for (var n = 0; n < s.length; ++n) {
            var r = s.eq(n), l = r.data("originalFormData");
            if (null !== l && r.hasClass("form-watched") && !r.hasClass("form-disabled") && l !== r.serialize()) return r
        }
        return !1
    }, t(function () {
        e(), t("#navbar>.nav>li").length > 10 && (i(), t(window).on("resize", i)), setTimeout(n, 1e3)
    })
}(jQuery), function (t) {
    "use strict";

    function e(e, i) {
        "object" != typeof i && (i = {user: i});
        var n = t(e);
        i = t.extend({}, n.data(), i);
        var o = i.user;
        "string" == typeof o && (o = {account: o});
        var a = {}, s = i.size;
        s && (a.width = s, a.height = s, a.lineHeight = s, Number.isNaN(+s) || n.addClass("size-" + s));
        var r = !!o.avatar;
        if (n.toggleClass("has-image", r).toggleClass("has-text", !r), n.empty(), r) n.append(t("<img />").attr("src", o.avatar)); else {
            var l = t.zui.strCode(o.account) * (i.hueDistance || 43) % 360;
            a.background = "hsl(" + l + "," + (i.saturation || "40%") + "," + (i.lightness || "60%") + ")", Number.isNaN(+s) || (a.fontSize = Math.round(s / 2) + "px");
            var c = o.name || o.realname || o.account;
            c = /^[\u4e00-\u9fa5\s]+$/.test(c) ? c.length <= 2 ? c : c.substring(c.length - 2) : /^[A-Za-z\d\s]+$/.test(c) ? c[0].toUpperCase() : c.length <= 2 ? c : c.substring(0, 2), n.append(t('<span class="text text-len-' + c.length + '" />').text(c))
        }
        return n.css(a)
    }

    t.fn.avatar = function (t) {
        return this.each(function () {
            e(this, t)
        })
    }
}(jQuery), $.zui.lang("de", {
    "zui.pager": {
        pageOfText: "Seite {0}",
        prev: "Zurück",
        next: "Nächste Seite",
        first: "Erste Seite",
        last: "Letzte Seite",
        "goto": "Goto",
        pageOf: "Seite <strong>{page}</strong>",
        totalPage: "<strong>{totalPage}</strong> Seiten",
        totalCount: "Total: <strong>{recTotal}</strong> Artikel",
        pageSize: "<strong>{recPerPage}</strong> Artikel pro Seite",
        itemsRange: "Seiten <strong>{start}</strong> bis <strong>{end}</strong>",
        pageOfTotal: "Seite <strong>{page}</strong>/<strong>{totalPage}</strong>"
    },
    "zui.boards": {append2end: "Gehen Sie zum Ende"},
    "zui.browser": {tip: "Online. Sorgenfrei. Aktualisiere deinen Browser noch heute!"},
    "zui.calendar": {
        weekNames: ["Son", "Mon", "Die", "Mit", "Don", "Fri", "Sam"],
        monthNames: ["Jan", "Feb", "Mär", "Apr", "Mai", "Jun", "Jul", "Aug", "Sep", "Okt", "Nov", "Dez"],
        today: "Heute",
        year: "{0}Jahr",
        month: "{0}Monat",
        yearMonth: "{0}-{1}"
    },
    "zui.chosenIcons": {
        emptyIcon: "[Kein Icon]",
        commonIcons: "Gemeinsame Symbole",
        webIcons: "Web-Symbol",
        editorIcons: "Editor-Symbol",
        directionalIcons: "Pfeil Zusammenfluss",
        otherIcons: "Andere Symbole"
    },
    "zui.colorPicker": {errorTip: "Kein gültiger Farbwert"},
    "zui.datagrid": {
        errorCannotGetDataFromRemote: "Daten vom Remote-Server ({0}) können nicht abgerufen werden.",
        errorCannotHandleRemoteData: "Die vom Remote-Server zurückgegebenen Daten können nicht verarbeitet werden."
    },
    "zui.guideViewer": {prevStep: "Vorheriger Schritt", nextStep: "Nächster Schritt"},
    "zui.tabs": {
        reload: "Neu laden",
        close: "Schliessen",
        closeOthers: "Schließen Sie andere Registerkarten",
        closeRight: "Schließen Sie die rechte Registerkarte",
        reopenLast: "Letzten geschlossenen Tab wiederherstellen",
        errorCannotFetchFromRemote: "Inhalt kann nicht vom Remote-Server abgerufen werden ({0})."
    },
    "zui.uploader": {},
    datetimepicker: {
        days: ["Sonntag", "Montag", "Diensteg", "Mittwoch", "Donnerstag", "Freitag", "Samstag"],
        daysShort: ["Son", "Mon", "Die", "Mit", "Don", "Fri", "Sam"],
        daysMin: ["Son", "Mon", "Die", "Mit", "Don", "Fri", "Sam"],
        months: ["Jan", "Feb", "Mär", "Apr", "Mai", "Jun", "Jul", "Aug", "Sep", "Okt", "Nov", "Dez"],
        monthsShort: ["Jan", "Feb", "Mär", "Apr", "Mai", "Jun", "Jul", "Aug", "Sep", "Okt", "Nov", "Dez"],
        today: "Heute",
        suffix: [],
        meridiem: []
    },
    chosen: {no_results_text: "Nicht gefunden"},
    bootbox: {OK: "OK", CANCEL: "Stornieren", CONFIRM: "Bestätigen"}
}), $.zui.lang("fr", {
    "zui.pager": {
        pageOfText: "Page {0}",
        prev: "Prev",
        next: "Suivant",
        first: "First",
        last: "Last",
        "goto": "Goto",
        pageOf: "Page <strong>{page}</strong>",
        totalPage: "<strong>{totalPage}</strong> pages",
        totalCount: "Total: <strong>{recTotal}</strong> items",
        pageSize: "<strong>{recPerPage}</strong> per page",
        itemsRange: "De <strong>{start}</strong> à <strong>{end}</strong>",
        pageOfTotal: "Page <strong>{page}</strong> de <strong>{totalPage}</strong>"
    },
    "zui.boards": {append2end: "Aller jusqu'au bout"},
    "zui.browser": {tip: "Naviguez sans crainte sur Internet. Mettez votre navigateur à jour dès aujourd'hui!"},
    "zui.calendar": {
        weekNames: ["Dim", "Lun", "Mar", "Mer", "Jeu", "Ven", "Sam"],
        monthNames: ["Jan", "Fév", "Mar", "Avr", "Mai", "Juin", "Juil", "Août", "Sep", "Oct", "Nov", "Déc"],
        today: "Aujourd'hui",
        year: "{0} Année",
        month: "{0} Mois",
        yearMonth: "{0}-{1}"
    },
    "zui.chosenIcons": {
        emptyIcon: "[Aucune icône]",
        commonIcons: "Icônes communes",
        webIcons: "Icône Web",
        editorIcons: "Icône de l'éditeur",
        directionalIcons: "Flèche confluence",
        otherIcons: "Autres icônes"
    },
    "zui.colorPicker": {errorTip: "Pas une valeur de couleur valide"},
    "zui.datagrid": {
        errorCannotGetDataFromRemote: "Impossible d'obtenir les données du serveur distant ({0}).",
        errorCannotHandleRemoteData: "Impossible de traiter les données renvoyées par le serveur distant."
    },
    "zui.guideViewer": {prevStep: "Étape précédente", nextStep: "Prochaine étape"},
    "zui.tabs": {
        reload: "Recharger",
        close: "Fermer",
        closeOthers: "Fermez les autres onglets",
        closeRight: "Fermer l'onglet de droite",
        reopenLast: "Restaurer le dernier onglet fermé",
        errorCannotFetchFromRemote: "Impossible d'obtenir le contenu du serveur distant ({0})."
    },
    "zui.uploader": {},
    datetimepicker: {
        days: ["Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi"],
        daysShort: ["Dim", "Lun", "Mar", "Mer", "Jeu", "Ven", "Sam"],
        daysMin: ["Dim", "Lun", "Mar", "Mer", "Jeu", "Ven", "Sam"],
        months: ["Jan", "Fév", "Mar", "Avr", "Mai", "Juin", "Juil", "Août", "Sep", "Oct", "Nov", "Déc"],
        monthsShort: ["Jan", "Fév", "Mar", "Avr", "Mai", "Juin", "Juil", "Août", "Sep", "Oct", "Nov", "Déc"],
        today: "Aujourd'hui",
        suffix: [],
        meridiem: []
    },
    chosen: {no_results_text: "Pas trouvé"},
    bootbox: {OK: "D'accord", CANCEL: "Annuler", CONFIRM: "Confirmer"}
});
(function ($) {
    if (!config.tabSession) return;
    var _tid = '';

    function getTid() {
        return _tid
    }

    function convertUrlWithTid(url, tid, force) {
        var link = $.parseLink(url);
        if (!link.moduleName) return url;
        tid = tid || _tid;
        if (!force && link.tid === tid) return url;
        link.tid = tid;
        return $.createLink(link)
    }

    function init() {
        if (window.parent !== window) {
            if (window.parent.$.tabSession) _tid = window.parent.$.tabSession.getTid();
        } else {
            var isIndexOrLoginPage = (config.currentModule === 'index' && config.currentMethod === 'index') || (config.currentModule === 'user' && config.currentMethod === 'login');
            var link = $.parseLink(window.location.href);
            _tid = sessionStorage.getItem('TID');
            if (!_tid) {
                if (link.tid && isIndexOrLoginPage) {
                    _tid = link.tid
                }
                if (!_tid) {
                    _tid = $.zui.uuid();
                    _tid = _tid.substr(_tid.length - 8)
                }
            }
            sessionStorage.setItem('TID', _tid);
            if (isIndexOrLoginPage && !link.tid) {
                window.location.href = convertUrlWithTid(window.location.href, _tid)
            }
        }
        $.tabSession = {getTid: getTid, convertUrlWithTid: convertUrlWithTid,};
        $('a').each(function () {
            var $a = $(this);
            var url = $a.attr('href');
            var urlWithTid = convertUrlWithTid(url);
            if (urlWithTid !== url) $a.attr('href', urlWithTid);
        });
        $('[data-url]').each(function () {
            var $e = $(this);
            var url = $e.attr('data-url');
            var urlWithTid = convertUrlWithTid(url);
            if (urlWithTid !== url) $e.attr('data-url', urlWithTid);
        });
        if (config.debug > 2) {
            $(function () {
                $('#tid').prepend('<code class="bg-blue">localtid=' + _tid + '</code>')
            })
        }
    }

    init();
    $(window).on('scroll', function () {
        $.zui.ContextMenu.hide()
    })
}(jQuery));

function setPing() {
    $('#hiddenwin').attr('src', createLink('misc', 'ping'))
}

function setForm() {
    var formClicked = !1;
    $('form').submit(function () {
        submitObj = $(this).find(':submit');
        if ($(submitObj).size() >= 1) {
            var isBtn = submitObj.prop('tagName') == "BUTTON";
            submitLabel = isBtn ? $(submitObj).html() : $(submitObj).attr('value');
            $(submitObj).attr('disabled', 'disabled');
            var submitting = submitObj.attr('data-submitting') || lang.submitting;
            if (isBtn) submitObj.text(submitting); else $(submitObj).attr('value', submitting);
            formClicked = !0
        }
    });
    $("body").click(function () {
        if (formClicked) {
            $(submitObj).removeAttr('disabled');
            if (submitObj.prop('tagName') == "BUTTON") {
                submitObj.text(submitLabel)
            } else {
                $(submitObj).attr('value', submitLabel)
            }
            $(submitObj).removeClass('button-d')
        }
        formClicked = !1
    })
}

function setFormAction(actionLink, hiddenwin, obj) {
    $form = typeof (obj) == 'undefined' ? $('form') : $(obj).closest('form');
    if (hiddenwin) $form.attr('target', hiddenwin); else $form.removeAttr('target');
    $form.attr('action', actionLink);
    var userAgent = navigator.userAgent;
    var isSafari = userAgent.indexOf('AppleWebKit') > -1 && userAgent.indexOf('Safari') > -1 && userAgent.indexOf('Chrome') < 0;
    if (isSafari) {
        var idPreffix = 'checkbox-fix-' + $.zui.uuid();
        $form.find('[data-fix-checkbox]').remove();
        $form.find('input[type="checkbox"]:not(.rows-selector)').each(function () {
            var $checkbox = $(this);
            var checkboxId = idPreffix + $checkbox.val();
            $checkbox.clone().attr('data-fix-checkbox', checkboxId).css('display', 'none').after('<div id="' + checkboxId + '"/>').appendTo($form)
        })
    }
    $form.submit()
}

function setImageSize(image, maxWidth, maxHeight) {
    var $image = $(image);
    if ($image.parent().prop('tagName').toLowerCase() == 'a') return;
    if (!maxWidth) {
        bodyWidth = $('body').width();
        maxWidth = bodyWidth - 470
    }
    if (!maxHeight) maxHeight = $(top.window).height();
    setTimeout(function () {
        maxHeightStyle = $image.height() > 0 ? 'max-height:' + maxHeight + 'px' : '';
        if (!document.getElementsByClassName('xxc-embed').length && $image.width() > 0 && $image.width() > maxWidth) $image.attr('width', maxWidth);
        $image.wrap('<a href="' + $image.attr('src') + '" style="display:inline-block;position:relative;overflow:hidden;' + maxHeightStyle + '" target="_blank"></a>');
        if ($image.height() > 0 && $image.height() > maxHeight) $image.closest('a').append("<a href='###' class='showMoreImage' onclick='showMoreImage(this)'>" + lang.expand + " <i class='icon-angle-down'></i></a>");
    }, 50)
}

function showMoreImage(obj) {
    $(obj).parents('a').css('max-height', 'none');
    $(obj).remove()
}

function setMailto(mailto, contactListID) {
    var oldUsers = $('#' + mailto).val() ? $('#' + mailto).val() : '';
    link = createLink('user', 'ajaxGetContactUsers', 'listID=' + contactListID + '&dropdownName=' + mailto + '&oldUsers=' + oldUsers);
    $.get(link, function (users) {
        var picker = $('#' + mailto).data('zui.picker');
        if (picker) picker.destroy();
        $('#' + mailto).replaceWith(users);
        $('#' + mailto + '_chosen').remove();
        $('#' + mailto).siblings('.picker').remove();
        if ($("[data-pickertype='remote']").length == 0 && $('.picker-select').length == 0) {
            $('#' + mailto).chosen()
        } else {
            $('#' + mailto + "[data-pickertype!='remote']").picker({chosenMode: !0});
            $("[data-pickertype='remote']").each(function () {
                var pickerremote = $(this).attr('data-pickerremote');
                $(this).picker({chosenMode: !0, remote: pickerremote})
            })
        }
    })
}

function ajaxGetContacts(obj, dropdownName) {
    if (typeof (dropdownName) == 'undefined') dropdownName = 'mailto';
    link = createLink('user', 'ajaxGetContactList', 'dropdownName=' + dropdownName);
    $.get(link, function (contacts) {
        if (!contacts) return !1;
        $inputgroup = $(obj).closest('.input-group');
        $inputgroup.find('.input-group-btn').remove();
        $inputgroup.append(contacts);
        $inputgroup.find('select:last').chosen().fixInputGroup()
    })
}

function addItem(SelectID, TargetID) {
    ItemList = document.getElementById(SelectID);
    Target = document.getElementById(TargetID);
    for (var x = 0; x < ItemList.length; x++) {
        var opt = ItemList.options[x];
        if (opt.selected) {
            flag = !0;
            for (var y = 0; y < Target.length; y++) {
                var myopt = Target.options[y];
                if (myopt.value == opt.value) {
                    flag = !1
                }
            }
            if (flag) {
                Target.options[Target.options.length] = new Option(opt.text, opt.value, 0, 0)
            }
        }
    }
}

function delItem(SelectID) {
    ItemList = document.getElementById(SelectID);
    for (var x = ItemList.length - 1; x >= 0; x--) {
        var opt = ItemList.options[x];
        if (opt.selected) {
            ItemList.options[x] = null
        }
    }
}

function upItem(SelectID) {
    ItemList = document.getElementById(SelectID);
    for (var x = 1; x < ItemList.length; x++) {
        var opt = ItemList.options[x];
        if (opt.selected) {
            tmpUpValue = ItemList.options[x - 1].value;
            tmpUpText = ItemList.options[x - 1].text;
            ItemList.options[x - 1].value = opt.value;
            ItemList.options[x - 1].text = opt.text;
            ItemList.options[x].value = tmpUpValue;
            ItemList.options[x].text = tmpUpText;
            ItemList.options[x - 1].selected = !0;
            ItemList.options[x].selected = !1;
            break
        }
    }
}

function downItem(SelectID) {
    ItemList = document.getElementById(SelectID);
    for (var x = 0; x < ItemList.length; x++) {
        var opt = ItemList.options[x];
        if (opt.selected) {
            tmpUpValue = ItemList.options[x + 1].value;
            tmpUpText = ItemList.options[x + 1].text;
            ItemList.options[x + 1].value = opt.value;
            ItemList.options[x + 1].text = opt.text;
            ItemList.options[x].value = tmpUpValue;
            ItemList.options[x].text = tmpUpText;
            ItemList.options[x + 1].selected = !0;
            ItemList.options[x].selected = !1;
            break
        }
    }
}

function selectItem(SelectID) {
    ItemList = document.getElementById(SelectID);
    for (var x = ItemList.length - 1; x >= 0; x--) {
        var opt = ItemList.options[x];
        opt.selected = !0
    }
}

function ajaxDelete(url, replaceID, notice) {
    if (confirm(notice)) {
        $.ajax({
            type: 'GET', url: url, dataType: 'json', success: function (data) {
                if (data.result == 'success') {
                    var $table = $('#' + replaceID).closest('[data-ride="table"]');
                    if ($table.length) {
                        var table = $table.data('zui.table');
                        if (table) {
                            table.options.replaceId = replaceID;
                            return table.reload()
                        }
                    }
                    $.get(document.location.href, function (data) {
                        if (!($(data).find('#' + replaceID).length)) location.reload();
                        $('#' + replaceID).html($(data).find('#' + replaceID).html());
                        if (typeof sortTable == 'function') sortTable();
                        $('#' + replaceID).find('[data-toggle=modal], a.iframe').modalTrigger();
                        if ($('#' + replaceID).find('table.datatable').length) $('#' + replaceID).find('table.datatable').datatable();
                        $('.table-footer [data-ride=pager]').pager()
                    })
                } else if (data.result == 'fail' && typeof (data.message) == 'string') {
                    bootbox.alert(data.message)
                }
            }
        })
    }
}

function isNum(s) {
    if (s != null) {
        var r, re;
        re = /\d*/i;
        r = s.match(re);
        return (r == s) ? !0 : !1
    }
    return !1
}

function startCron(restart) {
    if (typeof (restart) == 'undefined') restart = 0;
    $.ajax({type: "GET", timeout: 100, url: createLink('cron', 'ajaxExec', 'restart=' + restart)})
}

function computePasswordStrength(password) {
    if (password.length == 0) return 0;
    var strength = 0;
    var length = password.length;
    var complexity = new Array();
    for (i = 0; i < length; i++) {
        letter = password.charAt(i);
        var asc = letter.charCodeAt();
        if (asc >= 48 && asc <= 57) {
            complexity[0] = 1
        } else if ((asc >= 65 && asc <= 90)) {
            complexity[1] = 2
        } else if (asc >= 97 && asc <= 122) {
            complexity[2] = 4
        } else {
            complexity[3] = 8
        }
    }
    var sumComplexity = 0;
    for (i in complexity) sumComplexity += complexity[i];
    if ((sumComplexity == 7 || sumComplexity == 15) && password.length >= 6) strength = 1;
    if (sumComplexity == 15 && password.length >= 10) strength = 2;
    return strength
}

function checkOnlybodyPage() {
    if (self == parent) {
        href = location.href.replace('?onlybody=yes', '');
        location.href = href.replace('&onlybody=yes', '')
    }
}

function fixedTheadOfList(tableID) {
    if ($(tableID).size() == 0) return !1;
    if ($(tableID).css('display') == 'none') return !1;
    if ($(tableID).find('thead').size() == 0) return !1;
    fixTheadInit();
    $(window).scroll(fixThead);
    $('.side-handle').click(function () {
        setTimeout(fixTheadInit, 300)
    });
    var tableWidth, theadOffset, fixedThead, $fixedThead;

    function fixThead() {
        theadOffset = $(tableID).find('thead').offset().top;
        $fixedThead = $(tableID).parent().find('.fixedTheadOfList');
        if ($fixedThead.size() <= 0 && theadOffset < $(window).scrollTop()) {
            tableWidth = $(tableID).width();
            fixedThead = "<table class='fixedTheadOfList'><thead>" + $(tableID).find('thead').html() + '</thead></table>';
            $(tableID).before(fixedThead);
            $('.fixedTheadOfList').addClass($(tableID).attr('class')).width(tableWidth)
        }
        if ($fixedThead.size() > 0 && theadOffset >= $(window).scrollTop()) $fixedThead.remove();
    }

    function fixTheadInit() {
        $fixedThead = $(tableID).parent().find('.fixedTheadOfList');
        if ($fixedThead.size() > 0) $fixedThead.remove();
        fixThead()
    }
}

function applyCssStyle(css, tag) {
    tag = tag || 'default';
    var name = 'applyStyle-' + tag;
    var $style = $('style#' + name);
    if (!$style.length) {
        $style = $('<style id="' + name + '">').appendTo('body')
    }
    var styleTag = $style.get(0);
    if (styleTag.styleSheet) styleTag.styleSheet.cssText = css; else styleTag.innerHTML = css
}

function removeCookieByKey(cookieKey) {
    $.cookie(cookieKey, '', {expires: config.cookieLife, path: config.webRoot});
    location.href = location.href
}

function setHomepage(module, page) {
    $.get(createLink('custom', 'ajaxSetHomepage', 'module=' + module + '&page=' + page), function () {
        location.reload(!0)
    })
}

function checkTutorial() {
    if (config.currentModule != 'tutorial' && window.TUTORIAL && (!frameElement || frameElement.tagName != 'IFRAME')) {
        if (confirm(window.TUTORIAL.tip)) {
            $.getJSON(createLink('tutorial', 'ajaxQuit'), function () {
                window.location.reload()
            }).error(function () {
                alert(lang.timeout)
            })
        } else {
            window.location.href = createLink('tutorial', 'index')
        }
    }
}

function removeDitto() {
    $firstTr = $('.table-form').find('tbody tr:first');
    $firstTr.find('td select').each(function () {
        $(this).find("option[value='ditto']").remove();
        $(this).trigger("chosen:updated")
    })
}

function revertModuleCookie() {
    if ($('#mainmenu .nav li[data-id="project"]').hasClass('active')) {
        $('#modulemenu .nav li[data-id="task"] a').click(function () {
            $.cookie('moduleBrowseParam', 0, {expires: config.cookieLife, path: config.webRoot})
        })
    }
    if ($('#mainmenu .nav li[data-id="product"]').hasClass('active')) {
        $('#modulemenu .nav li[data-id="story"] a').click(function () {
            $.cookie('storyModule', 0, {expires: config.cookieLife, path: config.webRoot})
        })
    }
    if ($('#mainmenu .nav li[data-id="qa"]').hasClass('active')) {
        $('#modulemenu .nav li[data-id="bug"] a').click(function () {
            $.cookie('bugModule', 0, {expires: config.cookieLife, path: config.webRoot})
        });
        $('#modulemenu .nav li[data-id="testcase"] a').click(function () {
            $.cookie('caseModule', 0, {expires: config.cookieLife, path: config.webRoot})
        })
    }
}

function inputFocusJump(direction, type) {
    var $input = $('#mainContent table').find(type || 'input').filter(':focus').first();
    if (!$input.length) return;
    var $row = $input.closest('tr');
    var $nextRow = $row[direction === 'up' ? 'prev' : 'next']('tr');
    if (!$nextRow.length) $nextRow = $row.parent().children('tr')[direction === 'up' ? 'last' : 'first']();
    if (!$nextRow.length) return;
    var datetimepicker = $input.data('datetimepicker');
    if (datetimepicker) datetimepicker.hide();
    return $nextRow.find(':input[name^=' + ($input.attr('name').split('[')[0]) + ']:text:not(:disabled):not([name*="%"])').focus()
}

function selectFocusJump(direction) {
    return inputFocusJump(direction, 'select')
}

function adjustNoticePosition() {
    var bottom = 25;
    $('#noticeBox').find('.alert').each(function () {
        $(this).css('bottom', bottom + 'px');
        bottom += $(this).outerHeight(!0) - 10
    })
}

function notifyMessage(data) {
    if (window.Notification) {
        var notify = null;
        message = data;
        if (typeof data.message == 'string') message = data.message;
        if (Notification.permission == "granted") {
            notify = new Notification("", {body: message, tag: 'zentao', data: data})
        } else if (Notification.permission != "denied") {
            Notification.requestPermission().then(function (permission) {
                notify = new Notification("", {body: message, tag: 'zentao', data: data})
            })
        }
        if (notify) {
            notify.onclick = function () {
                window.focus();
                if (typeof notify.data.url == 'string' && notify.data.url) window.location.href = notify.data.url;
                notify.close()
            }
            setTimeout(function () {
                notify.close()
            }, 3000)
        }
    }
}

function getFingerprint() {
    if (typeof (Fingerprint) == 'function') return new Fingerprint().get();
    fingerprint = '';
    $.each(navigator, function (key, value) {
        if (typeof (value) == 'string') fingerprint += value.length
    })
    return fingerprint
}

function bootAlert(message) {
    bootbox.alert(message);
    return !1
}

function toggleFold(form, unfoldIdList, objectID, objectType) {
    $form = $(form);
    $parentTd = $form.find('td.has-child');
    if ($parentTd.length == 0) return !1;
    var toggleClass = ['product', 'requirement'].includes(objectType) ? 'story-toggle' : 'task-toggle';
    var nameClass = ['product', 'productplan'].indexOf(objectType) !== -1 ? 'c-title' : 'c-name';
    $form.find('th.' + nameClass).addClass('clearfix').append("<span id='toggleFold' class='collapsed'><i  class='icon icon-angle-double-right'></i></span>");
    var allUnfold = !0;
    $parentTd.each(function () {
        var dataID = $(this).closest('tr').attr('data-id');
        if (typeof (unfoldIdList[dataID]) != 'undefined') return !0;
        allUnfold = !1;
        $form.find('tr.parent-' + dataID).hide();
        $(this).find('a.' + toggleClass).addClass('collapsed')
    })
    $form.find('th.' + nameClass + ' #toggleFold').toggleClass('collapsed', !allUnfold);
    $(document).on('click', '#toggleFold', function () {
        var newUnfoldID = [];
        var url = '';
        var collapsed = $(this).hasClass('collapsed');
        $parentTd.each(function () {
            var dataID = $(this).closest('tr').attr('data-id');
            $form.find('tr.parent-' + dataID).toggle(collapsed);
            $(this).find('a.' + toggleClass).toggleClass('collapsed', !collapsed)
            newUnfoldID.push(dataID)
        })
        $(this).toggleClass('collapsed', !collapsed);
        url = createLink('misc', 'ajaxSetUnfoldID', 'objectID=' + objectID + '&objectType=' + objectType + '&action=' + (collapsed ? 'add' : 'delete'));
        $.post(url, {'newUnfoldID': JSON.stringify(newUnfoldID)})
    });
    $parentTd.find('a.' + toggleClass).click(function () {
        var newUnfoldID = [];
        var url = '';
        var collapsed = $(this).hasClass('collapsed');
        var dataID = $(this).closest('tr').attr('data-id');
        $form.find('tr.parent-' + dataID).toggle(!collapsed);
        newUnfoldID.push(dataID);
        url = createLink('misc', 'ajaxSetUnfoldID', 'objectID=' + objectID + '&objectType=' + objectType + '&action=' + (collapsed ? 'add' : 'delete'));
        $table = $(this).closest('table');
        setTimeout(function () {
            hasCollapsed = $table.find('td.has-child a.' + toggleClass + '.collapsed').length != 0;
            $('#toggleFold').toggleClass('collapsed', hasCollapsed)
        }, 100);
        $.post(url, {'newUnfoldID': JSON.stringify(newUnfoldID)})
    })
}

function adjustMenuWidth() {
    if (window.navigator.userAgent.indexOf('xuanxuan') > 0) return;
    var $mainHeader = $('#mainHeader .container');
    if ($mainHeader.length == 0) return !1;
    var $navbar = $mainHeader.find('#navbar .nav');
    var mainHeaderWidth = $mainHeader.width() - 10;
    var headingWidth = $mainHeader.find('#heading').width() + 30;
    var navbarWidth = $navbar.width();
    var toolbarWidth = $mainHeader.find('#toolbar').width() + 20;
    if (mainHeaderWidth < headingWidth + navbarWidth + toolbarWidth) {
        var delta = (headingWidth + navbarWidth + toolbarWidth) - mainHeaderWidth;
        delta = Math.ceil(delta / $navbar.children('li').length / 2);
        var aTagPadding = $navbar.find('a:first').css('padding-left').replace('px', '');
        var dividerMargin = $navbar.find('.divider').css('margin-left').replace('px', '');
        var newPadding = aTagPadding - delta;
        var newMargin = dividerMargin - delta - 1;
        if (newPadding < 0) newPadding = 0;
        if (newMargin < 0) newMargin = 0;
        $navbar.children('li').find('a').css('padding-left', newPadding).css('padding-right', newPadding);
        $navbar.find('.divider').css('margin-left', newMargin).css('margin-right', newMargin)
    }
}

function scrollToSelected(id) {
    if (typeof (id) == 'undefined') id = '#dropMenu .table-col .list-group'
    $id = $(id);
    $selected = $id.find('.selected');
    $id.mouseout(function () {
        $(this).find('a.active:not(.not-list-item)').removeClass('active')
    });
    if ($selected.length > 0) {
        var offsetHeight = 75;
        $id.scrollTop($selected.position().top - offsetHeight)
    }
}

function limitIframeLevel() {
    if (window.parent != window.top) {
        $('body').find('a.iframe').each(function () {
            $(this).replaceWith($(this).clone().removeClass('iframe'))
        })
    }
}

function removeHtmlTag(str) {
    return str.replace(/<[^>]+>/g, "")
}

needPing = !0;
$(document).ready(function () {
    if (needPing) setTimeout('setPing()', 1000 * 60 * 10);
    checkTutorial();
    revertModuleCookie();
    $(document).on('click', '#helpMenuItem .close-help-tab', function () {
        $('#helpMenuItem').prev().remove();
        $('#helpMenuItem').remove()
    });
    if (window.navigator.userAgent.match(/Windows/i)) {
        $(document).on('mousedown', 'a', function (e) {
            var $a = $(this);
            if (!e.ctrlKey || $a.attr('target')) return;
            $a.attr('target', '_blank');
            clearTimeout($a.data('ctrlTimer'));
            $a.data('ctrlTimer', setTimeout(function () {
                $a.attr('target', null).data('ctrlTimer', 0)
            }, 100));
            e.preventDefault()
        })
    }
    $('.has-avatar').hover(function () {
        $(this).next().removeClass('open');
        $(this).prev().removeClass('open')
    });
    $('#globalCreate').hover(function () {
        $(this).next().removeClass('open');
        $(this).addClass('dropdown-hover')
    });
    $('#globalCreate').click(function () {
        $(this).removeClass('dropdown-hover')
    })
});

function disableSelectedProduct() {
    $("select[id^='products'] option[disabled='disabled']").removeAttr('disabled');
    var selectedVal = [];
    $("select[id^='products']").each(function () {
        var selectedProduct = $(this).val();
        if (selectedProduct != 0 && $.inArray(selectedProduct, selectedVal) < 0 && !multiBranchProducts[selectedProduct]) selectedVal.push(selectedProduct);
        if (multiBranchProducts[selectedProduct]) {
            var isDisabled = checkMultiProducts(this);
            if (isDisabled) selectedVal.push(selectedProduct);
        }
    })
    $("select[id^='products']").each(function () {
        var selectedProduct = $(this).val();
        $(this).find('option').each(function () {
            var optionVal = $(this).attr('value');
            if (optionVal != selectedProduct && $.inArray(optionVal, selectedVal) >= 0) $(this).attr('disabled', 'disabled');
        })
    })
    $("select[id^=products]").trigger('chosen:updated')
}

function disableSelectedBranch() {
    var relatedProduct = $(this).siblings("select[id^='products']").val();
    var sameProductControl = [];
    var sameProductBranchControl = [];
    $("select[id^='products']").each(function () {
        if ($(this).val() == relatedProduct) {
            $(this).siblings("select[id^='branch']").find("option[disabled='disabled']").removeAttr('disabled');
            sameProductControl.push(this);
            sameProductBranchControl.push($(this).siblings("select[id^='branch']"))
        }
    });
    var preSelectedVal = [];
    $.each(sameProductControl, function () {
        var selectedBranch = $(this).siblings("select[id^='branch']").val();
        if ($.inArray(selectedBranch, preSelectedVal) < 0) preSelectedVal.push(selectedBranch);
    });
    var selectedVal = [];
    $.each(sameProductControl, function () {
        var selectedBranch = $(this).siblings("select[id^='branch']").val();
        if ($.inArray(selectedBranch, selectedVal) >= 0) {
            $(this).siblings("select[id^='branch']").find('option').removeAttr('selected');
            for (i in preSelectedVal) $(this).siblings("select[id^='branch']").find('option[value=' + preSelectedVal[i] + ']').attr('disabled', 'disabled');
            $(this).siblings("select[id^='branch']").find('option').not('[disabled=disabled]').eq(0).attr('selected', 'selected');
            var selectedBranch = $(this).siblings("select[id^='branch']").val();
        }
        if ($.inArray(selectedBranch, selectedVal) < 0) selectedVal.push(selectedBranch);
    });
    $.each(sameProductBranchControl, function () {
        var selectedBranch = $(this).val();
        $(this).find('option').each(function () {
            var optionVal = $(this).attr('value');
            if (optionVal != selectedBranch && $.inArray(optionVal, selectedVal) >= 0) $(this).attr('disabled', 'disabled');
        })
    })
    $("select[id^=branch]").trigger('chosen:updated')
}

function checkMultiProducts(product) {
    var disabledBranchList = [];
    var optionLength = $(product).siblings("select[id^='branch']").find('option').length;
    $(product).siblings("select[id^='branch']").find("option[disabled='disabled']").each(function () {
        disabledBranchList.push($(this).attr('value'))
    });
    if (optionLength - disabledBranchList.length == 1) return !0;
    return !1
}

function addRow(obj) {
    var row = $('#addRow').html().replace(/%i%/g, rowIndex + 1);
    $('<tr class="addedRow">' + row + '</tr>').insertAfter($(obj).closest('tr'));
    var $row = $(obj).closest('tr').next();
    $row.find(".form-date").datepicker();
    $row.find("input[name^=color]").colorPicker();
    $row.find('div[id$=_chosen]').remove();
    $row.find('.picker').remove();
    $row.find('.chosen').chosen();
    $row.find('.picker-select').picker();
    rowIndex++
}

function deleteRow(obj) {
    $(obj).closest('tr').remove()
}

function showCheckedFields(fields) {
    var fieldList = ',' + fields + ',';
    $('#formSettingForm > .checkboxes > .checkbox-primary > input').each(function () {
        var field = ',' + $(this).val() + ',';
        var $field = config.currentMethod == 'create' ? $('#' + $(this).val()) : $('[name^=' + $(this).val() + ']');
        var $fieldBox = $('.' + $(this).val() + 'Box');
        var required = '';
        if (typeof requiredFields != 'undefined') var required = ',' + requiredFields + ',';
        if (fieldList.indexOf(field) >= 0 || (required && required.indexOf(field) >= 0)) {
            $fieldBox.removeClass('hidden');
            $field.removeAttr('disabled')
        } else if (!$fieldBox.hasClass('hidden')) {
            $fieldBox.addClass('hidden');
            $field.attr('disabled', !0)
        }
        if (config.currentModule == 'story' && $(this).val() == 'source') {
            var $sourceNote = config.currentMethod == 'create' ? $('#sourceNote') : $('[name^=sourceNote]');
            $sourceNote.attr('disabled', $fieldBox.hasClass('hidden'))
        }
    });
    if (config.currentModule == 'task' && config.currentMethod == 'create') ;
    {
        if (fieldList.indexOf(',estStarted,') >= 0 && fieldList.indexOf(',deadline,') >= 0) {
            $('.borderBox').removeClass('hidden')
        } else if (fieldList.indexOf(',estStarted,') >= 0 || fieldList.indexOf(',deadline,') >= 0) {
            $('.datePlanBox').removeClass('hidden');
            if (!$('.borderBox').hasClass('hidden')) $('.borderBox').addClass('hidden');
        } else {
            if (!$('.borderBox').hasClass('hidden')) $('.borderBox').addClass('hidden');
            if (!$('.datePlanBox').hasClass('hidden')) $('.datePlanBox').addClass('hidden');
        }
        if (typeof lifetime != 'undefined' && lifetime == 'ops') $('.storyBox').addClass('hidden');
    }
}

function hiddenRequireFields() {
    $('#formSettingForm > .checkboxes > .checkbox-primary > input').each(function () {
        var field = ',' + $(this).val() + ',';
        var required = ',' + requiredFields + ',';
        if (required.indexOf(field) >= 0) $(this).closest('div').addClass('hidden');
    })
}

function saveCustomFields(key, maxFieldCount, $name, nameMinWidth) {
    var fields = '';
    $('#formSettingForm > .checkboxes > .checkbox-primary > input:checked').each(function () {
        fields += ',' + $(this).val()
    });
    var module = config.currentModule;
    var link = createLink('custom', 'ajaxSaveCustomFields', 'module=' + module + '&section=custom&key=' + key);
    $.post(link, {'fields': fields}, function () {
        showFields = fields;
        showCheckedFields(fields);
        $('#formSetting').parent().removeClass('open');
        if (key == 'batchCreateFields') setCustomFieldsStyle(maxFieldCount, $name, nameMinWidth);
    })
}

function setCustomFieldsStyle(maxFieldCount, $name, nameMinWidth) {
    var fieldCount = $('#batchCreateForm .table thead>tr>th:visible').length;
    $('.form-actions').attr('colspan', fieldCount);
    var $table = $('#batchCreateForm > .table-responsive');
    if (fieldCount > maxFieldCount) {
        $table.removeClass('scroll-none');
        $table.css('overflow', 'auto')
    } else {
        $table.addClass('scroll-none');
        $table.css('overflow', 'visible')
    }
    if ($name.width() < nameMinWidth) $name.width(200);
}

function refreshBudgetUnit(data) {
    $('#budgetUnit').val(data.budgetUnit).trigger('chosen:updated');
    if (typeof (data.availableBudget) == 'undefined') {
        $('#budget').removeAttr('placeholder').attr('disabled', !0);
        $('#future').prop('checked', !0)
    } else {
        $('#budget').removeAttr('disabled');
        $('#future').prop('checked', !1)
    }
}

function handleKanbanWidthAttr() {
    $('#colWidth, #minColWidth, #maxColWidth').attr('onkeyup', 'value=value.match(/^\\d+$/) ? value : ""');
    $('#colWidth, #minColWidth, #maxColWidth').attr('maxlength', '3');
    var fluidBoard = $("#mainContent input[name='fluidBoard'][checked='checked']").val() || 0;
    var addAttrEle = fluidBoard == 0 ? '#colWidth' : '#minColWidth, #maxColWidth';
    $(addAttrEle).closest('.width-radio-row').addClass('required');
    $('#colWidth').attr('disabled', fluidBoard == 1);
    $('#minColWidth, #maxColWidth').attr('disabled', fluidBoard == 0);
    $("#minColWidth, #maxColWidth").on('input', function () {
        $('#minColWidthLabel, #maxColWidthLabel').remove();
        $('#minColWidth, #maxColWidth').removeClass('has-error')
    });
    $(document).on('change', "#mainContent input[name='fluidBoard']", function (e) {
        $('#colWidth').attr('disabled', e.target.value == 1);
        $('#minColWidth, #maxColWidth').attr('disabled', e.target.value == 0);
        if (e.target.value == 0 && $('#minColWidthLabel, #maxColWidthLabel')) {
            $('#colWidth').closest('.width-radio-row').addClass('required');
            $('#minColWidth, #maxColWidth').closest('.width-radio-row').removeClass('required');
            $('#minColWidthLabel, #maxColWidthLabel').remove();
            $('#minColWidth, #maxColWidth').removeClass('has-error')
        } else if (e.target.value == 1 && $('#colWidthLabel')) {
            $('#minColWidth, #maxColWidth').closest('.width-radio-row').addClass('required');
            $('#colWidth').closest('.width-radio-row').removeClass('required');
            $('#colWidthLabel').remove();
            $('#colWidth').removeClass('has-error')
        }
    })
}