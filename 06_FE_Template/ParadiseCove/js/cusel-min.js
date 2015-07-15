/* -------------------------------------

	cusel version 2.5
	last update: 31.10.11
	смена обычного селект на стильный
	autor: Evgen Ryzhkov
	updates by:
		- Alexey Choporov
		- Roman Omelkovitch
	using libs:
		- jScrollPane
		- mousewheel
	www.xiper.net
----------------------------------------	
*/
/* -------------------------------------

	cusel version 2.5
	last update: 31.10.11
	смена обычного селект на стильный
	autor: Evgen Ryzhkov
	updates by:
		- Alexey Choporov
		- Roman Omelkovitch
	using libs:
		- jScrollPane
		- mousewheel
	www.xiper.net
----------------------------------------	
*/
function cuselScrollToCurent(e) {
    var t = null;
    if (e.find(".cuselOptHover").eq(0).is("span")) t = e.find(".cuselOptHover").eq(0);
    else if (e.find(".cuselActive").eq(0).is("span")) t = e.find(".cuselActive").eq(0);
    if (e.find(".jScrollPaneTrack").eq(0).is("div") && t) {
        var n = t.position(),
            r = e.find(".cusel-scroll-pane").eq(0).attr("id");
        jQuery("#" + r)[0].scrollTo(n.top)
    }
}

function cuselShowList(e) {
    var t = e.parent(".cusel");
    if (e.css("display") == "none") {
        jQuery(".cusel-scroll-wrap").css("display", "none");
        jQuery(".cuselOpen").removeClass("cuselOpen");
        t.addClass("cuselOpen");
        e.css("display", "block");
        var n = false;
        if (t.prop("class").indexOf("cuselScrollArrows") != -1) n = true;
        if (!e.find(".jScrollPaneContainer").eq(0).is("div")) {
            e.find("div").eq(0).jScrollPaneCusel({
                showArrows: n
            })
        }
        cuselScrollToCurent(e)
    } else {
        e.css("display", "none");
        t.removeClass("cuselOpen")
    }
}

function cuSelRefresh(e) {
    var t = e.refreshEl.split(","),
        n = t.length,
        r;
    for (r = 0; r < n; r++) {
        var i = jQuery(t[r]).parents(".cusel").find(".cusel-scroll-wrap").eq(0);
        i.find(".cusel-scroll-pane").jScrollPaneRemoveCusel();
        i.css({
            visibility: "hidden",
            display: "block"
        });
        var s = i.find("span"),
            o = s.eq(0).outerHeight();
        if (s.length > e.visRows) {
            i.css({
                height: o * e.visRows + "px",
                display: "none",
                visibility: "visible"
            }).children(".cusel-scroll-pane").css("height", o * e.visRows + "px")
        } else {
            i.css({
                display: "none",
                visibility: "visible"
            })
        }
    }
}

