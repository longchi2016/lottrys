var data=[
    {
        title: "基本选择器",
        child: [
            {name: "*  [通配符选择器]", isIE: "ok", isFir: "ok", isChr: "ok", isOpe: "ok", isSar: "ok"},
            {name: "E [元素选择器]", isIE: "ok", isFir: "ok", isChr: "ok", isOpe: "ok", isSar: "ok"},
            {name: "#id [ID选择器]", isIE: "ok", isFir: "ok", isChr: "ok", isOpe: "ok", isSar: "ok"},
            {name: ".class [类选择器]", isIE: "ok", isFir: "ok", isChr: "ok", isOpe: "ok", isSar: "ok"},
            {name: "selector1,selectorN [群组选择器]", isIE: "ok", isFir: "ok", isChr: "ok", isOpe: "ok", isSar: "ok"}
        ]
    },
    {
        title: "层次选择器",
        child: [
            {name: "E F [后代选择器]", isIE: "ok", isFir: "ok", isChr: "ok", isOpe: "ok", isSar: "ok"},
            {name: "E>F [子选择器]", isIE: "ok 7+", isFir: "ok", isChr: "ok", isOpe: "ok", isSar: "ok"},
            {name: "E+F [相邻兄弟选择器]", isIE: "ok 7+", isFir: "ok", isChr: "ok", isOpe: "ok", isSar: "ok"},
            {name: "E~F [通用兄弟选择器]", isIE: "ok 7+", isFir: "ok", isChr: "ok", isOpe: "ok", isSar: "ok"}
        ]
    },
    {
        title: "动态伪类选择器",
        child: [
            {name: "E:link [链接伪类选择器,未访问]", isIE: "ok", isFir: "ok", isChr: "ok", isOpe: "ok", isSar: "ok"},
            {name: "E:visited [链接伪类选择器,已访问]", isIE: "ok", isFir: "ok", isChr: "ok", isOpe: "ok", isSar: "ok"},
            {name: "E:active [行为之元素激活]", isIE: "ok 8+", isFir: "ok", isChr: "ok", isOpe: "ok", isSar: "ok"},
            {name: "E:hover [行为之鼠标停留]", isIE: "ok", isFir: "ok", isChr: "ok", isOpe: "ok", isSar: "ok"},
            {name: "E:focus [行为之获取焦点]", isIE: "ok 8+", isFir: "ok", isChr: "ok", isOpe: "ok", isSar: "ok"}
        ]
    },
    {
        title: "目标伪类选择器",
        child: [
            {name: "E:target [目标伪类选择器]", isIE: "ok 9+", isFir: "ok", isChr: "ok", isOpe: "ok 9.6+", isSar: "ok"}
        ]
    },
    {
        title: "UI元素状态伪类选择器",
        child: [
            {name: "E:checked [选中状态]", isIE: "ok 9+", isFir: "ok", isChr: "ok", isOpe: "ok", isSar: "ok"},
            {name: "E:enabled [启用状态]", isIE: "ok 9+", isFir: "ok", isChr: "ok", isOpe: "ok", isSar: "ok"},
            {name: "E:disabled [不可用状态]", isIE: "ok 9+", isFir: "ok", isChr: "ok", isOpe: "ok", isSar: "ok"}
        ]
    },
    {
        title: "结构伪类选择器",
        child: [
            {name: "E:first-child [第一个子元素]", isIE: "ok 9+", isFir: "ok", isChr: "ok", isOpe: "ok", isSar: "ok"},
            {name: "E:last-child [最后一个子元素]", isIE: "ok 9+", isFir: "ok", isChr: "ok", isOpe: "ok", isSar: "ok"},
            {
                name: "E F:nth-child(n) [E下的第n个子元素F] 注:n从1开始,可以是数字,也可以是even、odd,还可以是公式:2n/2n+1/n+5(从第五个开始)/-n+5(第一个到第五个)...",
                isIE: "ok 9+",
                isFir: "ok",
                isChr: "ok",
                isOpe: "ok",
                isSar: "ok"
            },
            {
                name: "E F:nth-last-child(n) [选择倒数第n个]",
                isIE: "ok 9+",
                isFir: "ok",
                isChr: "ok",
                isOpe: "ok",
                isSar: "ok"
            },
            {name: "E:root [E所在文档的根元素]", isIE: "ok 9+", isFir: "ok", isChr: "ok", isOpe: "ok", isSar: "ok"},
            {name: "E:only-child [只有一个子元素]", isIE: "ok 9+", isFir: "ok", isChr: "ok", isOpe: "ok", isSar: "ok"},
            {name: "E:empty [一个子元素都没有的]", isIE: "ok 9+", isFir: "ok", isChr: "ok", isOpe: "ok", isSar: "ok"}
        ]
    },
    {
        title: "否定伪类选择器",
        child: [
            {name: "E:not(F) [匹配除了F外的E元素]", isIE: "ok 9+", isFir: "ok", isChr: "ok", isOpe: "ok", isSar: "ok"}
        ]
    }, {
        title: "属性选择器",
        child: [
            {name: "E[attr] [具有attr属性的元素]", isIE: "ok 7+", isFir: "ok", isChr: "ok", isOpe: "ok", isSar: "ok"},
            {
                name: "E[attr=val] [attr属性等于val的元素]",
                isIE: "ok 7+",
                isFir: "ok",
                isChr: "ok",
                isOpe: "ok",
                isSar: "ok"
            },
            {
                name: "E[attr|=val] [attr具有val或者以val-开始的元素]",
                isIE: "ok 7+",
                isFir: "ok",
                isChr: "ok",
                isOpe: "ok",
                isSar: "ok"
            },
            {
                name: "E[attr~=val] [attr具有多个空格分开的值，其中有一个是val的元素]",
                isIE: "ok 7+",
                isFir: "ok",
                isChr: "ok",
                isOpe: "ok",
                isSar: "ok"
            },
            {
                name: "E[attr*=val] [attr包含val的元素]",
                isIE: "ok 7+",
                isFir: "ok",
                isChr: "ok",
                isOpe: "ok",
                isSar: "ok"
            },
            {
                name: "E[attr^=val] [attr以val开头的元素]",
                isIE: "ok 7+",
                isFir: "ok",
                isChr: "ok",
                isOpe: "ok",
                isSar: "ok"
            },
            {
                name: "E[attr$=val] [attr以val结尾的元素]",
                isIE: "ok 7+",
                isFir: "ok",
                isChr: "ok",
                isOpe: "ok",
                isSar: "ok"
            }
        ]
    }
];