function cuSel(e) {
    function t() {
        jQuery("html").unbind("click");
        jQuery("html").click(function (e) {
            var t = jQuery(e.target),
                n = t.attr("id"),
                r = t.prop("class");
            if ((r.indexOf("cuselText") != -1 || r.indexOf("cuselFrameRight") != -1) && t.parent().prop("class").indexOf("classDisCusel") == -1) {
                var i = t.parent().find(".cusel-scroll-wrap").eq(0);
                cuselShowList(i)
            } else if (r.indexOf("cusel") != -1 && r.indexOf("classDisCusel") == -1 && t.is("div")) {
                var i = t.find(".cusel-scroll-wrap").eq(0);
                cuselShowList(i)
            } else if (t.is(".cusel-scroll-wrap span") && r.indexOf("cuselActive") == -1) {
                var s;
                t.attr("val") == undefined ? s = t.text() : s = t.attr("val");
                t.parents(".cusel-scroll-wrap").find(".cuselActive").eq(0).removeClass("cuselActive").end().parents(".cusel-scroll-wrap").next().val(s).end().prev().text(t.text()).end().css("display", "none").parent(".cusel").removeClass("cuselOpen");
                t.addClass("cuselActive");
                t.parents(".cusel-scroll-wrap").find(".cuselOptHover").removeClass("cuselOptHover");
                if (r.indexOf("cuselActive") == -1) t.parents(".cusel").find(".cusel-scroll-wrap").eq(0).next("input").change()
            } else if (t.parents(".cusel-scroll-wrap").is("div")) {
                return
            } else {
                jQuery(".cusel-scroll-wrap").css("display", "none").parent(".cusel").removeClass("cuselOpen")
            }
        });
        jQuery(".cusel").unbind("keydown");
        jQuery(".cusel").keydown(function (e) {
            var t, n;
            if (window.event) t = window.event.keyCode;
            else if (e) t = e.which;
            if (t == null || t == 0 || t == 9) return true;
            if (jQuery(this).prop("class").indexOf("classDisCusel") != -1) return false;
            if (t == 40) {
                var r = jQuery(this).find(".cuselOptHover").eq(0);
                if (!r.is("span")) var i = jQuery(this).find(".cuselActive").eq(0);
                else var i = r;
                var s = i.next();
                if (s.is("span")) {
                    jQuery(this).find(".cuselText").eq(0).text(s.text());
                    i.removeClass("cuselOptHover");
                    s.addClass("cuselOptHover");
                    $(this).find("input").eq(0).val(s.attr("val"));
                    cuselScrollToCurent($(this).find(".cusel-scroll-wrap").eq(0));
                    return false
                } else return false
            }
            if (t == 38) {
                var r = $(this).find(".cuselOptHover").eq(0);
                if (!r.is("span")) var i = $(this).find(".cuselActive").eq(0);
                else var i = r;
                cuselActivePrev = i.prev();
                if (cuselActivePrev.is("span")) {
                    $(this).find(".cuselText").eq(0).text(cuselActivePrev.text());
                    i.removeClass("cuselOptHover");
                    cuselActivePrev.addClass("cuselOptHover");
                    $(this).find("input").eq(0).val(cuselActivePrev.attr("val"));
                    cuselScrollToCurent($(this).find(".cusel-scroll-wrap").eq(0));
                    return false
                } else return false
            }
            if (t == 27) {
                var o = $(this).find(".cuselActive").eq(0).text();
                $(this).removeClass("cuselOpen").find(".cusel-scroll-wrap").eq(0).css("display", "none").end().find(".cuselOptHover").eq(0).removeClass("cuselOptHover");
                $(this).find(".cuselText").eq(0).text(o)
            }
            if (t == 13) {
                var u = $(this).find(".cuselOptHover").eq(0);
                if (u.is("span")) {
                    $(this).find(".cuselActive").removeClass("cuselActive");
                    u.addClass("cuselActive")
                } else var a = $(this).find(".cuselActive").attr("val");
                $(this).removeClass("cuselOpen").find(".cusel-scroll-wrap").eq(0).css("display", "none").end().find(".cuselOptHover").eq(0).removeClass("cuselOptHover");
                $(this).find("input").eq(0).change()
            }
            if (t == 32 && $.browser.opera) {
                var f = $(this).find(".cusel-scroll-wrap").eq(0);
                cuselShowList(f)
            }
            if ($.browser.opera) return false
        });
        var e = [];
        jQuery(".cusel").keypress(function (t) {
            function n() {
                var t = [];
                for (var n in e) {
                    if (window.event) t[n] = e[n].keyCode;
                    else if (e[n]) t[n] = e[n].which;
                    t[n] = String.fromCharCode(t[n]).toUpperCase()
                }
                var r = jQuery(s).find("span"),
                    i = r.length,
                    o, u;
                for (o = 0; o < i; o++) {
                    var f = true;
                    for (var l in e) {
                        u = r.eq(o).text().charAt(l).toUpperCase();
                        if (u != t[l]) {
                            f = false
                        }
                    }
                    if (f) {
                        jQuery(s).find(".cuselOptHover").removeClass("cuselOptHover").end().find("span").eq(o).addClass("cuselOptHover").end().end().find(".cuselText").eq(0).text(r.eq(o).text());
                        cuselScrollToCurent($(s).find(".cusel-scroll-wrap").eq(0));
                        e = e.splice;
                        e = [];
                        break;
                        return true
                    }
                }
                e = e.splice;
                e = []
            }
            var r, i;
            if (window.event) r = window.event.keyCode;
            else if (t) r = t.which;
            if (r == null || r == 0 || r == 9) return true;
            if (jQuery(this).prop("class").indexOf("classDisCusel") != -1) return false;
            var s = this;
            e.push(t);
            clearTimeout(jQuery.data(this, "timer"));
            var o = setTimeout(function () {
                n()
            }, 500);
            jQuery(this).data("timer", o);
            if (jQuery.browser.opera && window.event.keyCode != 9) return false
        })
    }
    jQuery(e.changedEl).each(function (n) {
        var r = jQuery(this),
            s = r.outerWidth(),
            o = r.prop("class"),
            u = r.prop("id") ? r.prop("id") : "cuSel-" + n,
            f = r.prop("name"),
            l = r.val(),
            c = r.find("option[value='" + l + "']").eq(0),
            h = c.text(),
            p = r.prop("disabled"),
            d = e.scrollArrows,
            v = r.prop("onchange"),
            m = r.prop("tabindex"),
            g = r.prop("multiple");
        if (!u || g) return false;
        var y = r.data("events"),
            w = [];
        if (y && y["change"]) {
            $.each(y["change"], function (e, t) {
                w[w.length] = t
            })
        }
        if (!p) {
            classDisCuselText = "", classDisCusel = ""
        } else {
            classDisCuselText = "classDisCuselLabel";
            classDisCusel = "classDisCusel"
        } if (d) {
            classDisCusel += " cuselScrollArrows"
        }
        c.addClass("cuselActive");
        var E = r.html(),
            S = E.replace(/option/ig, "span").replace(/value=/ig, "val=");
        if (navigator.appName.indexOf("Microsoft Internet Explorer") != -1 && $("html").is(".ie6, .ie7, .ie8")) {
            var x = /(val=)(.*?)(>)/g;
            S = S.replace(x, "$1'$2'$3")
        }
        var T = '<div class="cusel ' + o + " " + classDisCusel + '"' + " id=cuselFrame-" + u + ' style="width:' + s + 'px"' + ' tabindex="' + m + '"' + ">" + '<div class="cuselFrameRight"></div>' + '<div class="cuselText">' + h + "</div>" + '<div class="cusel-scroll-wrap"><div class="cusel-scroll-pane" id="cusel-scroll-' + u + '">' + S + "</div></div>" + '<input type="hidden" id="' + u + '" name="' + f + '" value="' + l + '" />' + "</div>";
        r.replaceWith(T);
        if (v) jQuery("#" + u).bind("change", v);
        if (w.length) {
            $.each(w, function (e, t) {
                $("#" + u).bind("change", t)
            })
        }
        var N = jQuery("#cuselFrame-" + u),
            C = N.find("span"),
            k;
        if (!C.eq(0).text()) {
            k = C.eq(1).innerHeight();
            C.eq(0).css("height", C.eq(1).height())
        } else {
            k = C.eq(0).innerHeight()
        } if (C.length > e.visRows) {
            N.find(".cusel-scroll-wrap").eq(0).css({
                height: k * e.visRows + "px",
                display: "none",
                visibility: "visible"
            }).children(".cusel-scroll-pane").css("height", k * e.visRows + "px")
        } else {
            N.find(".cusel-scroll-wrap").eq(0).css({
                display: "none",
                visibility: "visible"
            })
        }
        var L = jQuery("#cusel-scroll-" + u).find("span[addTags]"),
            A = L.length;
        for (i = 0; i < A; i++) L.eq(i).append(L.eq(i).attr("addTags")).removeAttr("addTags");
        t()
    });
    jQuery(".cusel").focus(function () {
        jQuery(this).addClass("cuselFocus")
    });
    jQuery(".cusel").blur(function () {
        jQuery(this).removeClass("cuselFocus")
    });
    jQuery(".cusel").hover(function () {
        jQuery(this).addClass("cuselFocus")
    }, function () {
        jQuery(this).removeClass("cuselFocus")
    })
}(function (e) {
    e.jScrollPaneCusel = {
        active: []
    };
    e.fn.jScrollPaneCusel = function (t) {
        t = e.extend({}, e.fn.jScrollPaneCusel.defaults, t);
        var n = function () {
            return false
        };
        return this.each(function () {
            var r = e(this);
            var i = this.parentNode.offsetWidth - 2;			
            r.css("overflow", "hidden");
            var s = this;
            if (e(this).parent().is(".jScrollPaneContainer")) {
                var o = t.maintainPosition ? r.position().top : 0;
                var u = e(this).parent();
                var f = i;
                var l = u.outerHeight();
                var h = l;
                e(">.jScrollPaneTrack, >.jScrollArrowUp, >.jScrollArrowDown", u).remove();
                r.css({
                    top: 0
                })
            } else {
                var o = 0;
                this.originalPadding = r.css("paddingTop") + " " + r.css("paddingRight") + " " + r.css("paddingBottom") + " " + r.css("paddingLeft");
                this.originalSidePaddingTotal = (parseInt(r.css("paddingLeft")) || 0) + (parseInt(r.css("paddingRight")) || 0);
                var f = i;
                var l = r.innerHeight();
                var h = l;
                r.wrap("<div class='jScrollPaneContainer'></div>").parent().css({
                    height: l + "px",
                    width: f + "px"
                });
                if (!window.navigator.userProfile) {
                    var p = parseInt(e(this).parent().css("border-left-width")) + parseInt(e(this).parent().css("border-right-width"));
                    f -= p;
                    e(this).css("width", f + "px").parent().css("width", f + "px")
                }
                e(document).bind("emchange", function (e, n, i) {
                    r.jScrollPaneCusel(t)
                })
            } if (t.reinitialiseOnImageLoad) {
                var d = e.data(s, "jScrollPaneImagesToLoad") || e("img", r);
                var v = [];
                if (d.length) {
                    d.each(function (n, i) {
                        e(this).bind("load", function () {
                            if (e.inArray(n, v) == -1) {
                                v.push(i);
                                d = e.grep(d, function (e, t) {
                                    return e != i
                                });
                                e.data(s, "jScrollPaneImagesToLoad", d);
                                t.reinitialiseOnImageLoad = false;
                                r.jScrollPaneCusel(t)
                            }
                        }).each(function (e, t) {
                            if (this.complete || this.complete === undefined) {
                                this.src = this.src
                            }
                        })
                    })
                }
            }
            var m = this.originalSidePaddingTotal;
            var g = {
                height: "auto",
                width: f - t.scrollbarWidth - t.scrollbarMargin - m + "px"
            };
            if (t.scrollbarOnLeft) {
                g.paddingLeft = t.scrollbarMargin + t.scrollbarWidth + "px"
            } else {
                g.paddingRight = t.scrollbarMargin + "px"
            }
            r.css(g);
            var y = r.outerHeight();
            var w = l / y;
            if (w < .99) {
                var E = r.parent();
                E.append(e('<div class="jScrollPaneTrack"></div>').css({
                    width: t.scrollbarWidth + "px"
                }).append(e('<div class="jScrollPaneDrag"></div>').css({
                    width: t.scrollbarWidth + "px"
                }).append(e('<div class="jScrollPaneDragTop"></div>').css({
                    width: t.scrollbarWidth + "px"
                }), e('<div class="jScrollPaneDragBottom"></div>').css({
                    width: t.scrollbarWidth + "px"
                }))));
                var S = e(">.jScrollPaneTrack", E);
                var x = e(">.jScrollPaneTrack .jScrollPaneDrag", E);
                if (t.showArrows) {
                    var T;
                    var N;
                    var C;
                    var k;
                    var L = function () {
                        if (k > 4 || k % 4 == 0) {
                            X(F + N * j)
                        }
                        k++
                    };
                    var A = function (t) {
                        e("html").unbind("mouseup", A);
                        T.removeClass("jScrollActiveArrowButton");
                        clearInterval(C)
                    };
                    var O = function () {
                        e("html").bind("mouseup", A);
                        T.addClass("jScrollActiveArrowButton");
                        k = 0;
                        L();
                        C = setInterval(L, 100)
                    };
                    E.append(e("<div></div>").attr({
                        "class": "jScrollArrowUp"
                    }).css({
                        width: t.scrollbarWidth + "px"
                    }).bind("mousedown", function () {
                        T = e(this);
                        N = -1;
                        O();
                        this.blur();
                        return false
                    }).bind("click", n), e("<div></div>").attr({
                        "class": "jScrollArrowDown"
                    }).css({
                        width: t.scrollbarWidth + "px"
                    }).bind("mousedown", function () {
                        T = e(this);
                        N = 1;
                        O();
                        this.blur();
                        return false
                    }).bind("click", n));
                    var M = e(">.jScrollArrowUp", E);
                    var _ = e(">.jScrollArrowDown", E);
                    if (t.arrowSize) {
                        h = l - t.arrowSize - t.arrowSize;
                        S.css({
                            height: h + "px",
                            top: t.arrowSize + "px"
                        })
                    } else {
                        var D = M.height();
                        t.arrowSize = D;
                        h = l - D - _.height();
                        S.css({
                            height: h + "px",
                            top: D + "px"
                        })
                    }
                }
                var P = e(this).css({
                    position: "absolute",
                    overflow: "visible"
                });
                var H;
                var B;
                var j;
                var F = 0;
                var I = w * l / 2;
                var q = function (e, t) {
                    var n = t == "X" ? "Left" : "Top";
                    return e["page" + t] || e["client" + t] + (document.documentElement["scroll" + n] || document.body["scroll" + n]) || 0
                };
                var R = function () {
                    return false
                };
                var U = function () {
                    it();
                    H = x.offset();
                    H.top -= F;
                    B = h - x[0].offsetHeight;
                    j = 2 * t.wheelSpeed * B / y
                };
                var z = function (t) {
                    U();
                    I = q(t, "Y") - F - H.top;
                    e("html").bind("mouseup", W).bind("mousemove", V);
                    if (e.browser.msie) {
                        e("html").bind("dragstart", R).bind("selectstart", R)
                    }
                    return false
                };
                var W = function () {
                    e("html").unbind("mouseup", W).unbind("mousemove", V);
                    I = w * l / 2;
                    if (e.browser.msie) {
                        e("html").unbind("dragstart", R).unbind("selectstart", R)
                    }
                };
                var X = function (e) {
                    e = e < 0 ? 0 : e > B ? B : e;
                    F = e;
                    x.css({
                        top: e + "px"
                    });
                    var n = e / B;
                    P.css({
                        top: (l - y) * n + "px"
                    });
                    r.trigger("scroll");
                    if (t.showArrows) {
                        M[e == 0 ? "addClass" : "removeClass"]("disabled");
                        _[e == B ? "addClass" : "removeClass"]("disabled")
                    }
                };
                var V = function (e) {
                    X(q(e, "Y") - H.top - I)
                };
                var $ = Math.max(Math.min(w * (l - t.arrowSize * 2), t.dragMaxHeight), t.dragMinHeight);
                x.css({
                    height: $ + "px"
                }).bind("mousedown", z);
                var J;
                var K;
                var Q;
                var G = function () {
                    if (K > 8 || K % 4 == 0) {
                        X(F - (F - Q) / 2)
                    }
                    K++
                };
                var Y = function () {
                    clearInterval(J);
                    e("html").unbind("mouseup", Y).unbind("mousemove", Z)
                };
                var Z = function (e) {
                    Q = q(e, "Y") - H.top - I
                };
                var et = function (t) {
                    U();
                    Z(t);
                    K = 0;
                    e("html").bind("mouseup", Y).bind("mousemove", Z);
                    J = setInterval(G, 100);
                    G()
                };
                S.bind("mousedown", et);
                E.bind("mousewheel", function (e, t) {
                    U();
                    it();
                    var n = F;
                    X(F - t * j);
                    var r = n != F;
                    return false
                });
                var tt;
                var nt;

                function rt() {
                    var e = (tt - F) / t.animateStep;
                    if (e > 1 || e < -1) {
                        X(F + e)
                    } else {
                        X(tt);
                        it()
                    }
                }
                var it = function () {
                    if (nt) {
                        clearInterval(nt);
                        delete tt
                    }
                };
                var st = function (n, i) {
                    if (typeof n == "string") {
                        $e = e(n, r);
                        if (!$e.length) return;
                        n = $e.offset().top - r.offset().top
                    }
                    E.scrollTop(0);
                    it();
                    var s = -n / (l - y) * B;
                    if (i || !t.animateTo) {
                        X(s)
                    } else {
                        tt = s;
                        nt = setInterval(rt, t.animateInterval)
                    }
                };
                r[0].scrollTo = st;
                r[0].scrollBy = function (e) {
                    var t = -parseInt(P.css("top")) || 0;
                    st(t + e)
                };
                U();
                st(-o, true);
                e("*", this).bind("focus", function (n) {
                    var i = e(this);
                    var s = 0;
                    while (i[0] != r[0]) {
                        s += i.position().top;
                        i = i.offsetParent()
                    }
                    var o = -parseInt(P.css("top")) || 0;
                    var u = o + l;
                    var f = s > o && s < u;
                    if (!f) {
                        var c = s - t.scrollbarMargin;
                        if (s > o) {
                            c += e(this).height() + 15 + t.scrollbarMargin - l
                        }
                        st(c)
                    }
                });
                if (location.hash) {
                    st(location.hash)
                }
                e(document).bind("click", function (t) {
                    $target = e(t.target);
                    if ($target.is("a")) {
                        var n = $target.attr("href");
                        if (n.substr(0, 1) == "#") {
                            st(n)
                        }
                    }
                });
                e.jScrollPaneCusel.active.push(r[0])
            } else {
                r.css({
                    height: l + "px",
                    width: f - this.originalSidePaddingTotal + "px",
                    padding: this.originalPadding
                });
                r.parent().unbind("mousewheel")
            }
        })
    };
    e.fn.jScrollPaneRemoveCusel = function () {
        e(this).each(function () {
            $this = e(this);
            var t = $this.parent();
            if (t.is(".jScrollPaneContainer")) {
                $this.css({
                    top: "",
                    height: "",
                    width: "",
                    padding: "",
                    overflow: "",
                    position: ""
                });
                $this.attr("style", $this.data("originalStyleTag"));
                t.after($this).remove()
            }
        })
    };
    e.fn.jScrollPaneCusel.defaults = {
        scrollbarWidth: 10,
        scrollbarMargin: 5,
        wheelSpeed: 18,
        showArrows: false,
        arrowSize: 0,
        animateTo: false,
        dragMinHeight: 1,
        dragMaxHeight: 99999,
        animateInterval: 100,
        animateStep: 3,
        maintainPosition: true,
        scrollbarOnLeft: false,
        reinitialiseOnImageLoad: false
    };
    e(window).bind("unload", function () {
        var t = e.jScrollPaneCusel.active;
        for (var n = 0; n < t.length; n++) {
            t[n].scrollTo = t[n].scrollBy = null
        }
    })
})(jQuery);
(function (e) {
    function t(t) {
        var n = t || window.event,
            r = [].slice.call(arguments, 1),
            i = 0,
            s = !0,
            o = 0,
            u = 0;
        return t = e.event.fix(n), t.type = "mousewheel", n.wheelDelta && (i = n.wheelDelta / 120), n.detail && (i = -n.detail / 3), u = i, n.axis !== undefined && n.axis === n.HORIZONTAL_AXIS && (u = 0, o = -1 * i), n.wheelDeltaY !== undefined && (u = n.wheelDeltaY / 120), n.wheelDeltaX !== undefined && (o = -1 * n.wheelDeltaX / 120), r.unshift(t, i, o, u), (e.event.dispatch || e.event.handle).apply(this, r)
    }
    var n = ["DOMMouseScroll", "mousewheel"];
    if (e.event.fixHooks)
        for (var r = n.length; r;) e.event.fixHooks[n[--r]] = e.event.mouseHooks;
    e.event.special.mousewheel = {
        setup: function () {
            if (this.addEventListener)
                for (var e = n.length; e;) this.addEventListener(n[--e], t, !1);
            else this.onmousewheel = t
        },
        teardown: function () {
            if (this.removeEventListener)
                for (var e = n.length; e;) this.removeEventListener(n[--e], t, !1);
            else this.onmousewheel = null
        }
    }, e.fn.extend({
        mousewheel: function (e) {
            return e ? this.bind("mousewheel", e) : this.trigger("mousewheel")
        },
        unmousewheel: function (e) {
            return this.unbind("mousewheel", e)
        }
    })
})(jQuery)