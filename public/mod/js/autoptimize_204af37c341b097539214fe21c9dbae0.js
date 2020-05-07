jQuery(document).ready(function($) {
    if (scriptParams.simple_banner_text != "") {
        if (!scriptParams.pro_version_enabled || (scriptParams.pro_version_enabled && !scriptParams.in_array)) {
            $('<div id="simple-banner" class="simple-banner"><div class="simple-banner-text"><span>' + scriptParams.simple_banner_text + '</span></div></div>').prependTo('body');
            var bodyPaddingLeft = $('body').css('padding-left')
            var bodyPaddingRight = $('body').css('padding-right')
            if (bodyPaddingLeft != "0px") { $('head').append('<style type="text/css" media="screen">.simple-banner{margin-left:-' + bodyPaddingLeft + ';padding-left:' + bodyPaddingLeft + ';}</style>'); }
            if (bodyPaddingRight != "0px") { $('head').append('<style type="text/css" media="screen">.simple-banner{margin-right:-' + bodyPaddingRight + ';padding-right:' + bodyPaddingRight + ';}</style>'); }
        }
    }
    if (scriptParams.pro_version_enabled && scriptParams.debug_mode) { console.log(scriptParams); }
});
(function(global, factory) { typeof exports === 'object' && typeof module !== 'undefined' ? module.exports = factory() : typeof define === 'function' && define.amd ? define(factory) : (global.Popper = factory()); }(this, (function() {
    'use strict';
    var isBrowser = typeof window !== 'undefined' && typeof document !== 'undefined';
    var longerTimeoutBrowsers = ['Edge', 'Trident', 'Firefox'];
    var timeoutDuration = 0;
    for (var i = 0; i < longerTimeoutBrowsers.length; i += 1) { if (isBrowser && navigator.userAgent.indexOf(longerTimeoutBrowsers[i]) >= 0) { timeoutDuration = 1; break; } }

    function microtaskDebounce(fn) {
        var called = false;
        return function() {
            if (called) { return; }
            called = true;
            window.Promise.resolve().then(function() {
                called = false;
                fn();
            });
        };
    }

    function taskDebounce(fn) {
        var scheduled = false;
        return function() {
            if (!scheduled) {
                scheduled = true;
                setTimeout(function() {
                    scheduled = false;
                    fn();
                }, timeoutDuration);
            }
        };
    }
    var supportsMicroTasks = isBrowser && window.Promise;
    var debounce = supportsMicroTasks ? microtaskDebounce : taskDebounce;

    function isFunction(functionToCheck) { var getType = {}; return functionToCheck && getType.toString.call(functionToCheck) === '[object Function]'; }

    function getStyleComputedProperty(element, property) {
        if (element.nodeType !== 1) { return []; }
        var window = element.ownerDocument.defaultView;
        var css = window.getComputedStyle(element, null);
        return property ? css[property] : css;
    }

    function getParentNode(element) {
        if (element.nodeName === 'HTML') { return element; }
        return element.parentNode || element.host;
    }

    function getScrollParent(element) {
        if (!element) { return document.body; }
        switch (element.nodeName) {
            case 'HTML':
            case 'BODY':
                return element.ownerDocument.body;
            case '#document':
                return element.body;
        }
        var _getStyleComputedProp = getStyleComputedProperty(element),
            overflow = _getStyleComputedProp.overflow,
            overflowX = _getStyleComputedProp.overflowX,
            overflowY = _getStyleComputedProp.overflowY;
        if (/(auto|scroll|overlay)/.test(overflow + overflowY + overflowX)) { return element; }
        return getScrollParent(getParentNode(element));
    }
    var isIE11 = isBrowser && !!(window.MSInputMethodContext && document.documentMode);
    var isIE10 = isBrowser && /MSIE 10/.test(navigator.userAgent);

    function isIE(version) {
        if (version === 11) { return isIE11; }
        if (version === 10) { return isIE10; }
        return isIE11 || isIE10;
    }

    function getOffsetParent(element) {
        if (!element) { return document.documentElement; }
        var noOffsetParent = isIE(10) ? document.body : null;
        var offsetParent = element.offsetParent || null;
        while (offsetParent === noOffsetParent && element.nextElementSibling) { offsetParent = (element = element.nextElementSibling).offsetParent; }
        var nodeName = offsetParent && offsetParent.nodeName;
        if (!nodeName || nodeName === 'BODY' || nodeName === 'HTML') { return element ? element.ownerDocument.documentElement : document.documentElement; }
        if (['TH', 'TD', 'TABLE'].indexOf(offsetParent.nodeName) !== -1 && getStyleComputedProperty(offsetParent, 'position') === 'static') { return getOffsetParent(offsetParent); }
        return offsetParent;
    }

    function isOffsetContainer(element) {
        var nodeName = element.nodeName;
        if (nodeName === 'BODY') { return false; }
        return nodeName === 'HTML' || getOffsetParent(element.firstElementChild) === element;
    }

    function getRoot(node) {
        if (node.parentNode !== null) { return getRoot(node.parentNode); }
        return node;
    }

    function findCommonOffsetParent(element1, element2) {
        if (!element1 || !element1.nodeType || !element2 || !element2.nodeType) { return document.documentElement; }
        var order = element1.compareDocumentPosition(element2) & Node.DOCUMENT_POSITION_FOLLOWING;
        var start = order ? element1 : element2;
        var end = order ? element2 : element1;
        var range = document.createRange();
        range.setStart(start, 0);
        range.setEnd(end, 0);
        var commonAncestorContainer = range.commonAncestorContainer;
        if (element1 !== commonAncestorContainer && element2 !== commonAncestorContainer || start.contains(end)) {
            if (isOffsetContainer(commonAncestorContainer)) { return commonAncestorContainer; }
            return getOffsetParent(commonAncestorContainer);
        }
        var element1root = getRoot(element1);
        if (element1root.host) { return findCommonOffsetParent(element1root.host, element2); } else { return findCommonOffsetParent(element1, getRoot(element2).host); }
    }

    function getScroll(element) {
        var side = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 'top';
        var upperSide = side === 'top' ? 'scrollTop' : 'scrollLeft';
        var nodeName = element.nodeName;
        if (nodeName === 'BODY' || nodeName === 'HTML') { var html = element.ownerDocument.documentElement; var scrollingElement = element.ownerDocument.scrollingElement || html; return scrollingElement[upperSide]; }
        return element[upperSide];
    }

    function includeScroll(rect, element) {
        var subtract = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : false;
        var scrollTop = getScroll(element, 'top');
        var scrollLeft = getScroll(element, 'left');
        var modifier = subtract ? -1 : 1;
        rect.top += scrollTop * modifier;
        rect.bottom += scrollTop * modifier;
        rect.left += scrollLeft * modifier;
        rect.right += scrollLeft * modifier;
        return rect;
    }

    function getBordersSize(styles, axis) { var sideA = axis === 'x' ? 'Left' : 'Top'; var sideB = sideA === 'Left' ? 'Right' : 'Bottom'; return parseFloat(styles['border' + sideA + 'Width'], 10) + parseFloat(styles['border' + sideB + 'Width'], 10); }

    function getSize(axis, body, html, computedStyle) { return Math.max(body['offset' + axis], body['scroll' + axis], html['client' + axis], html['offset' + axis], html['scroll' + axis], isIE(10) ? parseInt(html['offset' + axis]) + parseInt(computedStyle['margin' + (axis === 'Height' ? 'Top' : 'Left')]) + parseInt(computedStyle['margin' + (axis === 'Height' ? 'Bottom' : 'Right')]) : 0); }

    function getWindowSizes(document) { var body = document.body; var html = document.documentElement; var computedStyle = isIE(10) && getComputedStyle(html); return { height: getSize('Height', body, html, computedStyle), width: getSize('Width', body, html, computedStyle) }; }
    var classCallCheck = function(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } };
    var createClass = function() {
        function defineProperties(target, props) {
            for (var i = 0; i < props.length; i++) {
                var descriptor = props[i];
                descriptor.enumerable = descriptor.enumerable || false;
                descriptor.configurable = true;
                if ("value" in descriptor) descriptor.writable = true;
                Object.defineProperty(target, descriptor.key, descriptor);
            }
        }
        return function(Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; };
    }();
    var defineProperty = function(obj, key, value) {
        if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; }
        return obj;
    };
    var _extends = Object.assign || function(target) {
        for (var i = 1; i < arguments.length; i++) { var source = arguments[i]; for (var key in source) { if (Object.prototype.hasOwnProperty.call(source, key)) { target[key] = source[key]; } } }
        return target;
    };

    function getClientRect(offsets) { return _extends({}, offsets, { right: offsets.left + offsets.width, bottom: offsets.top + offsets.height }); }

    function getBoundingClientRect(element) {
        var rect = {};
        try {
            if (isIE(10)) {
                rect = element.getBoundingClientRect();
                var scrollTop = getScroll(element, 'top');
                var scrollLeft = getScroll(element, 'left');
                rect.top += scrollTop;
                rect.left += scrollLeft;
                rect.bottom += scrollTop;
                rect.right += scrollLeft;
            } else { rect = element.getBoundingClientRect(); }
        } catch (e) {}
        var result = { left: rect.left, top: rect.top, width: rect.right - rect.left, height: rect.bottom - rect.top };
        var sizes = element.nodeName === 'HTML' ? getWindowSizes(element.ownerDocument) : {};
        var width = sizes.width || element.clientWidth || result.right - result.left;
        var height = sizes.height || element.clientHeight || result.bottom - result.top;
        var horizScrollbar = element.offsetWidth - width;
        var vertScrollbar = element.offsetHeight - height;
        if (horizScrollbar || vertScrollbar) {
            var styles = getStyleComputedProperty(element);
            horizScrollbar -= getBordersSize(styles, 'x');
            vertScrollbar -= getBordersSize(styles, 'y');
            result.width -= horizScrollbar;
            result.height -= vertScrollbar;
        }
        return getClientRect(result);
    }

    function getOffsetRectRelativeToArbitraryNode(children, parent) {
        var fixedPosition = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : false;
        var isIE10 = isIE(10);
        var isHTML = parent.nodeName === 'HTML';
        var childrenRect = getBoundingClientRect(children);
        var parentRect = getBoundingClientRect(parent);
        var scrollParent = getScrollParent(children);
        var styles = getStyleComputedProperty(parent);
        var borderTopWidth = parseFloat(styles.borderTopWidth, 10);
        var borderLeftWidth = parseFloat(styles.borderLeftWidth, 10);
        if (fixedPosition && isHTML) {
            parentRect.top = Math.max(parentRect.top, 0);
            parentRect.left = Math.max(parentRect.left, 0);
        }
        var offsets = getClientRect({ top: childrenRect.top - parentRect.top - borderTopWidth, left: childrenRect.left - parentRect.left - borderLeftWidth, width: childrenRect.width, height: childrenRect.height });
        offsets.marginTop = 0;
        offsets.marginLeft = 0;
        if (!isIE10 && isHTML) {
            var marginTop = parseFloat(styles.marginTop, 10);
            var marginLeft = parseFloat(styles.marginLeft, 10);
            offsets.top -= borderTopWidth - marginTop;
            offsets.bottom -= borderTopWidth - marginTop;
            offsets.left -= borderLeftWidth - marginLeft;
            offsets.right -= borderLeftWidth - marginLeft;
            offsets.marginTop = marginTop;
            offsets.marginLeft = marginLeft;
        }
        if (isIE10 && !fixedPosition ? parent.contains(scrollParent) : parent === scrollParent && scrollParent.nodeName !== 'BODY') { offsets = includeScroll(offsets, parent); }
        return offsets;
    }

    function getViewportOffsetRectRelativeToArtbitraryNode(element) { var excludeScroll = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : false; var html = element.ownerDocument.documentElement; var relativeOffset = getOffsetRectRelativeToArbitraryNode(element, html); var width = Math.max(html.clientWidth, window.innerWidth || 0); var height = Math.max(html.clientHeight, window.innerHeight || 0); var scrollTop = !excludeScroll ? getScroll(html) : 0; var scrollLeft = !excludeScroll ? getScroll(html, 'left') : 0; var offset = { top: scrollTop - relativeOffset.top + relativeOffset.marginTop, left: scrollLeft - relativeOffset.left + relativeOffset.marginLeft, width: width, height: height }; return getClientRect(offset); }

    function isFixed(element) {
        var nodeName = element.nodeName;
        if (nodeName === 'BODY' || nodeName === 'HTML') { return false; }
        if (getStyleComputedProperty(element, 'position') === 'fixed') { return true; }
        return isFixed(getParentNode(element));
    }

    function getFixedPositionOffsetParent(element) {
        if (!element || !element.parentElement || isIE()) { return document.documentElement; }
        var el = element.parentElement;
        while (el && getStyleComputedProperty(el, 'transform') === 'none') { el = el.parentElement; }
        return el || document.documentElement;
    }

    function getBoundaries(popper, reference, padding, boundariesElement) {
        var fixedPosition = arguments.length > 4 && arguments[4] !== undefined ? arguments[4] : false;
        var boundaries = { top: 0, left: 0 };
        var offsetParent = fixedPosition ? getFixedPositionOffsetParent(popper) : findCommonOffsetParent(popper, reference);
        if (boundariesElement === 'viewport') { boundaries = getViewportOffsetRectRelativeToArtbitraryNode(offsetParent, fixedPosition); } else {
            var boundariesNode = void 0;
            if (boundariesElement === 'scrollParent') { boundariesNode = getScrollParent(getParentNode(reference)); if (boundariesNode.nodeName === 'BODY') { boundariesNode = popper.ownerDocument.documentElement; } } else if (boundariesElement === 'window') { boundariesNode = popper.ownerDocument.documentElement; } else { boundariesNode = boundariesElement; }
            var offsets = getOffsetRectRelativeToArbitraryNode(boundariesNode, offsetParent, fixedPosition);
            if (boundariesNode.nodeName === 'HTML' && !isFixed(offsetParent)) {
                var _getWindowSizes = getWindowSizes(popper.ownerDocument),
                    height = _getWindowSizes.height,
                    width = _getWindowSizes.width;
                boundaries.top += offsets.top - offsets.marginTop;
                boundaries.bottom = height + offsets.top;
                boundaries.left += offsets.left - offsets.marginLeft;
                boundaries.right = width + offsets.left;
            } else { boundaries = offsets; }
        }
        padding = padding || 0;
        var isPaddingNumber = typeof padding === 'number';
        boundaries.left += isPaddingNumber ? padding : padding.left || 0;
        boundaries.top += isPaddingNumber ? padding : padding.top || 0;
        boundaries.right -= isPaddingNumber ? padding : padding.right || 0;
        boundaries.bottom -= isPaddingNumber ? padding : padding.bottom || 0;
        return boundaries;
    }

    function getArea(_ref) {
        var width = _ref.width,
            height = _ref.height;
        return width * height;
    }

    function computeAutoPlacement(placement, refRect, popper, reference, boundariesElement) {
        var padding = arguments.length > 5 && arguments[5] !== undefined ? arguments[5] : 0;
        if (placement.indexOf('auto') === -1) { return placement; }
        var boundaries = getBoundaries(popper, reference, padding, boundariesElement);
        var rects = { top: { width: boundaries.width, height: refRect.top - boundaries.top }, right: { width: boundaries.right - refRect.right, height: boundaries.height }, bottom: { width: boundaries.width, height: boundaries.bottom - refRect.bottom }, left: { width: refRect.left - boundaries.left, height: boundaries.height } };
        var sortedAreas = Object.keys(rects).map(function(key) { return _extends({ key: key }, rects[key], { area: getArea(rects[key]) }); }).sort(function(a, b) { return b.area - a.area; });
        var filteredAreas = sortedAreas.filter(function(_ref2) {
            var width = _ref2.width,
                height = _ref2.height;
            return width >= popper.clientWidth && height >= popper.clientHeight;
        });
        var computedPlacement = filteredAreas.length > 0 ? filteredAreas[0].key : sortedAreas[0].key;
        var variation = placement.split('-')[1];
        return computedPlacement + (variation ? '-' + variation : '');
    }

    function getReferenceOffsets(state, popper, reference) { var fixedPosition = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : null; var commonOffsetParent = fixedPosition ? getFixedPositionOffsetParent(popper) : findCommonOffsetParent(popper, reference); return getOffsetRectRelativeToArbitraryNode(reference, commonOffsetParent, fixedPosition); }

    function getOuterSizes(element) { var window = element.ownerDocument.defaultView; var styles = window.getComputedStyle(element); var x = parseFloat(styles.marginTop) + parseFloat(styles.marginBottom); var y = parseFloat(styles.marginLeft) + parseFloat(styles.marginRight); var result = { width: element.offsetWidth + y, height: element.offsetHeight + x }; return result; }

    function getOppositePlacement(placement) { var hash = { left: 'right', right: 'left', bottom: 'top', top: 'bottom' }; return placement.replace(/left|right|bottom|top/g, function(matched) { return hash[matched]; }); }

    function getPopperOffsets(popper, referenceOffsets, placement) {
        placement = placement.split('-')[0];
        var popperRect = getOuterSizes(popper);
        var popperOffsets = { width: popperRect.width, height: popperRect.height };
        var isHoriz = ['right', 'left'].indexOf(placement) !== -1;
        var mainSide = isHoriz ? 'top' : 'left';
        var secondarySide = isHoriz ? 'left' : 'top';
        var measurement = isHoriz ? 'height' : 'width';
        var secondaryMeasurement = !isHoriz ? 'height' : 'width';
        popperOffsets[mainSide] = referenceOffsets[mainSide] + referenceOffsets[measurement] / 2 - popperRect[measurement] / 2;
        if (placement === secondarySide) { popperOffsets[secondarySide] = referenceOffsets[secondarySide] - popperRect[secondaryMeasurement]; } else { popperOffsets[secondarySide] = referenceOffsets[getOppositePlacement(secondarySide)]; }
        return popperOffsets;
    }

    function find(arr, check) {
        if (Array.prototype.find) { return arr.find(check); }
        return arr.filter(check)[0];
    }

    function findIndex(arr, prop, value) {
        if (Array.prototype.findIndex) { return arr.findIndex(function(cur) { return cur[prop] === value; }); }
        var match = find(arr, function(obj) { return obj[prop] === value; });
        return arr.indexOf(match);
    }

    function runModifiers(modifiers, data, ends) {
        var modifiersToRun = ends === undefined ? modifiers : modifiers.slice(0, findIndex(modifiers, 'name', ends));
        modifiersToRun.forEach(function(modifier) {
            if (modifier['function']) { console.warn('`modifier.function` is deprecated, use `modifier.fn`!'); }
            var fn = modifier['function'] || modifier.fn;
            if (modifier.enabled && isFunction(fn)) {
                data.offsets.popper = getClientRect(data.offsets.popper);
                data.offsets.reference = getClientRect(data.offsets.reference);
                data = fn(data, modifier);
            }
        });
        return data;
    }

    function update() {
        if (this.state.isDestroyed) { return; }
        var data = { instance: this, styles: {}, arrowStyles: {}, attributes: {}, flipped: false, offsets: {} };
        data.offsets.reference = getReferenceOffsets(this.state, this.popper, this.reference, this.options.positionFixed);
        data.placement = computeAutoPlacement(this.options.placement, data.offsets.reference, this.popper, this.reference, this.options.modifiers.flip.boundariesElement, this.options.modifiers.flip.padding);
        data.originalPlacement = data.placement;
        data.positionFixed = this.options.positionFixed;
        data.offsets.popper = getPopperOffsets(this.popper, data.offsets.reference, data.placement);
        data.offsets.popper.position = this.options.positionFixed ? 'fixed' : 'absolute';
        data = runModifiers(this.modifiers, data);
        if (!this.state.isCreated) {
            this.state.isCreated = true;
            this.options.onCreate(data);
        } else { this.options.onUpdate(data); }
    }

    function isModifierEnabled(modifiers, modifierName) {
        return modifiers.some(function(_ref) {
            var name = _ref.name,
                enabled = _ref.enabled;
            return enabled && name === modifierName;
        });
    }

    function getSupportedPropertyName(property) {
        var prefixes = [false, 'ms', 'Webkit', 'Moz', 'O'];
        var upperProp = property.charAt(0).toUpperCase() + property.slice(1);
        for (var i = 0; i < prefixes.length; i++) { var prefix = prefixes[i]; var toCheck = prefix ? '' + prefix + upperProp : property; if (typeof document.body.style[toCheck] !== 'undefined') { return toCheck; } }
        return null;
    }

    function destroy() {
        this.state.isDestroyed = true;
        if (isModifierEnabled(this.modifiers, 'applyStyle')) {
            this.popper.removeAttribute('x-placement');
            this.popper.style.position = '';
            this.popper.style.top = '';
            this.popper.style.left = '';
            this.popper.style.right = '';
            this.popper.style.bottom = '';
            this.popper.style.willChange = '';
            this.popper.style[getSupportedPropertyName('transform')] = '';
        }
        this.disableEventListeners();
        if (this.options.removeOnDestroy) { this.popper.parentNode.removeChild(this.popper); }
        return this;
    }

    function getWindow(element) { var ownerDocument = element.ownerDocument; return ownerDocument ? ownerDocument.defaultView : window; }

    function attachToScrollParents(scrollParent, event, callback, scrollParents) {
        var isBody = scrollParent.nodeName === 'BODY';
        var target = isBody ? scrollParent.ownerDocument.defaultView : scrollParent;
        target.addEventListener(event, callback, { passive: true });
        if (!isBody) { attachToScrollParents(getScrollParent(target.parentNode), event, callback, scrollParents); }
        scrollParents.push(target);
    }

    function setupEventListeners(reference, options, state, updateBound) {
        state.updateBound = updateBound;
        getWindow(reference).addEventListener('resize', state.updateBound, { passive: true });
        var scrollElement = getScrollParent(reference);
        attachToScrollParents(scrollElement, 'scroll', state.updateBound, state.scrollParents);
        state.scrollElement = scrollElement;
        state.eventsEnabled = true;
        return state;
    }

    function enableEventListeners() { if (!this.state.eventsEnabled) { this.state = setupEventListeners(this.reference, this.options, this.state, this.scheduleUpdate); } }

    function removeEventListeners(reference, state) {
        getWindow(reference).removeEventListener('resize', state.updateBound);
        state.scrollParents.forEach(function(target) { target.removeEventListener('scroll', state.updateBound); });
        state.updateBound = null;
        state.scrollParents = [];
        state.scrollElement = null;
        state.eventsEnabled = false;
        return state;
    }

    function disableEventListeners() {
        if (this.state.eventsEnabled) {
            cancelAnimationFrame(this.scheduleUpdate);
            this.state = removeEventListeners(this.reference, this.state);
        }
    }

    function isNumeric(n) { return n !== '' && !isNaN(parseFloat(n)) && isFinite(n); }

    function setStyles(element, styles) {
        Object.keys(styles).forEach(function(prop) {
            var unit = '';
            if (['width', 'height', 'top', 'right', 'bottom', 'left'].indexOf(prop) !== -1 && isNumeric(styles[prop])) { unit = 'px'; }
            element.style[prop] = styles[prop] + unit;
        });
    }

    function setAttributes(element, attributes) { Object.keys(attributes).forEach(function(prop) { var value = attributes[prop]; if (value !== false) { element.setAttribute(prop, attributes[prop]); } else { element.removeAttribute(prop); } }); }

    function applyStyle(data) {
        setStyles(data.instance.popper, data.styles);
        setAttributes(data.instance.popper, data.attributes);
        if (data.arrowElement && Object.keys(data.arrowStyles).length) { setStyles(data.arrowElement, data.arrowStyles); }
        return data;
    }

    function applyStyleOnLoad(reference, popper, options, modifierOptions, state) {
        var referenceOffsets = getReferenceOffsets(state, popper, reference, options.positionFixed);
        var placement = computeAutoPlacement(options.placement, referenceOffsets, popper, reference, options.modifiers.flip.boundariesElement, options.modifiers.flip.padding);
        popper.setAttribute('x-placement', placement);
        setStyles(popper, { position: options.positionFixed ? 'fixed' : 'absolute' });
        return options;
    }

    function computeStyle(data, options) {
        var x = options.x,
            y = options.y;
        var popper = data.offsets.popper;
        var legacyGpuAccelerationOption = find(data.instance.modifiers, function(modifier) { return modifier.name === 'applyStyle'; }).gpuAcceleration;
        if (legacyGpuAccelerationOption !== undefined) { console.warn('WARNING: `gpuAcceleration` option moved to `computeStyle` modifier and will not be supported in future versions of Popper.js!'); }
        var gpuAcceleration = legacyGpuAccelerationOption !== undefined ? legacyGpuAccelerationOption : options.gpuAcceleration;
        var offsetParent = getOffsetParent(data.instance.popper);
        var offsetParentRect = getBoundingClientRect(offsetParent);
        var styles = { position: popper.position };
        var offsets = { left: Math.floor(popper.left), top: Math.round(popper.top), bottom: Math.round(popper.bottom), right: Math.floor(popper.right) };
        var sideA = x === 'bottom' ? 'top' : 'bottom';
        var sideB = y === 'right' ? 'left' : 'right';
        var prefixedProperty = getSupportedPropertyName('transform');
        var left = void 0,
            top = void 0;
        if (sideA === 'bottom') { if (offsetParent.nodeName === 'HTML') { top = -offsetParent.clientHeight + offsets.bottom; } else { top = -offsetParentRect.height + offsets.bottom; } } else { top = offsets.top; }
        if (sideB === 'right') { if (offsetParent.nodeName === 'HTML') { left = -offsetParent.clientWidth + offsets.right; } else { left = -offsetParentRect.width + offsets.right; } } else { left = offsets.left; }
        if (gpuAcceleration && prefixedProperty) {
            styles[prefixedProperty] = 'translate3d(' + left + 'px, ' + top + 'px, 0)';
            styles[sideA] = 0;
            styles[sideB] = 0;
            styles.willChange = 'transform';
        } else {
            var invertTop = sideA === 'bottom' ? -1 : 1;
            var invertLeft = sideB === 'right' ? -1 : 1;
            styles[sideA] = top * invertTop;
            styles[sideB] = left * invertLeft;
            styles.willChange = sideA + ', ' + sideB;
        }
        var attributes = { 'x-placement': data.placement };
        data.attributes = _extends({}, attributes, data.attributes);
        data.styles = _extends({}, styles, data.styles);
        data.arrowStyles = _extends({}, data.offsets.arrow, data.arrowStyles);
        return data;
    }

    function isModifierRequired(modifiers, requestingName, requestedName) {
        var requesting = find(modifiers, function(_ref) { var name = _ref.name; return name === requestingName; });
        var isRequired = !!requesting && modifiers.some(function(modifier) { return modifier.name === requestedName && modifier.enabled && modifier.order < requesting.order; });
        if (!isRequired) {
            var _requesting = '`' + requestingName + '`';
            var requested = '`' + requestedName + '`';
            console.warn(requested + ' modifier is required by ' + _requesting + ' modifier in order to work, be sure to include it before ' + _requesting + '!');
        }
        return isRequired;
    }

    function arrow(data, options) {
        var _data$offsets$arrow;
        if (!isModifierRequired(data.instance.modifiers, 'arrow', 'keepTogether')) { return data; }
        var arrowElement = options.element;
        if (typeof arrowElement === 'string') { arrowElement = data.instance.popper.querySelector(arrowElement); if (!arrowElement) { return data; } } else { if (!data.instance.popper.contains(arrowElement)) { console.warn('WARNING: `arrow.element` must be child of its popper element!'); return data; } }
        var placement = data.placement.split('-')[0];
        var _data$offsets = data.offsets,
            popper = _data$offsets.popper,
            reference = _data$offsets.reference;
        var isVertical = ['left', 'right'].indexOf(placement) !== -1;
        var len = isVertical ? 'height' : 'width';
        var sideCapitalized = isVertical ? 'Top' : 'Left';
        var side = sideCapitalized.toLowerCase();
        var altSide = isVertical ? 'left' : 'top';
        var opSide = isVertical ? 'bottom' : 'right';
        var arrowElementSize = getOuterSizes(arrowElement)[len];
        if (reference[opSide] - arrowElementSize < popper[side]) { data.offsets.popper[side] -= popper[side] - (reference[opSide] - arrowElementSize); }
        if (reference[side] + arrowElementSize > popper[opSide]) { data.offsets.popper[side] += reference[side] + arrowElementSize - popper[opSide]; }
        data.offsets.popper = getClientRect(data.offsets.popper);
        var center = reference[side] + reference[len] / 2 - arrowElementSize / 2;
        var css = getStyleComputedProperty(data.instance.popper);
        var popperMarginSide = parseFloat(css['margin' + sideCapitalized], 10);
        var popperBorderSide = parseFloat(css['border' + sideCapitalized + 'Width'], 10);
        var sideValue = center - data.offsets.popper[side] - popperMarginSide - popperBorderSide;
        sideValue = Math.max(Math.min(popper[len] - arrowElementSize, sideValue), 0);
        data.arrowElement = arrowElement;
        data.offsets.arrow = (_data$offsets$arrow = {}, defineProperty(_data$offsets$arrow, side, Math.round(sideValue)), defineProperty(_data$offsets$arrow, altSide, ''), _data$offsets$arrow);
        return data;
    }

    function getOppositeVariation(variation) {
        if (variation === 'end') { return 'start'; } else if (variation === 'start') { return 'end'; }
        return variation;
    }
    var placements = ['auto-start', 'auto', 'auto-end', 'top-start', 'top', 'top-end', 'right-start', 'right', 'right-end', 'bottom-end', 'bottom', 'bottom-start', 'left-end', 'left', 'left-start'];
    var validPlacements = placements.slice(3);

    function clockwise(placement) { var counter = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : false; var index = validPlacements.indexOf(placement); var arr = validPlacements.slice(index + 1).concat(validPlacements.slice(0, index)); return counter ? arr.reverse() : arr; }
    var BEHAVIORS = { FLIP: 'flip', CLOCKWISE: 'clockwise', COUNTERCLOCKWISE: 'counterclockwise' };

    function flip(data, options) {
        if (isModifierEnabled(data.instance.modifiers, 'inner')) { return data; }
        if (data.flipped && data.placement === data.originalPlacement) { return data; }
        var boundaries = getBoundaries(data.instance.popper, data.instance.reference, options.padding, options.boundariesElement, data.positionFixed);
        var placement = data.placement.split('-')[0];
        var placementOpposite = getOppositePlacement(placement);
        var variation = data.placement.split('-')[1] || '';
        var flipOrder = [];
        switch (options.behavior) {
            case BEHAVIORS.FLIP:
                flipOrder = [placement, placementOpposite];
                break;
            case BEHAVIORS.CLOCKWISE:
                flipOrder = clockwise(placement);
                break;
            case BEHAVIORS.COUNTERCLOCKWISE:
                flipOrder = clockwise(placement, true);
                break;
            default:
                flipOrder = options.behavior;
        }
        flipOrder.forEach(function(step, index) {
            if (placement !== step || flipOrder.length === index + 1) { return data; }
            placement = data.placement.split('-')[0];
            placementOpposite = getOppositePlacement(placement);
            var popperOffsets = data.offsets.popper;
            var refOffsets = data.offsets.reference;
            var floor = Math.floor;
            var overlapsRef = placement === 'left' && floor(popperOffsets.right) > floor(refOffsets.left) || placement === 'right' && floor(popperOffsets.left) < floor(refOffsets.right) || placement === 'top' && floor(popperOffsets.bottom) > floor(refOffsets.top) || placement === 'bottom' && floor(popperOffsets.top) < floor(refOffsets.bottom);
            var overflowsLeft = floor(popperOffsets.left) < floor(boundaries.left);
            var overflowsRight = floor(popperOffsets.right) > floor(boundaries.right);
            var overflowsTop = floor(popperOffsets.top) < floor(boundaries.top);
            var overflowsBottom = floor(popperOffsets.bottom) > floor(boundaries.bottom);
            var overflowsBoundaries = placement === 'left' && overflowsLeft || placement === 'right' && overflowsRight || placement === 'top' && overflowsTop || placement === 'bottom' && overflowsBottom;
            var isVertical = ['top', 'bottom'].indexOf(placement) !== -1;
            var flippedVariation = !!options.flipVariations && (isVertical && variation === 'start' && overflowsLeft || isVertical && variation === 'end' && overflowsRight || !isVertical && variation === 'start' && overflowsTop || !isVertical && variation === 'end' && overflowsBottom);
            if (overlapsRef || overflowsBoundaries || flippedVariation) {
                data.flipped = true;
                if (overlapsRef || overflowsBoundaries) { placement = flipOrder[index + 1]; }
                if (flippedVariation) { variation = getOppositeVariation(variation); }
                data.placement = placement + (variation ? '-' + variation : '');
                data.offsets.popper = _extends({}, data.offsets.popper, getPopperOffsets(data.instance.popper, data.offsets.reference, data.placement));
                data = runModifiers(data.instance.modifiers, data, 'flip');
            }
        });
        return data;
    }

    function keepTogether(data) {
        var _data$offsets = data.offsets,
            popper = _data$offsets.popper,
            reference = _data$offsets.reference;
        var placement = data.placement.split('-')[0];
        var floor = Math.floor;
        var isVertical = ['top', 'bottom'].indexOf(placement) !== -1;
        var side = isVertical ? 'right' : 'bottom';
        var opSide = isVertical ? 'left' : 'top';
        var measurement = isVertical ? 'width' : 'height';
        if (popper[side] < floor(reference[opSide])) { data.offsets.popper[opSide] = floor(reference[opSide]) - popper[measurement]; }
        if (popper[opSide] > floor(reference[side])) { data.offsets.popper[opSide] = floor(reference[side]); }
        return data;
    }

    function toValue(str, measurement, popperOffsets, referenceOffsets) {
        var split = str.match(/((?:\-|\+)?\d*\.?\d*)(.*)/);
        var value = +split[1];
        var unit = split[2];
        if (!value) { return str; }
        if (unit.indexOf('%') === 0) {
            var element = void 0;
            switch (unit) {
                case '%p':
                    element = popperOffsets;
                    break;
                case '%':
                case '%r':
                default:
                    element = referenceOffsets;
            }
            var rect = getClientRect(element);
            return rect[measurement] / 100 * value;
        } else if (unit === 'vh' || unit === 'vw') {
            var size = void 0;
            if (unit === 'vh') { size = Math.max(document.documentElement.clientHeight, window.innerHeight || 0); } else { size = Math.max(document.documentElement.clientWidth, window.innerWidth || 0); }
            return size / 100 * value;
        } else { return value; }
    }

    function parseOffset(offset, popperOffsets, referenceOffsets, basePlacement) {
        var offsets = [0, 0];
        var useHeight = ['right', 'left'].indexOf(basePlacement) !== -1;
        var fragments = offset.split(/(\+|\-)/).map(function(frag) { return frag.trim(); });
        var divider = fragments.indexOf(find(fragments, function(frag) { return frag.search(/,|\s/) !== -1; }));
        if (fragments[divider] && fragments[divider].indexOf(',') === -1) { console.warn('Offsets separated by white space(s) are deprecated, use a comma (,) instead.'); }
        var splitRegex = /\s*,\s*|\s+/;
        var ops = divider !== -1 ? [fragments.slice(0, divider).concat([fragments[divider].split(splitRegex)[0]]), [fragments[divider].split(splitRegex)[1]].concat(fragments.slice(divider + 1))] : [fragments];
        ops = ops.map(function(op, index) {
            var measurement = (index === 1 ? !useHeight : useHeight) ? 'height' : 'width';
            var mergeWithPrevious = false;
            return op.reduce(function(a, b) {
                if (a[a.length - 1] === '' && ['+', '-'].indexOf(b) !== -1) {
                    a[a.length - 1] = b;
                    mergeWithPrevious = true;
                    return a;
                } else if (mergeWithPrevious) {
                    a[a.length - 1] += b;
                    mergeWithPrevious = false;
                    return a;
                } else { return a.concat(b); }
            }, []).map(function(str) { return toValue(str, measurement, popperOffsets, referenceOffsets); });
        });
        ops.forEach(function(op, index) { op.forEach(function(frag, index2) { if (isNumeric(frag)) { offsets[index] += frag * (op[index2 - 1] === '-' ? -1 : 1); } }); });
        return offsets;
    }

    function offset(data, _ref) {
        var offset = _ref.offset;
        var placement = data.placement,
            _data$offsets = data.offsets,
            popper = _data$offsets.popper,
            reference = _data$offsets.reference;
        var basePlacement = placement.split('-')[0];
        var offsets = void 0;
        if (isNumeric(+offset)) { offsets = [+offset, 0]; } else { offsets = parseOffset(offset, popper, reference, basePlacement); }
        if (basePlacement === 'left') {
            popper.top += offsets[0];
            popper.left -= offsets[1];
        } else if (basePlacement === 'right') {
            popper.top += offsets[0];
            popper.left += offsets[1];
        } else if (basePlacement === 'top') {
            popper.left += offsets[0];
            popper.top -= offsets[1];
        } else if (basePlacement === 'bottom') {
            popper.left += offsets[0];
            popper.top += offsets[1];
        }
        data.popper = popper;
        return data;
    }

    function preventOverflow(data, options) {
        var boundariesElement = options.boundariesElement || getOffsetParent(data.instance.popper);
        if (data.instance.reference === boundariesElement) { boundariesElement = getOffsetParent(boundariesElement); }
        var transformProp = getSupportedPropertyName('transform');
        var popperStyles = data.instance.popper.style;
        var top = popperStyles.top,
            left = popperStyles.left,
            transform = popperStyles[transformProp];
        popperStyles.top = '';
        popperStyles.left = '';
        popperStyles[transformProp] = '';
        var boundaries = getBoundaries(data.instance.popper, data.instance.reference, options.padding, boundariesElement, data.positionFixed);
        popperStyles.top = top;
        popperStyles.left = left;
        popperStyles[transformProp] = transform;
        options.boundaries = boundaries;
        var order = options.priority;
        var popper = data.offsets.popper;
        var check = {
            primary: function primary(placement) {
                var value = popper[placement];
                if (popper[placement] < boundaries[placement] && !options.escapeWithReference) { value = Math.max(popper[placement], boundaries[placement]); }
                return defineProperty({}, placement, value);
            },
            secondary: function secondary(placement) {
                var mainSide = placement === 'right' ? 'left' : 'top';
                var value = popper[mainSide];
                if (popper[placement] > boundaries[placement] && !options.escapeWithReference) { value = Math.min(popper[mainSide], boundaries[placement] - (placement === 'right' ? popper.width : popper.height)); }
                return defineProperty({}, mainSide, value);
            }
        };
        order.forEach(function(placement) {
            var side = ['left', 'top'].indexOf(placement) !== -1 ? 'primary' : 'secondary';
            popper = _extends({}, popper, check[side](placement));
        });
        data.offsets.popper = popper;
        return data;
    }

    function shift(data) {
        var placement = data.placement;
        var basePlacement = placement.split('-')[0];
        var shiftvariation = placement.split('-')[1];
        if (shiftvariation) {
            var _data$offsets = data.offsets,
                reference = _data$offsets.reference,
                popper = _data$offsets.popper;
            var isVertical = ['bottom', 'top'].indexOf(basePlacement) !== -1;
            var side = isVertical ? 'left' : 'top';
            var measurement = isVertical ? 'width' : 'height';
            var shiftOffsets = { start: defineProperty({}, side, reference[side]), end: defineProperty({}, side, reference[side] + reference[measurement] - popper[measurement]) };
            data.offsets.popper = _extends({}, popper, shiftOffsets[shiftvariation]);
        }
        return data;
    }

    function hide(data) {
        if (!isModifierRequired(data.instance.modifiers, 'hide', 'preventOverflow')) { return data; }
        var refRect = data.offsets.reference;
        var bound = find(data.instance.modifiers, function(modifier) { return modifier.name === 'preventOverflow'; }).boundaries;
        if (refRect.bottom < bound.top || refRect.left > bound.right || refRect.top > bound.bottom || refRect.right < bound.left) {
            if (data.hide === true) { return data; }
            data.hide = true;
            data.attributes['x-out-of-boundaries'] = '';
        } else {
            if (data.hide === false) { return data; }
            data.hide = false;
            data.attributes['x-out-of-boundaries'] = false;
        }
        return data;
    }

    function inner(data) {
        var placement = data.placement;
        var basePlacement = placement.split('-')[0];
        var _data$offsets = data.offsets,
            popper = _data$offsets.popper,
            reference = _data$offsets.reference;
        var isHoriz = ['left', 'right'].indexOf(basePlacement) !== -1;
        var subtractLength = ['top', 'left'].indexOf(basePlacement) === -1;
        popper[isHoriz ? 'left' : 'top'] = reference[basePlacement] - (subtractLength ? popper[isHoriz ? 'width' : 'height'] : 0);
        data.placement = getOppositePlacement(placement);
        data.offsets.popper = getClientRect(popper);
        return data;
    }
    var modifiers = { shift: { order: 100, enabled: true, fn: shift }, offset: { order: 200, enabled: true, fn: offset, offset: 0 }, preventOverflow: { order: 300, enabled: true, fn: preventOverflow, priority: ['left', 'right', 'top', 'bottom'], padding: 5, boundariesElement: 'scrollParent' }, keepTogether: { order: 400, enabled: true, fn: keepTogether }, arrow: { order: 500, enabled: true, fn: arrow, element: '[x-arrow]' }, flip: { order: 600, enabled: true, fn: flip, behavior: 'flip', padding: 5, boundariesElement: 'viewport' }, inner: { order: 700, enabled: false, fn: inner }, hide: { order: 800, enabled: true, fn: hide }, computeStyle: { order: 850, enabled: true, fn: computeStyle, gpuAcceleration: true, x: 'bottom', y: 'right' }, applyStyle: { order: 900, enabled: true, fn: applyStyle, onLoad: applyStyleOnLoad, gpuAcceleration: undefined } };
    var Defaults = { placement: 'bottom', positionFixed: false, eventsEnabled: true, removeOnDestroy: false, onCreate: function onCreate() {}, onUpdate: function onUpdate() {}, modifiers: modifiers };
    var Popper = function() {
        function Popper(reference, popper) {
            var _this = this;
            var options = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : {};
            classCallCheck(this, Popper);
            this.scheduleUpdate = function() { return requestAnimationFrame(_this.update); };
            this.update = debounce(this.update.bind(this));
            this.options = _extends({}, Popper.Defaults, options);
            this.state = { isDestroyed: false, isCreated: false, scrollParents: [] };
            this.reference = reference && reference.jquery ? reference[0] : reference;
            this.popper = popper && popper.jquery ? popper[0] : popper;
            this.options.modifiers = {};
            Object.keys(_extends({}, Popper.Defaults.modifiers, options.modifiers)).forEach(function(name) { _this.options.modifiers[name] = _extends({}, Popper.Defaults.modifiers[name] || {}, options.modifiers ? options.modifiers[name] : {}); });
            this.modifiers = Object.keys(this.options.modifiers).map(function(name) { return _extends({ name: name }, _this.options.modifiers[name]); }).sort(function(a, b) { return a.order - b.order; });
            this.modifiers.forEach(function(modifierOptions) { if (modifierOptions.enabled && isFunction(modifierOptions.onLoad)) { modifierOptions.onLoad(_this.reference, _this.popper, _this.options, modifierOptions, _this.state); } });
            this.update();
            var eventsEnabled = this.options.eventsEnabled;
            if (eventsEnabled) { this.enableEventListeners(); }
            this.state.eventsEnabled = eventsEnabled;
        }
        createClass(Popper, [{ key: 'update', value: function update$$1() { return update.call(this); } }, { key: 'destroy', value: function destroy$$1() { return destroy.call(this); } }, { key: 'enableEventListeners', value: function enableEventListeners$$1() { return enableEventListeners.call(this); } }, { key: 'disableEventListeners', value: function disableEventListeners$$1() { return disableEventListeners.call(this); } }]);
        return Popper;
    }();
    Popper.Utils = (typeof window !== 'undefined' ? window : global).PopperUtils;
    Popper.placements = placements;
    Popper.Defaults = Defaults;
    return Popper;
})));
/*!
 * Bootstrap v4.1.3 (https://getbootstrap.com/)
 * Copyright 2011-2018 The Bootstrap Authors (https://github.com/twbs/bootstrap/graphs/contributors)
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 */
(function(global, factory) { typeof exports === 'object' && typeof module !== 'undefined' ? factory(exports, require('jquery'), require('popper.js')) : typeof define === 'function' && define.amd ? define(['exports', 'jquery', 'popper.js'], factory) : (factory((global.bootstrap = {}), global.jQuery, global.Popper)); }(this, (function(exports, $, Popper) {
    'use strict';
    $ = $ && $.hasOwnProperty('default') ? $['default'] : $;
    Popper = Popper && Popper.hasOwnProperty('default') ? Popper['default'] : Popper;

    function _defineProperties(target, props) {
        for (var i = 0; i < props.length; i++) {
            var descriptor = props[i];
            descriptor.enumerable = descriptor.enumerable || false;
            descriptor.configurable = true;
            if ("value" in descriptor) descriptor.writable = true;
            Object.defineProperty(target, descriptor.key, descriptor);
        }
    }

    function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

    function _defineProperty(obj, key, value) {
        if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; }
        return obj;
    }

    function _objectSpread(target) {
        for (var i = 1; i < arguments.length; i++) {
            var source = arguments[i] != null ? arguments[i] : {};
            var ownKeys = Object.keys(source);
            if (typeof Object.getOwnPropertySymbols === 'function') { ownKeys = ownKeys.concat(Object.getOwnPropertySymbols(source).filter(function(sym) { return Object.getOwnPropertyDescriptor(source, sym).enumerable; })); }
            ownKeys.forEach(function(key) { _defineProperty(target, key, source[key]); });
        }
        return target;
    }

    function _inheritsLoose(subClass, superClass) {
        subClass.prototype = Object.create(superClass.prototype);
        subClass.prototype.constructor = subClass;
        subClass.__proto__ = superClass;
    }
    var Util = function($$$1) {
        var TRANSITION_END = 'transitionend';
        var MAX_UID = 1000000;
        var MILLISECONDS_MULTIPLIER = 1000;

        function toType(obj) { return {}.toString.call(obj).match(/\s([a-z]+)/i)[1].toLowerCase(); }

        function getSpecialTransitionEndEvent() {
            return {
                bindType: TRANSITION_END,
                delegateType: TRANSITION_END,
                handle: function handle(event) {
                    if ($$$1(event.target).is(this)) { return event.handleObj.handler.apply(this, arguments); }
                    return undefined;
                }
            };
        }

        function transitionEndEmulator(duration) {
            var _this = this;
            var called = false;
            $$$1(this).one(Util.TRANSITION_END, function() { called = true; });
            setTimeout(function() { if (!called) { Util.triggerTransitionEnd(_this); } }, duration);
            return this;
        }

        function setTransitionEndSupport() {
            $$$1.fn.emulateTransitionEnd = transitionEndEmulator;
            $$$1.event.special[Util.TRANSITION_END] = getSpecialTransitionEndEvent();
        }
        var Util = {
            TRANSITION_END: 'bsTransitionEnd',
            getUID: function getUID(prefix) { do { prefix += ~~(Math.random() * MAX_UID); } while (document.getElementById(prefix)); return prefix; },
            getSelectorFromElement: function getSelectorFromElement(element) {
                var selector = element.getAttribute('data-target');
                if (!selector || selector === '#') { selector = element.getAttribute('href') || ''; }
                try { return document.querySelector(selector) ? selector : null; } catch (err) { return null; }
            },
            getTransitionDurationFromElement: function getTransitionDurationFromElement(element) {
                if (!element) { return 0; }
                var transitionDuration = $$$1(element).css('transition-duration');
                var floatTransitionDuration = parseFloat(transitionDuration);
                if (!floatTransitionDuration) { return 0; }
                transitionDuration = transitionDuration.split(',')[0];
                return parseFloat(transitionDuration) * MILLISECONDS_MULTIPLIER;
            },
            reflow: function reflow(element) { return element.offsetHeight; },
            triggerTransitionEnd: function triggerTransitionEnd(element) { $$$1(element).trigger(TRANSITION_END); },
            supportsTransitionEnd: function supportsTransitionEnd() { return Boolean(TRANSITION_END); },
            isElement: function isElement(obj) { return (obj[0] || obj).nodeType; },
            typeCheckConfig: function typeCheckConfig(componentName, config, configTypes) { for (var property in configTypes) { if (Object.prototype.hasOwnProperty.call(configTypes, property)) { var expectedTypes = configTypes[property]; var value = config[property]; var valueType = value && Util.isElement(value) ? 'element' : toType(value); if (!new RegExp(expectedTypes).test(valueType)) { throw new Error(componentName.toUpperCase() + ": " + ("Option \"" + property + "\" provided type \"" + valueType + "\" ") + ("but expected type \"" + expectedTypes + "\".")); } } } }
        };
        setTransitionEndSupport();
        return Util;
    }($);
    var Alert = function($$$1) {
        var NAME = 'alert';
        var VERSION = '4.1.3';
        var DATA_KEY = 'bs.alert';
        var EVENT_KEY = "." + DATA_KEY;
        var DATA_API_KEY = '.data-api';
        var JQUERY_NO_CONFLICT = $$$1.fn[NAME];
        var Selector = { DISMISS: '[data-dismiss="alert"]' };
        var Event = { CLOSE: "close" + EVENT_KEY, CLOSED: "closed" + EVENT_KEY, CLICK_DATA_API: "click" + EVENT_KEY + DATA_API_KEY };
        var ClassName = { ALERT: 'alert', FADE: 'fade', SHOW: 'show' };
        var Alert = function() {
            function Alert(element) { this._element = element; }
            var _proto = Alert.prototype;
            _proto.close = function close(element) {
                var rootElement = this._element;
                if (element) { rootElement = this._getRootElement(element); }
                var customEvent = this._triggerCloseEvent(rootElement);
                if (customEvent.isDefaultPrevented()) { return; }
                this._removeElement(rootElement);
            };
            _proto.dispose = function dispose() {
                $$$1.removeData(this._element, DATA_KEY);
                this._element = null;
            };
            _proto._getRootElement = function _getRootElement(element) {
                var selector = Util.getSelectorFromElement(element);
                var parent = false;
                if (selector) { parent = document.querySelector(selector); }
                if (!parent) { parent = $$$1(element).closest("." + ClassName.ALERT)[0]; }
                return parent;
            };
            _proto._triggerCloseEvent = function _triggerCloseEvent(element) {
                var closeEvent = $$$1.Event(Event.CLOSE);
                $$$1(element).trigger(closeEvent);
                return closeEvent;
            };
            _proto._removeElement = function _removeElement(element) {
                var _this = this;
                $$$1(element).removeClass(ClassName.SHOW);
                if (!$$$1(element).hasClass(ClassName.FADE)) { this._destroyElement(element); return; }
                var transitionDuration = Util.getTransitionDurationFromElement(element);
                $$$1(element).one(Util.TRANSITION_END, function(event) { return _this._destroyElement(element, event); }).emulateTransitionEnd(transitionDuration);
            };
            _proto._destroyElement = function _destroyElement(element) { $$$1(element).detach().trigger(Event.CLOSED).remove(); };
            Alert._jQueryInterface = function _jQueryInterface(config) {
                return this.each(function() {
                    var $element = $$$1(this);
                    var data = $element.data(DATA_KEY);
                    if (!data) {
                        data = new Alert(this);
                        $element.data(DATA_KEY, data);
                    }
                    if (config === 'close') { data[config](this); }
                });
            };
            Alert._handleDismiss = function _handleDismiss(alertInstance) {
                return function(event) {
                    if (event) { event.preventDefault(); }
                    alertInstance.close(this);
                };
            };
            _createClass(Alert, null, [{ key: "VERSION", get: function get() { return VERSION; } }]);
            return Alert;
        }();
        $$$1(document).on(Event.CLICK_DATA_API, Selector.DISMISS, Alert._handleDismiss(new Alert()));
        $$$1.fn[NAME] = Alert._jQueryInterface;
        $$$1.fn[NAME].Constructor = Alert;
        $$$1.fn[NAME].noConflict = function() { $$$1.fn[NAME] = JQUERY_NO_CONFLICT; return Alert._jQueryInterface; };
        return Alert;
    }($);
    var Button = function($$$1) {
        var NAME = 'button';
        var VERSION = '4.1.3';
        var DATA_KEY = 'bs.button';
        var EVENT_KEY = "." + DATA_KEY;
        var DATA_API_KEY = '.data-api';
        var JQUERY_NO_CONFLICT = $$$1.fn[NAME];
        var ClassName = { ACTIVE: 'active', BUTTON: 'btn', FOCUS: 'focus' };
        var Selector = { DATA_TOGGLE_CARROT: '[data-toggle^="button"]', DATA_TOGGLE: '[data-toggle="buttons"]', INPUT: 'input', ACTIVE: '.active', BUTTON: '.btn' };
        var Event = { CLICK_DATA_API: "click" + EVENT_KEY + DATA_API_KEY, FOCUS_BLUR_DATA_API: "focus" + EVENT_KEY + DATA_API_KEY + " " + ("blur" + EVENT_KEY + DATA_API_KEY) };
        var Button = function() {
            function Button(element) { this._element = element; }
            var _proto = Button.prototype;
            _proto.toggle = function toggle() {
                var triggerChangeEvent = true;
                var addAriaPressed = true;
                var rootElement = $$$1(this._element).closest(Selector.DATA_TOGGLE)[0];
                if (rootElement) {
                    var input = this._element.querySelector(Selector.INPUT);
                    if (input) {
                        if (input.type === 'radio') { if (input.checked && this._element.classList.contains(ClassName.ACTIVE)) { triggerChangeEvent = false; } else { var activeElement = rootElement.querySelector(Selector.ACTIVE); if (activeElement) { $$$1(activeElement).removeClass(ClassName.ACTIVE); } } }
                        if (triggerChangeEvent) {
                            if (input.hasAttribute('disabled') || rootElement.hasAttribute('disabled') || input.classList.contains('disabled') || rootElement.classList.contains('disabled')) { return; }
                            input.checked = !this._element.classList.contains(ClassName.ACTIVE);
                            $$$1(input).trigger('change');
                        }
                        input.focus();
                        addAriaPressed = false;
                    }
                }
                if (addAriaPressed) { this._element.setAttribute('aria-pressed', !this._element.classList.contains(ClassName.ACTIVE)); }
                if (triggerChangeEvent) { $$$1(this._element).toggleClass(ClassName.ACTIVE); }
            };
            _proto.dispose = function dispose() {
                $$$1.removeData(this._element, DATA_KEY);
                this._element = null;
            };
            Button._jQueryInterface = function _jQueryInterface(config) {
                return this.each(function() {
                    var data = $$$1(this).data(DATA_KEY);
                    if (!data) {
                        data = new Button(this);
                        $$$1(this).data(DATA_KEY, data);
                    }
                    if (config === 'toggle') { data[config](); }
                });
            };
            _createClass(Button, null, [{ key: "VERSION", get: function get() { return VERSION; } }]);
            return Button;
        }();
        $$$1(document).on(Event.CLICK_DATA_API, Selector.DATA_TOGGLE_CARROT, function(event) {
            event.preventDefault();
            var button = event.target;
            if (!$$$1(button).hasClass(ClassName.BUTTON)) { button = $$$1(button).closest(Selector.BUTTON); }
            Button._jQueryInterface.call($$$1(button), 'toggle');
        }).on(Event.FOCUS_BLUR_DATA_API, Selector.DATA_TOGGLE_CARROT, function(event) {
            var button = $$$1(event.target).closest(Selector.BUTTON)[0];
            $$$1(button).toggleClass(ClassName.FOCUS, /^focus(in)?$/.test(event.type));
        });
        $$$1.fn[NAME] = Button._jQueryInterface;
        $$$1.fn[NAME].Constructor = Button;
        $$$1.fn[NAME].noConflict = function() { $$$1.fn[NAME] = JQUERY_NO_CONFLICT; return Button._jQueryInterface; };
        return Button;
    }($);
    var Carousel = function($$$1) {
        var NAME = 'carousel';
        var VERSION = '4.1.3';
        var DATA_KEY = 'bs.carousel';
        var EVENT_KEY = "." + DATA_KEY;
        var DATA_API_KEY = '.data-api';
        var JQUERY_NO_CONFLICT = $$$1.fn[NAME];
        var ARROW_LEFT_KEYCODE = 37;
        var ARROW_RIGHT_KEYCODE = 39;
        var TOUCHEVENT_COMPAT_WAIT = 500;
        var Default = { interval: 5000, keyboard: true, slide: false, pause: 'hover', wrap: true };
        var DefaultType = { interval: '(number|boolean)', keyboard: 'boolean', slide: '(boolean|string)', pause: '(string|boolean)', wrap: 'boolean' };
        var Direction = { NEXT: 'next', PREV: 'prev', LEFT: 'left', RIGHT: 'right' };
        var Event = { SLIDE: "slide" + EVENT_KEY, SLID: "slid" + EVENT_KEY, KEYDOWN: "keydown" + EVENT_KEY, MOUSEENTER: "mouseenter" + EVENT_KEY, MOUSELEAVE: "mouseleave" + EVENT_KEY, TOUCHEND: "touchend" + EVENT_KEY, LOAD_DATA_API: "load" + EVENT_KEY + DATA_API_KEY, CLICK_DATA_API: "click" + EVENT_KEY + DATA_API_KEY };
        var ClassName = { CAROUSEL: 'carousel', ACTIVE: 'active', SLIDE: 'slide', RIGHT: 'carousel-item-right', LEFT: 'carousel-item-left', NEXT: 'carousel-item-next', PREV: 'carousel-item-prev', ITEM: 'carousel-item' };
        var Selector = { ACTIVE: '.active', ACTIVE_ITEM: '.active.carousel-item', ITEM: '.carousel-item', NEXT_PREV: '.carousel-item-next, .carousel-item-prev', INDICATORS: '.carousel-indicators', DATA_SLIDE: '[data-slide], [data-slide-to]', DATA_RIDE: '[data-ride="carousel"]' };
        var Carousel = function() {
            function Carousel(element, config) {
                this._items = null;
                this._interval = null;
                this._activeElement = null;
                this._isPaused = false;
                this._isSliding = false;
                this.touchTimeout = null;
                this._config = this._getConfig(config);
                this._element = $$$1(element)[0];
                this._indicatorsElement = this._element.querySelector(Selector.INDICATORS);
                this._addEventListeners();
            }
            var _proto = Carousel.prototype;
            _proto.next = function next() { if (!this._isSliding) { this._slide(Direction.NEXT); } };
            _proto.nextWhenVisible = function nextWhenVisible() { if (!document.hidden && $$$1(this._element).is(':visible') && $$$1(this._element).css('visibility') !== 'hidden') { this.next(); } };
            _proto.prev = function prev() { if (!this._isSliding) { this._slide(Direction.PREV); } };
            _proto.pause = function pause(event) {
                if (!event) { this._isPaused = true; }
                if (this._element.querySelector(Selector.NEXT_PREV)) {
                    Util.triggerTransitionEnd(this._element);
                    this.cycle(true);
                }
                clearInterval(this._interval);
                this._interval = null;
            };
            _proto.cycle = function cycle(event) {
                if (!event) { this._isPaused = false; }
                if (this._interval) {
                    clearInterval(this._interval);
                    this._interval = null;
                }
                if (this._config.interval && !this._isPaused) { this._interval = setInterval((document.visibilityState ? this.nextWhenVisible : this.next).bind(this), this._config.interval); }
            };
            _proto.to = function to(index) {
                var _this = this;
                this._activeElement = this._element.querySelector(Selector.ACTIVE_ITEM);
                var activeIndex = this._getItemIndex(this._activeElement);
                if (index > this._items.length - 1 || index < 0) { return; }
                if (this._isSliding) { $$$1(this._element).one(Event.SLID, function() { return _this.to(index); }); return; }
                if (activeIndex === index) {
                    this.pause();
                    this.cycle();
                    return;
                }
                var direction = index > activeIndex ? Direction.NEXT : Direction.PREV;
                this._slide(direction, this._items[index]);
            };
            _proto.dispose = function dispose() {
                $$$1(this._element).off(EVENT_KEY);
                $$$1.removeData(this._element, DATA_KEY);
                this._items = null;
                this._config = null;
                this._element = null;
                this._interval = null;
                this._isPaused = null;
                this._isSliding = null;
                this._activeElement = null;
                this._indicatorsElement = null;
            };
            _proto._getConfig = function _getConfig(config) {
                config = _objectSpread({}, Default, config);
                Util.typeCheckConfig(NAME, config, DefaultType);
                return config;
            };
            _proto._addEventListeners = function _addEventListeners() {
                var _this2 = this;
                if (this._config.keyboard) { $$$1(this._element).on(Event.KEYDOWN, function(event) { return _this2._keydown(event); }); }
                if (this._config.pause === 'hover') {
                    $$$1(this._element).on(Event.MOUSEENTER, function(event) { return _this2.pause(event); }).on(Event.MOUSELEAVE, function(event) { return _this2.cycle(event); });
                    if ('ontouchstart' in document.documentElement) {
                        $$$1(this._element).on(Event.TOUCHEND, function() {
                            _this2.pause();
                            if (_this2.touchTimeout) { clearTimeout(_this2.touchTimeout); }
                            _this2.touchTimeout = setTimeout(function(event) { return _this2.cycle(event); }, TOUCHEVENT_COMPAT_WAIT + _this2._config.interval);
                        });
                    }
                }
            };
            _proto._keydown = function _keydown(event) {
                if (/input|textarea/i.test(event.target.tagName)) { return; }
                switch (event.which) {
                    case ARROW_LEFT_KEYCODE:
                        event.preventDefault();
                        this.prev();
                        break;
                    case ARROW_RIGHT_KEYCODE:
                        event.preventDefault();
                        this.next();
                        break;
                    default:
                }
            };
            _proto._getItemIndex = function _getItemIndex(element) { this._items = element && element.parentNode ? [].slice.call(element.parentNode.querySelectorAll(Selector.ITEM)) : []; return this._items.indexOf(element); };
            _proto._getItemByDirection = function _getItemByDirection(direction, activeElement) {
                var isNextDirection = direction === Direction.NEXT;
                var isPrevDirection = direction === Direction.PREV;
                var activeIndex = this._getItemIndex(activeElement);
                var lastItemIndex = this._items.length - 1;
                var isGoingToWrap = isPrevDirection && activeIndex === 0 || isNextDirection && activeIndex === lastItemIndex;
                if (isGoingToWrap && !this._config.wrap) { return activeElement; }
                var delta = direction === Direction.PREV ? -1 : 1;
                var itemIndex = (activeIndex + delta) % this._items.length;
                return itemIndex === -1 ? this._items[this._items.length - 1] : this._items[itemIndex];
            };
            _proto._triggerSlideEvent = function _triggerSlideEvent(relatedTarget, eventDirectionName) {
                var targetIndex = this._getItemIndex(relatedTarget);
                var fromIndex = this._getItemIndex(this._element.querySelector(Selector.ACTIVE_ITEM));
                var slideEvent = $$$1.Event(Event.SLIDE, { relatedTarget: relatedTarget, direction: eventDirectionName, from: fromIndex, to: targetIndex });
                $$$1(this._element).trigger(slideEvent);
                return slideEvent;
            };
            _proto._setActiveIndicatorElement = function _setActiveIndicatorElement(element) {
                if (this._indicatorsElement) {
                    var indicators = [].slice.call(this._indicatorsElement.querySelectorAll(Selector.ACTIVE));
                    $$$1(indicators).removeClass(ClassName.ACTIVE);
                    var nextIndicator = this._indicatorsElement.children[this._getItemIndex(element)];
                    if (nextIndicator) { $$$1(nextIndicator).addClass(ClassName.ACTIVE); }
                }
            };
            _proto._slide = function _slide(direction, element) {
                var _this3 = this;
                var activeElement = this._element.querySelector(Selector.ACTIVE_ITEM);
                var activeElementIndex = this._getItemIndex(activeElement);
                var nextElement = element || activeElement && this._getItemByDirection(direction, activeElement);
                var nextElementIndex = this._getItemIndex(nextElement);
                var isCycling = Boolean(this._interval);
                var directionalClassName;
                var orderClassName;
                var eventDirectionName;
                if (direction === Direction.NEXT) {
                    directionalClassName = ClassName.LEFT;
                    orderClassName = ClassName.NEXT;
                    eventDirectionName = Direction.LEFT;
                } else {
                    directionalClassName = ClassName.RIGHT;
                    orderClassName = ClassName.PREV;
                    eventDirectionName = Direction.RIGHT;
                }
                if (nextElement && $$$1(nextElement).hasClass(ClassName.ACTIVE)) { this._isSliding = false; return; }
                var slideEvent = this._triggerSlideEvent(nextElement, eventDirectionName);
                if (slideEvent.isDefaultPrevented()) { return; }
                if (!activeElement || !nextElement) { return; }
                this._isSliding = true;
                if (isCycling) { this.pause(); }
                this._setActiveIndicatorElement(nextElement);
                var slidEvent = $$$1.Event(Event.SLID, { relatedTarget: nextElement, direction: eventDirectionName, from: activeElementIndex, to: nextElementIndex });
                if ($$$1(this._element).hasClass(ClassName.SLIDE)) {
                    $$$1(nextElement).addClass(orderClassName);
                    Util.reflow(nextElement);
                    $$$1(activeElement).addClass(directionalClassName);
                    $$$1(nextElement).addClass(directionalClassName);
                    var transitionDuration = Util.getTransitionDurationFromElement(activeElement);
                    $$$1(activeElement).one(Util.TRANSITION_END, function() {
                        $$$1(nextElement).removeClass(directionalClassName + " " + orderClassName).addClass(ClassName.ACTIVE);
                        $$$1(activeElement).removeClass(ClassName.ACTIVE + " " + orderClassName + " " + directionalClassName);
                        _this3._isSliding = false;
                        setTimeout(function() { return $$$1(_this3._element).trigger(slidEvent); }, 0);
                    }).emulateTransitionEnd(transitionDuration);
                } else {
                    $$$1(activeElement).removeClass(ClassName.ACTIVE);
                    $$$1(nextElement).addClass(ClassName.ACTIVE);
                    this._isSliding = false;
                    $$$1(this._element).trigger(slidEvent);
                }
                if (isCycling) { this.cycle(); }
            };
            Carousel._jQueryInterface = function _jQueryInterface(config) {
                return this.each(function() {
                    var data = $$$1(this).data(DATA_KEY);
                    var _config = _objectSpread({}, Default, $$$1(this).data());
                    if (typeof config === 'object') { _config = _objectSpread({}, _config, config); }
                    var action = typeof config === 'string' ? config : _config.slide;
                    if (!data) {
                        data = new Carousel(this, _config);
                        $$$1(this).data(DATA_KEY, data);
                    }
                    if (typeof config === 'number') { data.to(config); } else if (typeof action === 'string') {
                        if (typeof data[action] === 'undefined') { throw new TypeError("No method named \"" + action + "\""); }
                        data[action]();
                    } else if (_config.interval) {
                        data.pause();
                        data.cycle();
                    }
                });
            };
            Carousel._dataApiClickHandler = function _dataApiClickHandler(event) {
                var selector = Util.getSelectorFromElement(this);
                if (!selector) { return; }
                var target = $$$1(selector)[0];
                if (!target || !$$$1(target).hasClass(ClassName.CAROUSEL)) { return; }
                var config = _objectSpread({}, $$$1(target).data(), $$$1(this).data());
                var slideIndex = this.getAttribute('data-slide-to');
                if (slideIndex) { config.interval = false; }
                Carousel._jQueryInterface.call($$$1(target), config);
                if (slideIndex) { $$$1(target).data(DATA_KEY).to(slideIndex); }
                event.preventDefault();
            };
            _createClass(Carousel, null, [{ key: "VERSION", get: function get() { return VERSION; } }, { key: "Default", get: function get() { return Default; } }]);
            return Carousel;
        }();
        $$$1(document).on(Event.CLICK_DATA_API, Selector.DATA_SLIDE, Carousel._dataApiClickHandler);
        $$$1(window).on(Event.LOAD_DATA_API, function() {
            var carousels = [].slice.call(document.querySelectorAll(Selector.DATA_RIDE));
            for (var i = 0, len = carousels.length; i < len; i++) {
                var $carousel = $$$1(carousels[i]);
                Carousel._jQueryInterface.call($carousel, $carousel.data());
            }
        });
        $$$1.fn[NAME] = Carousel._jQueryInterface;
        $$$1.fn[NAME].Constructor = Carousel;
        $$$1.fn[NAME].noConflict = function() { $$$1.fn[NAME] = JQUERY_NO_CONFLICT; return Carousel._jQueryInterface; };
        return Carousel;
    }($);
    var Collapse = function($$$1) {
        var NAME = 'collapse';
        var VERSION = '4.1.3';
        var DATA_KEY = 'bs.collapse';
        var EVENT_KEY = "." + DATA_KEY;
        var DATA_API_KEY = '.data-api';
        var JQUERY_NO_CONFLICT = $$$1.fn[NAME];
        var Default = { toggle: true, parent: '' };
        var DefaultType = { toggle: 'boolean', parent: '(string|element)' };
        var Event = { SHOW: "show" + EVENT_KEY, SHOWN: "shown" + EVENT_KEY, HIDE: "hide" + EVENT_KEY, HIDDEN: "hidden" + EVENT_KEY, CLICK_DATA_API: "click" + EVENT_KEY + DATA_API_KEY };
        var ClassName = { SHOW: 'show', COLLAPSE: 'collapse', COLLAPSING: 'collapsing', COLLAPSED: 'collapsed' };
        var Dimension = { WIDTH: 'width', HEIGHT: 'height' };
        var Selector = { ACTIVES: '.show, .collapsing', DATA_TOGGLE: '[data-toggle="collapse"]' };
        var Collapse = function() {
            function Collapse(element, config) {
                this._isTransitioning = false;
                this._element = element;
                this._config = this._getConfig(config);
                this._triggerArray = $$$1.makeArray(document.querySelectorAll("[data-toggle=\"collapse\"][href=\"#" + element.id + "\"]," + ("[data-toggle=\"collapse\"][data-target=\"#" + element.id + "\"]")));
                var toggleList = [].slice.call(document.querySelectorAll(Selector.DATA_TOGGLE));
                for (var i = 0, len = toggleList.length; i < len; i++) {
                    var elem = toggleList[i];
                    var selector = Util.getSelectorFromElement(elem);
                    var filterElement = [].slice.call(document.querySelectorAll(selector)).filter(function(foundElem) { return foundElem === element; });
                    if (selector !== null && filterElement.length > 0) {
                        this._selector = selector;
                        this._triggerArray.push(elem);
                    }
                }
                this._parent = this._config.parent ? this._getParent() : null;
                if (!this._config.parent) { this._addAriaAndCollapsedClass(this._element, this._triggerArray); }
                if (this._config.toggle) { this.toggle(); }
            }
            var _proto = Collapse.prototype;
            _proto.toggle = function toggle() { if ($$$1(this._element).hasClass(ClassName.SHOW)) { this.hide(); } else { this.show(); } };
            _proto.show = function show() {
                var _this = this;
                if (this._isTransitioning || $$$1(this._element).hasClass(ClassName.SHOW)) { return; }
                var actives;
                var activesData;
                if (this._parent) { actives = [].slice.call(this._parent.querySelectorAll(Selector.ACTIVES)).filter(function(elem) { return elem.getAttribute('data-parent') === _this._config.parent; }); if (actives.length === 0) { actives = null; } }
                if (actives) { activesData = $$$1(actives).not(this._selector).data(DATA_KEY); if (activesData && activesData._isTransitioning) { return; } }
                var startEvent = $$$1.Event(Event.SHOW);
                $$$1(this._element).trigger(startEvent);
                if (startEvent.isDefaultPrevented()) { return; }
                if (actives) { Collapse._jQueryInterface.call($$$1(actives).not(this._selector), 'hide'); if (!activesData) { $$$1(actives).data(DATA_KEY, null); } }
                var dimension = this._getDimension();
                $$$1(this._element).removeClass(ClassName.COLLAPSE).addClass(ClassName.COLLAPSING);
                this._element.style[dimension] = 0;
                if (this._triggerArray.length) { $$$1(this._triggerArray).removeClass(ClassName.COLLAPSED).attr('aria-expanded', true); }
                this.setTransitioning(true);
                var complete = function complete() {
                    $$$1(_this._element).removeClass(ClassName.COLLAPSING).addClass(ClassName.COLLAPSE).addClass(ClassName.SHOW);
                    _this._element.style[dimension] = '';
                    _this.setTransitioning(false);
                    $$$1(_this._element).trigger(Event.SHOWN);
                };
                var capitalizedDimension = dimension[0].toUpperCase() + dimension.slice(1);
                var scrollSize = "scroll" + capitalizedDimension;
                var transitionDuration = Util.getTransitionDurationFromElement(this._element);
                $$$1(this._element).one(Util.TRANSITION_END, complete).emulateTransitionEnd(transitionDuration);
                this._element.style[dimension] = this._element[scrollSize] + "px";
            };
            _proto.hide = function hide() {
                var _this2 = this;
                if (this._isTransitioning || !$$$1(this._element).hasClass(ClassName.SHOW)) { return; }
                var startEvent = $$$1.Event(Event.HIDE);
                $$$1(this._element).trigger(startEvent);
                if (startEvent.isDefaultPrevented()) { return; }
                var dimension = this._getDimension();
                this._element.style[dimension] = this._element.getBoundingClientRect()[dimension] + "px";
                Util.reflow(this._element);
                $$$1(this._element).addClass(ClassName.COLLAPSING).removeClass(ClassName.COLLAPSE).removeClass(ClassName.SHOW);
                var triggerArrayLength = this._triggerArray.length;
                if (triggerArrayLength > 0) { for (var i = 0; i < triggerArrayLength; i++) { var trigger = this._triggerArray[i]; var selector = Util.getSelectorFromElement(trigger); if (selector !== null) { var $elem = $$$1([].slice.call(document.querySelectorAll(selector))); if (!$elem.hasClass(ClassName.SHOW)) { $$$1(trigger).addClass(ClassName.COLLAPSED).attr('aria-expanded', false); } } } }
                this.setTransitioning(true);
                var complete = function complete() {
                    _this2.setTransitioning(false);
                    $$$1(_this2._element).removeClass(ClassName.COLLAPSING).addClass(ClassName.COLLAPSE).trigger(Event.HIDDEN);
                };
                this._element.style[dimension] = '';
                var transitionDuration = Util.getTransitionDurationFromElement(this._element);
                $$$1(this._element).one(Util.TRANSITION_END, complete).emulateTransitionEnd(transitionDuration);
            };
            _proto.setTransitioning = function setTransitioning(isTransitioning) { this._isTransitioning = isTransitioning; };
            _proto.dispose = function dispose() {
                $$$1.removeData(this._element, DATA_KEY);
                this._config = null;
                this._parent = null;
                this._element = null;
                this._triggerArray = null;
                this._isTransitioning = null;
            };
            _proto._getConfig = function _getConfig(config) {
                config = _objectSpread({}, Default, config);
                config.toggle = Boolean(config.toggle);
                Util.typeCheckConfig(NAME, config, DefaultType);
                return config;
            };
            _proto._getDimension = function _getDimension() { var hasWidth = $$$1(this._element).hasClass(Dimension.WIDTH); return hasWidth ? Dimension.WIDTH : Dimension.HEIGHT; };
            _proto._getParent = function _getParent() {
                var _this3 = this;
                var parent = null;
                if (Util.isElement(this._config.parent)) { parent = this._config.parent; if (typeof this._config.parent.jquery !== 'undefined') { parent = this._config.parent[0]; } } else { parent = document.querySelector(this._config.parent); }
                var selector = "[data-toggle=\"collapse\"][data-parent=\"" + this._config.parent + "\"]";
                var children = [].slice.call(parent.querySelectorAll(selector));
                $$$1(children).each(function(i, element) { _this3._addAriaAndCollapsedClass(Collapse._getTargetFromElement(element), [element]); });
                return parent;
            };
            _proto._addAriaAndCollapsedClass = function _addAriaAndCollapsedClass(element, triggerArray) { if (element) { var isOpen = $$$1(element).hasClass(ClassName.SHOW); if (triggerArray.length) { $$$1(triggerArray).toggleClass(ClassName.COLLAPSED, !isOpen).attr('aria-expanded', isOpen); } } };
            Collapse._getTargetFromElement = function _getTargetFromElement(element) { var selector = Util.getSelectorFromElement(element); return selector ? document.querySelector(selector) : null; };
            Collapse._jQueryInterface = function _jQueryInterface(config) {
                return this.each(function() {
                    var $this = $$$1(this);
                    var data = $this.data(DATA_KEY);
                    var _config = _objectSpread({}, Default, $this.data(), typeof config === 'object' && config ? config : {});
                    if (!data && _config.toggle && /show|hide/.test(config)) { _config.toggle = false; }
                    if (!data) {
                        data = new Collapse(this, _config);
                        $this.data(DATA_KEY, data);
                    }
                    if (typeof config === 'string') {
                        if (typeof data[config] === 'undefined') { throw new TypeError("No method named \"" + config + "\""); }
                        data[config]();
                    }
                });
            };
            _createClass(Collapse, null, [{ key: "VERSION", get: function get() { return VERSION; } }, { key: "Default", get: function get() { return Default; } }]);
            return Collapse;
        }();
        $$$1(document).on(Event.CLICK_DATA_API, Selector.DATA_TOGGLE, function(event) {
            if (event.currentTarget.tagName === 'A') { event.preventDefault(); }
            var $trigger = $$$1(this);
            var selector = Util.getSelectorFromElement(this);
            var selectors = [].slice.call(document.querySelectorAll(selector));
            $$$1(selectors).each(function() {
                var $target = $$$1(this);
                var data = $target.data(DATA_KEY);
                var config = data ? 'toggle' : $trigger.data();
                Collapse._jQueryInterface.call($target, config);
            });
        });
        $$$1.fn[NAME] = Collapse._jQueryInterface;
        $$$1.fn[NAME].Constructor = Collapse;
        $$$1.fn[NAME].noConflict = function() { $$$1.fn[NAME] = JQUERY_NO_CONFLICT; return Collapse._jQueryInterface; };
        return Collapse;
    }($);
    var Dropdown = function($$$1) {
        var NAME = 'dropdown';
        var VERSION = '4.1.3';
        var DATA_KEY = 'bs.dropdown';
        var EVENT_KEY = "." + DATA_KEY;
        var DATA_API_KEY = '.data-api';
        var JQUERY_NO_CONFLICT = $$$1.fn[NAME];
        var ESCAPE_KEYCODE = 27;
        var SPACE_KEYCODE = 32;
        var TAB_KEYCODE = 9;
        var ARROW_UP_KEYCODE = 38;
        var ARROW_DOWN_KEYCODE = 40;
        var RIGHT_MOUSE_BUTTON_WHICH = 3;
        var REGEXP_KEYDOWN = new RegExp(ARROW_UP_KEYCODE + "|" + ARROW_DOWN_KEYCODE + "|" + ESCAPE_KEYCODE);
        var Event = { HIDE: "hide" + EVENT_KEY, HIDDEN: "hidden" + EVENT_KEY, SHOW: "show" + EVENT_KEY, SHOWN: "shown" + EVENT_KEY, CLICK: "click" + EVENT_KEY, CLICK_DATA_API: "click" + EVENT_KEY + DATA_API_KEY, KEYDOWN_DATA_API: "keydown" + EVENT_KEY + DATA_API_KEY, KEYUP_DATA_API: "keyup" + EVENT_KEY + DATA_API_KEY };
        var ClassName = { DISABLED: 'disabled', SHOW: 'show', DROPUP: 'dropup', DROPRIGHT: 'dropright', DROPLEFT: 'dropleft', MENURIGHT: 'dropdown-menu-right', MENULEFT: 'dropdown-menu-left', POSITION_STATIC: 'position-static' };
        var Selector = { DATA_TOGGLE: '[data-toggle="dropdown"]', FORM_CHILD: '.dropdown form', MENU: '.dropdown-menu', NAVBAR_NAV: '.navbar-nav', VISIBLE_ITEMS: '.dropdown-menu .dropdown-item:not(.disabled):not(:disabled)' };
        var AttachmentMap = { TOP: 'top-start', TOPEND: 'top-end', BOTTOM: 'bottom-start', BOTTOMEND: 'bottom-end', RIGHT: 'right-start', RIGHTEND: 'right-end', LEFT: 'left-start', LEFTEND: 'left-end' };
        var Default = { offset: 0, flip: true, boundary: 'scrollParent', reference: 'toggle', display: 'dynamic' };
        var DefaultType = { offset: '(number|string|function)', flip: 'boolean', boundary: '(string|element)', reference: '(string|element)', display: 'string' };
        var Dropdown = function() {
            function Dropdown(element, config) {
                this._element = element;
                this._popper = null;
                this._config = this._getConfig(config);
                this._menu = this._getMenuElement();
                this._inNavbar = this._detectNavbar();
                this._addEventListeners();
            }
            var _proto = Dropdown.prototype;
            _proto.toggle = function toggle() {
                if (this._element.disabled || $$$1(this._element).hasClass(ClassName.DISABLED)) { return; }
                var parent = Dropdown._getParentFromElement(this._element);
                var isActive = $$$1(this._menu).hasClass(ClassName.SHOW);
                Dropdown._clearMenus();
                if (isActive) { return; }
                var relatedTarget = { relatedTarget: this._element };
                var showEvent = $$$1.Event(Event.SHOW, relatedTarget);
                $$$1(parent).trigger(showEvent);
                if (showEvent.isDefaultPrevented()) { return; }
                if (!this._inNavbar) {
                    if (typeof Popper === 'undefined') { throw new TypeError('Bootstrap dropdown require Popper.js (https://popper.js.org)'); }
                    var referenceElement = this._element;
                    if (this._config.reference === 'parent') { referenceElement = parent; } else if (Util.isElement(this._config.reference)) { referenceElement = this._config.reference; if (typeof this._config.reference.jquery !== 'undefined') { referenceElement = this._config.reference[0]; } }
                    if (this._config.boundary !== 'scrollParent') { $$$1(parent).addClass(ClassName.POSITION_STATIC); }
                    this._popper = new Popper(referenceElement, this._menu, this._getPopperConfig());
                }
                if ('ontouchstart' in document.documentElement && $$$1(parent).closest(Selector.NAVBAR_NAV).length === 0) { $$$1(document.body).children().on('mouseover', null, $$$1.noop); }
                this._element.focus();
                this._element.setAttribute('aria-expanded', true);
                $$$1(this._menu).toggleClass(ClassName.SHOW);
                $$$1(parent).toggleClass(ClassName.SHOW).trigger($$$1.Event(Event.SHOWN, relatedTarget));
            };
            _proto.dispose = function dispose() {
                $$$1.removeData(this._element, DATA_KEY);
                $$$1(this._element).off(EVENT_KEY);
                this._element = null;
                this._menu = null;
                if (this._popper !== null) {
                    this._popper.destroy();
                    this._popper = null;
                }
            };
            _proto.update = function update() { this._inNavbar = this._detectNavbar(); if (this._popper !== null) { this._popper.scheduleUpdate(); } };
            _proto._addEventListeners = function _addEventListeners() {
                var _this = this;
                $$$1(this._element).on(Event.CLICK, function(event) {
                    event.preventDefault();
                    event.stopPropagation();
                    _this.toggle();
                });
            };
            _proto._getConfig = function _getConfig(config) {
                config = _objectSpread({}, this.constructor.Default, $$$1(this._element).data(), config);
                Util.typeCheckConfig(NAME, config, this.constructor.DefaultType);
                return config;
            };
            _proto._getMenuElement = function _getMenuElement() {
                if (!this._menu) { var parent = Dropdown._getParentFromElement(this._element); if (parent) { this._menu = parent.querySelector(Selector.MENU); } }
                return this._menu;
            };
            _proto._getPlacement = function _getPlacement() {
                var $parentDropdown = $$$1(this._element.parentNode);
                var placement = AttachmentMap.BOTTOM;
                if ($parentDropdown.hasClass(ClassName.DROPUP)) { placement = AttachmentMap.TOP; if ($$$1(this._menu).hasClass(ClassName.MENURIGHT)) { placement = AttachmentMap.TOPEND; } } else if ($parentDropdown.hasClass(ClassName.DROPRIGHT)) { placement = AttachmentMap.RIGHT; } else if ($parentDropdown.hasClass(ClassName.DROPLEFT)) { placement = AttachmentMap.LEFT; } else if ($$$1(this._menu).hasClass(ClassName.MENURIGHT)) { placement = AttachmentMap.BOTTOMEND; }
                return placement;
            };
            _proto._detectNavbar = function _detectNavbar() { return $$$1(this._element).closest('.navbar').length > 0; };
            _proto._getPopperConfig = function _getPopperConfig() {
                var _this2 = this;
                var offsetConf = {};
                if (typeof this._config.offset === 'function') { offsetConf.fn = function(data) { data.offsets = _objectSpread({}, data.offsets, _this2._config.offset(data.offsets) || {}); return data; }; } else { offsetConf.offset = this._config.offset; }
                var popperConfig = { placement: this._getPlacement(), modifiers: { offset: offsetConf, flip: { enabled: this._config.flip }, preventOverflow: { boundariesElement: this._config.boundary } } };
                if (this._config.display === 'static') { popperConfig.modifiers.applyStyle = { enabled: false }; }
                return popperConfig;
            };
            Dropdown._jQueryInterface = function _jQueryInterface(config) {
                return this.each(function() {
                    var data = $$$1(this).data(DATA_KEY);
                    var _config = typeof config === 'object' ? config : null;
                    if (!data) {
                        data = new Dropdown(this, _config);
                        $$$1(this).data(DATA_KEY, data);
                    }
                    if (typeof config === 'string') {
                        if (typeof data[config] === 'undefined') { throw new TypeError("No method named \"" + config + "\""); }
                        data[config]();
                    }
                });
            };
            Dropdown._clearMenus = function _clearMenus(event) {
                if (event && (event.which === RIGHT_MOUSE_BUTTON_WHICH || event.type === 'keyup' && event.which !== TAB_KEYCODE)) { return; }
                var toggles = [].slice.call(document.querySelectorAll(Selector.DATA_TOGGLE));
                for (var i = 0, len = toggles.length; i < len; i++) {
                    var parent = Dropdown._getParentFromElement(toggles[i]);
                    var context = $$$1(toggles[i]).data(DATA_KEY);
                    var relatedTarget = { relatedTarget: toggles[i] };
                    if (event && event.type === 'click') { relatedTarget.clickEvent = event; }
                    if (!context) { continue; }
                    var dropdownMenu = context._menu;
                    if (!$$$1(parent).hasClass(ClassName.SHOW)) { continue; }
                    if (event && (event.type === 'click' && /input|textarea/i.test(event.target.tagName) || event.type === 'keyup' && event.which === TAB_KEYCODE) && $$$1.contains(parent, event.target)) { continue; }
                    var hideEvent = $$$1.Event(Event.HIDE, relatedTarget);
                    $$$1(parent).trigger(hideEvent);
                    if (hideEvent.isDefaultPrevented()) { continue; }
                    if ('ontouchstart' in document.documentElement) { $$$1(document.body).children().off('mouseover', null, $$$1.noop); }
                    toggles[i].setAttribute('aria-expanded', 'false');
                    $$$1(dropdownMenu).removeClass(ClassName.SHOW);
                    $$$1(parent).removeClass(ClassName.SHOW).trigger($$$1.Event(Event.HIDDEN, relatedTarget));
                }
            };
            Dropdown._getParentFromElement = function _getParentFromElement(element) {
                var parent;
                var selector = Util.getSelectorFromElement(element);
                if (selector) { parent = document.querySelector(selector); }
                return parent || element.parentNode;
            };
            Dropdown._dataApiKeydownHandler = function _dataApiKeydownHandler(event) {
                if (/input|textarea/i.test(event.target.tagName) ? event.which === SPACE_KEYCODE || event.which !== ESCAPE_KEYCODE && (event.which !== ARROW_DOWN_KEYCODE && event.which !== ARROW_UP_KEYCODE || $$$1(event.target).closest(Selector.MENU).length) : !REGEXP_KEYDOWN.test(event.which)) { return; }
                event.preventDefault();
                event.stopPropagation();
                if (this.disabled || $$$1(this).hasClass(ClassName.DISABLED)) { return; }
                var parent = Dropdown._getParentFromElement(this);
                var isActive = $$$1(parent).hasClass(ClassName.SHOW);
                if (!isActive && (event.which !== ESCAPE_KEYCODE || event.which !== SPACE_KEYCODE) || isActive && (event.which === ESCAPE_KEYCODE || event.which === SPACE_KEYCODE)) {
                    if (event.which === ESCAPE_KEYCODE) {
                        var toggle = parent.querySelector(Selector.DATA_TOGGLE);
                        $$$1(toggle).trigger('focus');
                    }
                    $$$1(this).trigger('click');
                    return;
                }
                var items = [].slice.call(parent.querySelectorAll(Selector.VISIBLE_ITEMS));
                if (items.length === 0) { return; }
                var index = items.indexOf(event.target);
                if (event.which === ARROW_UP_KEYCODE && index > 0) { index--; }
                if (event.which === ARROW_DOWN_KEYCODE && index < items.length - 1) { index++; }
                if (index < 0) { index = 0; }
                items[index].focus();
            };
            _createClass(Dropdown, null, [{ key: "VERSION", get: function get() { return VERSION; } }, { key: "Default", get: function get() { return Default; } }, { key: "DefaultType", get: function get() { return DefaultType; } }]);
            return Dropdown;
        }();
        $$$1(document).on(Event.KEYDOWN_DATA_API, Selector.DATA_TOGGLE, Dropdown._dataApiKeydownHandler).on(Event.KEYDOWN_DATA_API, Selector.MENU, Dropdown._dataApiKeydownHandler).on(Event.CLICK_DATA_API + " " + Event.KEYUP_DATA_API, Dropdown._clearMenus).on(Event.CLICK_DATA_API, Selector.DATA_TOGGLE, function(event) {
            event.preventDefault();
            event.stopPropagation();
            Dropdown._jQueryInterface.call($$$1(this), 'toggle');
        }).on(Event.CLICK_DATA_API, Selector.FORM_CHILD, function(e) { e.stopPropagation(); });
        $$$1.fn[NAME] = Dropdown._jQueryInterface;
        $$$1.fn[NAME].Constructor = Dropdown;
        $$$1.fn[NAME].noConflict = function() { $$$1.fn[NAME] = JQUERY_NO_CONFLICT; return Dropdown._jQueryInterface; };
        return Dropdown;
    }($, Popper);
    var Modal = function($$$1) {
        var NAME = 'modal';
        var VERSION = '4.1.3';
        var DATA_KEY = 'bs.modal';
        var EVENT_KEY = "." + DATA_KEY;
        var DATA_API_KEY = '.data-api';
        var JQUERY_NO_CONFLICT = $$$1.fn[NAME];
        var ESCAPE_KEYCODE = 27;
        var Default = { backdrop: true, keyboard: true, focus: true, show: true };
        var DefaultType = { backdrop: '(boolean|string)', keyboard: 'boolean', focus: 'boolean', show: 'boolean' };
        var Event = { HIDE: "hide" + EVENT_KEY, HIDDEN: "hidden" + EVENT_KEY, SHOW: "show" + EVENT_KEY, SHOWN: "shown" + EVENT_KEY, FOCUSIN: "focusin" + EVENT_KEY, RESIZE: "resize" + EVENT_KEY, CLICK_DISMISS: "click.dismiss" + EVENT_KEY, KEYDOWN_DISMISS: "keydown.dismiss" + EVENT_KEY, MOUSEUP_DISMISS: "mouseup.dismiss" + EVENT_KEY, MOUSEDOWN_DISMISS: "mousedown.dismiss" + EVENT_KEY, CLICK_DATA_API: "click" + EVENT_KEY + DATA_API_KEY };
        var ClassName = { SCROLLBAR_MEASURER: 'modal-scrollbar-measure', BACKDROP: 'modal-backdrop', OPEN: 'modal-open', FADE: 'fade', SHOW: 'show' };
        var Selector = { DIALOG: '.modal-dialog', DATA_TOGGLE: '[data-toggle="modal"]', DATA_DISMISS: '[data-dismiss="modal"]', FIXED_CONTENT: '.fixed-top, .fixed-bottom, .is-fixed, .sticky-top', STICKY_CONTENT: '.sticky-top' };
        var Modal = function() {
            function Modal(element, config) {
                this._config = this._getConfig(config);
                this._element = element;
                this._dialog = element.querySelector(Selector.DIALOG);
                this._backdrop = null;
                this._isShown = false;
                this._isBodyOverflowing = false;
                this._ignoreBackdropClick = false;
                this._scrollbarWidth = 0;
            }
            var _proto = Modal.prototype;
            _proto.toggle = function toggle(relatedTarget) { return this._isShown ? this.hide() : this.show(relatedTarget); };
            _proto.show = function show(relatedTarget) {
                var _this = this;
                if (this._isTransitioning || this._isShown) { return; }
                if ($$$1(this._element).hasClass(ClassName.FADE)) { this._isTransitioning = true; }
                var showEvent = $$$1.Event(Event.SHOW, { relatedTarget: relatedTarget });
                $$$1(this._element).trigger(showEvent);
                if (this._isShown || showEvent.isDefaultPrevented()) { return; }
                this._isShown = true;
                this._checkScrollbar();
                this._setScrollbar();
                this._adjustDialog();
                $$$1(document.body).addClass(ClassName.OPEN);
                this._setEscapeEvent();
                this._setResizeEvent();
                $$$1(this._element).on(Event.CLICK_DISMISS, Selector.DATA_DISMISS, function(event) { return _this.hide(event); });
                $$$1(this._dialog).on(Event.MOUSEDOWN_DISMISS, function() { $$$1(_this._element).one(Event.MOUSEUP_DISMISS, function(event) { if ($$$1(event.target).is(_this._element)) { _this._ignoreBackdropClick = true; } }); });
                this._showBackdrop(function() { return _this._showElement(relatedTarget); });
            };
            _proto.hide = function hide(event) {
                var _this2 = this;
                if (event) { event.preventDefault(); }
                if (this._isTransitioning || !this._isShown) { return; }
                var hideEvent = $$$1.Event(Event.HIDE);
                $$$1(this._element).trigger(hideEvent);
                if (!this._isShown || hideEvent.isDefaultPrevented()) { return; }
                this._isShown = false;
                var transition = $$$1(this._element).hasClass(ClassName.FADE);
                if (transition) { this._isTransitioning = true; }
                this._setEscapeEvent();
                this._setResizeEvent();
                $$$1(document).off(Event.FOCUSIN);
                $$$1(this._element).removeClass(ClassName.SHOW);
                $$$1(this._element).off(Event.CLICK_DISMISS);
                $$$1(this._dialog).off(Event.MOUSEDOWN_DISMISS);
                if (transition) {
                    var transitionDuration = Util.getTransitionDurationFromElement(this._element);
                    $$$1(this._element).one(Util.TRANSITION_END, function(event) { return _this2._hideModal(event); }).emulateTransitionEnd(transitionDuration);
                } else { this._hideModal(); }
            };
            _proto.dispose = function dispose() {
                $$$1.removeData(this._element, DATA_KEY);
                $$$1(window, document, this._element, this._backdrop).off(EVENT_KEY);
                this._config = null;
                this._element = null;
                this._dialog = null;
                this._backdrop = null;
                this._isShown = null;
                this._isBodyOverflowing = null;
                this._ignoreBackdropClick = null;
                this._scrollbarWidth = null;
            };
            _proto.handleUpdate = function handleUpdate() { this._adjustDialog(); };
            _proto._getConfig = function _getConfig(config) {
                config = _objectSpread({}, Default, config);
                Util.typeCheckConfig(NAME, config, DefaultType);
                return config;
            };
            _proto._showElement = function _showElement(relatedTarget) {
                var _this3 = this;
                var transition = $$$1(this._element).hasClass(ClassName.FADE);
                if (!this._element.parentNode || this._element.parentNode.nodeType !== Node.ELEMENT_NODE) { document.body.appendChild(this._element); }
                this._element.style.display = 'block';
                this._element.removeAttribute('aria-hidden');
                this._element.scrollTop = 0;
                if (transition) { Util.reflow(this._element); }
                $$$1(this._element).addClass(ClassName.SHOW);
                if (this._config.focus) { this._enforceFocus(); }
                var shownEvent = $$$1.Event(Event.SHOWN, { relatedTarget: relatedTarget });
                var transitionComplete = function transitionComplete() {
                    if (_this3._config.focus) { _this3._element.focus(); }
                    _this3._isTransitioning = false;
                    $$$1(_this3._element).trigger(shownEvent);
                };
                if (transition) {
                    var transitionDuration = Util.getTransitionDurationFromElement(this._element);
                    $$$1(this._dialog).one(Util.TRANSITION_END, transitionComplete).emulateTransitionEnd(transitionDuration);
                } else { transitionComplete(); }
            };
            _proto._enforceFocus = function _enforceFocus() {
                var _this4 = this;
                $$$1(document).off(Event.FOCUSIN).on(Event.FOCUSIN, function(event) { if (document !== event.target && _this4._element !== event.target && $$$1(_this4._element).has(event.target).length === 0) { _this4._element.focus(); } });
            };
            _proto._setEscapeEvent = function _setEscapeEvent() {
                var _this5 = this;
                if (this._isShown && this._config.keyboard) {
                    $$$1(this._element).on(Event.KEYDOWN_DISMISS, function(event) {
                        if (event.which === ESCAPE_KEYCODE) {
                            event.preventDefault();
                            _this5.hide();
                        }
                    });
                } else if (!this._isShown) { $$$1(this._element).off(Event.KEYDOWN_DISMISS); }
            };
            _proto._setResizeEvent = function _setResizeEvent() { var _this6 = this; if (this._isShown) { $$$1(window).on(Event.RESIZE, function(event) { return _this6.handleUpdate(event); }); } else { $$$1(window).off(Event.RESIZE); } };
            _proto._hideModal = function _hideModal() {
                var _this7 = this;
                this._element.style.display = 'none';
                this._element.setAttribute('aria-hidden', true);
                this._isTransitioning = false;
                this._showBackdrop(function() {
                    $$$1(document.body).removeClass(ClassName.OPEN);
                    _this7._resetAdjustments();
                    _this7._resetScrollbar();
                    $$$1(_this7._element).trigger(Event.HIDDEN);
                });
            };
            _proto._removeBackdrop = function _removeBackdrop() {
                if (this._backdrop) {
                    $$$1(this._backdrop).remove();
                    this._backdrop = null;
                }
            };
            _proto._showBackdrop = function _showBackdrop(callback) {
                var _this8 = this;
                var animate = $$$1(this._element).hasClass(ClassName.FADE) ? ClassName.FADE : '';
                if (this._isShown && this._config.backdrop) {
                    this._backdrop = document.createElement('div');
                    this._backdrop.className = ClassName.BACKDROP;
                    if (animate) { this._backdrop.classList.add(animate); }
                    $$$1(this._backdrop).appendTo(document.body);
                    $$$1(this._element).on(Event.CLICK_DISMISS, function(event) {
                        if (_this8._ignoreBackdropClick) { _this8._ignoreBackdropClick = false; return; }
                        if (event.target !== event.currentTarget) { return; }
                        if (_this8._config.backdrop === 'static') { _this8._element.focus(); } else { _this8.hide(); }
                    });
                    if (animate) { Util.reflow(this._backdrop); }
                    $$$1(this._backdrop).addClass(ClassName.SHOW);
                    if (!callback) { return; }
                    if (!animate) { callback(); return; }
                    var backdropTransitionDuration = Util.getTransitionDurationFromElement(this._backdrop);
                    $$$1(this._backdrop).one(Util.TRANSITION_END, callback).emulateTransitionEnd(backdropTransitionDuration);
                } else if (!this._isShown && this._backdrop) {
                    $$$1(this._backdrop).removeClass(ClassName.SHOW);
                    var callbackRemove = function callbackRemove() { _this8._removeBackdrop(); if (callback) { callback(); } };
                    if ($$$1(this._element).hasClass(ClassName.FADE)) {
                        var _backdropTransitionDuration = Util.getTransitionDurationFromElement(this._backdrop);
                        $$$1(this._backdrop).one(Util.TRANSITION_END, callbackRemove).emulateTransitionEnd(_backdropTransitionDuration);
                    } else { callbackRemove(); }
                } else if (callback) { callback(); }
            };
            _proto._adjustDialog = function _adjustDialog() {
                var isModalOverflowing = this._element.scrollHeight > document.documentElement.clientHeight;
                if (!this._isBodyOverflowing && isModalOverflowing) { this._element.style.paddingLeft = this._scrollbarWidth + "px"; }
                if (this._isBodyOverflowing && !isModalOverflowing) { this._element.style.paddingRight = this._scrollbarWidth + "px"; }
            };
            _proto._resetAdjustments = function _resetAdjustments() {
                this._element.style.paddingLeft = '';
                this._element.style.paddingRight = '';
            };
            _proto._checkScrollbar = function _checkScrollbar() {
                var rect = document.body.getBoundingClientRect();
                this._isBodyOverflowing = rect.left + rect.right < window.innerWidth;
                this._scrollbarWidth = this._getScrollbarWidth();
            };
            _proto._setScrollbar = function _setScrollbar() {
                var _this9 = this;
                if (this._isBodyOverflowing) {
                    var fixedContent = [].slice.call(document.querySelectorAll(Selector.FIXED_CONTENT));
                    var stickyContent = [].slice.call(document.querySelectorAll(Selector.STICKY_CONTENT));
                    $$$1(fixedContent).each(function(index, element) {
                        var actualPadding = element.style.paddingRight;
                        var calculatedPadding = $$$1(element).css('padding-right');
                        $$$1(element).data('padding-right', actualPadding).css('padding-right', parseFloat(calculatedPadding) + _this9._scrollbarWidth + "px");
                    });
                    $$$1(stickyContent).each(function(index, element) {
                        var actualMargin = element.style.marginRight;
                        var calculatedMargin = $$$1(element).css('margin-right');
                        $$$1(element).data('margin-right', actualMargin).css('margin-right', parseFloat(calculatedMargin) - _this9._scrollbarWidth + "px");
                    });
                    var actualPadding = document.body.style.paddingRight;
                    var calculatedPadding = $$$1(document.body).css('padding-right');
                    $$$1(document.body).data('padding-right', actualPadding).css('padding-right', parseFloat(calculatedPadding) + this._scrollbarWidth + "px");
                }
            };
            _proto._resetScrollbar = function _resetScrollbar() {
                var fixedContent = [].slice.call(document.querySelectorAll(Selector.FIXED_CONTENT));
                $$$1(fixedContent).each(function(index, element) {
                    var padding = $$$1(element).data('padding-right');
                    $$$1(element).removeData('padding-right');
                    element.style.paddingRight = padding ? padding : '';
                });
                var elements = [].slice.call(document.querySelectorAll("" + Selector.STICKY_CONTENT));
                $$$1(elements).each(function(index, element) { var margin = $$$1(element).data('margin-right'); if (typeof margin !== 'undefined') { $$$1(element).css('margin-right', margin).removeData('margin-right'); } });
                var padding = $$$1(document.body).data('padding-right');
                $$$1(document.body).removeData('padding-right');
                document.body.style.paddingRight = padding ? padding : '';
            };
            _proto._getScrollbarWidth = function _getScrollbarWidth() {
                var scrollDiv = document.createElement('div');
                scrollDiv.className = ClassName.SCROLLBAR_MEASURER;
                document.body.appendChild(scrollDiv);
                var scrollbarWidth = scrollDiv.getBoundingClientRect().width - scrollDiv.clientWidth;
                document.body.removeChild(scrollDiv);
                return scrollbarWidth;
            };
            Modal._jQueryInterface = function _jQueryInterface(config, relatedTarget) {
                return this.each(function() {
                    var data = $$$1(this).data(DATA_KEY);
                    var _config = _objectSpread({}, Default, $$$1(this).data(), typeof config === 'object' && config ? config : {});
                    if (!data) {
                        data = new Modal(this, _config);
                        $$$1(this).data(DATA_KEY, data);
                    }
                    if (typeof config === 'string') {
                        if (typeof data[config] === 'undefined') { throw new TypeError("No method named \"" + config + "\""); }
                        data[config](relatedTarget);
                    } else if (_config.show) { data.show(relatedTarget); }
                });
            };
            _createClass(Modal, null, [{ key: "VERSION", get: function get() { return VERSION; } }, { key: "Default", get: function get() { return Default; } }]);
            return Modal;
        }();
        $$$1(document).on(Event.CLICK_DATA_API, Selector.DATA_TOGGLE, function(event) {
            var _this10 = this;
            var target;
            var selector = Util.getSelectorFromElement(this);
            if (selector) { target = document.querySelector(selector); }
            var config = $$$1(target).data(DATA_KEY) ? 'toggle' : _objectSpread({}, $$$1(target).data(), $$$1(this).data());
            if (this.tagName === 'A' || this.tagName === 'AREA') { event.preventDefault(); }
            var $target = $$$1(target).one(Event.SHOW, function(showEvent) {
                if (showEvent.isDefaultPrevented()) { return; }
                $target.one(Event.HIDDEN, function() { if ($$$1(_this10).is(':visible')) { _this10.focus(); } });
            });
            Modal._jQueryInterface.call($$$1(target), config, this);
        });
        $$$1.fn[NAME] = Modal._jQueryInterface;
        $$$1.fn[NAME].Constructor = Modal;
        $$$1.fn[NAME].noConflict = function() { $$$1.fn[NAME] = JQUERY_NO_CONFLICT; return Modal._jQueryInterface; };
        return Modal;
    }($);
    var Tooltip = function($$$1) {
        var NAME = 'tooltip';
        var VERSION = '4.1.3';
        var DATA_KEY = 'bs.tooltip';
        var EVENT_KEY = "." + DATA_KEY;
        var JQUERY_NO_CONFLICT = $$$1.fn[NAME];
        var CLASS_PREFIX = 'bs-tooltip';
        var BSCLS_PREFIX_REGEX = new RegExp("(^|\\s)" + CLASS_PREFIX + "\\S+", 'g');
        var DefaultType = { animation: 'boolean', template: 'string', title: '(string|element|function)', trigger: 'string', delay: '(number|object)', html: 'boolean', selector: '(string|boolean)', placement: '(string|function)', offset: '(number|string)', container: '(string|element|boolean)', fallbackPlacement: '(string|array)', boundary: '(string|element)' };
        var AttachmentMap = { AUTO: 'auto', TOP: 'top', RIGHT: 'right', BOTTOM: 'bottom', LEFT: 'left' };
        var Default = { animation: true, template: '<div class="tooltip" role="tooltip">' + '<div class="arrow"></div>' + '<div class="tooltip-inner"></div></div>', trigger: 'hover focus', title: '', delay: 0, html: false, selector: false, placement: 'top', offset: 0, container: false, fallbackPlacement: 'flip', boundary: 'scrollParent' };
        var HoverState = { SHOW: 'show', OUT: 'out' };
        var Event = { HIDE: "hide" + EVENT_KEY, HIDDEN: "hidden" + EVENT_KEY, SHOW: "show" + EVENT_KEY, SHOWN: "shown" + EVENT_KEY, INSERTED: "inserted" + EVENT_KEY, CLICK: "click" + EVENT_KEY, FOCUSIN: "focusin" + EVENT_KEY, FOCUSOUT: "focusout" + EVENT_KEY, MOUSEENTER: "mouseenter" + EVENT_KEY, MOUSELEAVE: "mouseleave" + EVENT_KEY };
        var ClassName = { FADE: 'fade', SHOW: 'show' };
        var Selector = { TOOLTIP: '.tooltip', TOOLTIP_INNER: '.tooltip-inner', ARROW: '.arrow' };
        var Trigger = { HOVER: 'hover', FOCUS: 'focus', CLICK: 'click', MANUAL: 'manual' };
        var Tooltip = function() {
            function Tooltip(element, config) {
                if (typeof Popper === 'undefined') { throw new TypeError('Bootstrap tooltips require Popper.js (https://popper.js.org)'); }
                this._isEnabled = true;
                this._timeout = 0;
                this._hoverState = '';
                this._activeTrigger = {};
                this._popper = null;
                this.element = element;
                this.config = this._getConfig(config);
                this.tip = null;
                this._setListeners();
            }
            var _proto = Tooltip.prototype;
            _proto.enable = function enable() { this._isEnabled = true; };
            _proto.disable = function disable() { this._isEnabled = false; };
            _proto.toggleEnabled = function toggleEnabled() { this._isEnabled = !this._isEnabled; };
            _proto.toggle = function toggle(event) {
                if (!this._isEnabled) { return; }
                if (event) {
                    var dataKey = this.constructor.DATA_KEY;
                    var context = $$$1(event.currentTarget).data(dataKey);
                    if (!context) {
                        context = new this.constructor(event.currentTarget, this._getDelegateConfig());
                        $$$1(event.currentTarget).data(dataKey, context);
                    }
                    context._activeTrigger.click = !context._activeTrigger.click;
                    if (context._isWithActiveTrigger()) { context._enter(null, context); } else { context._leave(null, context); }
                } else {
                    if ($$$1(this.getTipElement()).hasClass(ClassName.SHOW)) { this._leave(null, this); return; }
                    this._enter(null, this);
                }
            };
            _proto.dispose = function dispose() {
                clearTimeout(this._timeout);
                $$$1.removeData(this.element, this.constructor.DATA_KEY);
                $$$1(this.element).off(this.constructor.EVENT_KEY);
                $$$1(this.element).closest('.modal').off('hide.bs.modal');
                if (this.tip) { $$$1(this.tip).remove(); }
                this._isEnabled = null;
                this._timeout = null;
                this._hoverState = null;
                this._activeTrigger = null;
                if (this._popper !== null) { this._popper.destroy(); }
                this._popper = null;
                this.element = null;
                this.config = null;
                this.tip = null;
            };
            _proto.show = function show() {
                var _this = this;
                if ($$$1(this.element).css('display') === 'none') { throw new Error('Please use show on visible elements'); }
                var showEvent = $$$1.Event(this.constructor.Event.SHOW);
                if (this.isWithContent() && this._isEnabled) {
                    $$$1(this.element).trigger(showEvent);
                    var isInTheDom = $$$1.contains(this.element.ownerDocument.documentElement, this.element);
                    if (showEvent.isDefaultPrevented() || !isInTheDom) { return; }
                    var tip = this.getTipElement();
                    var tipId = Util.getUID(this.constructor.NAME);
                    tip.setAttribute('id', tipId);
                    this.element.setAttribute('aria-describedby', tipId);
                    this.setContent();
                    if (this.config.animation) { $$$1(tip).addClass(ClassName.FADE); }
                    var placement = typeof this.config.placement === 'function' ? this.config.placement.call(this, tip, this.element) : this.config.placement;
                    var attachment = this._getAttachment(placement);
                    this.addAttachmentClass(attachment);
                    var container = this.config.container === false ? document.body : $$$1(document).find(this.config.container);
                    $$$1(tip).data(this.constructor.DATA_KEY, this);
                    if (!$$$1.contains(this.element.ownerDocument.documentElement, this.tip)) { $$$1(tip).appendTo(container); }
                    $$$1(this.element).trigger(this.constructor.Event.INSERTED);
                    this._popper = new Popper(this.element, tip, { placement: attachment, modifiers: { offset: { offset: this.config.offset }, flip: { behavior: this.config.fallbackPlacement }, arrow: { element: Selector.ARROW }, preventOverflow: { boundariesElement: this.config.boundary } }, onCreate: function onCreate(data) { if (data.originalPlacement !== data.placement) { _this._handlePopperPlacementChange(data); } }, onUpdate: function onUpdate(data) { _this._handlePopperPlacementChange(data); } });
                    $$$1(tip).addClass(ClassName.SHOW);
                    if ('ontouchstart' in document.documentElement) { $$$1(document.body).children().on('mouseover', null, $$$1.noop); }
                    var complete = function complete() {
                        if (_this.config.animation) { _this._fixTransition(); }
                        var prevHoverState = _this._hoverState;
                        _this._hoverState = null;
                        $$$1(_this.element).trigger(_this.constructor.Event.SHOWN);
                        if (prevHoverState === HoverState.OUT) { _this._leave(null, _this); }
                    };
                    if ($$$1(this.tip).hasClass(ClassName.FADE)) {
                        var transitionDuration = Util.getTransitionDurationFromElement(this.tip);
                        $$$1(this.tip).one(Util.TRANSITION_END, complete).emulateTransitionEnd(transitionDuration);
                    } else { complete(); }
                }
            };
            _proto.hide = function hide(callback) {
                var _this2 = this;
                var tip = this.getTipElement();
                var hideEvent = $$$1.Event(this.constructor.Event.HIDE);
                var complete = function complete() {
                    if (_this2._hoverState !== HoverState.SHOW && tip.parentNode) { tip.parentNode.removeChild(tip); }
                    _this2._cleanTipClass();
                    _this2.element.removeAttribute('aria-describedby');
                    $$$1(_this2.element).trigger(_this2.constructor.Event.HIDDEN);
                    if (_this2._popper !== null) { _this2._popper.destroy(); }
                    if (callback) { callback(); }
                };
                $$$1(this.element).trigger(hideEvent);
                if (hideEvent.isDefaultPrevented()) { return; }
                $$$1(tip).removeClass(ClassName.SHOW);
                if ('ontouchstart' in document.documentElement) { $$$1(document.body).children().off('mouseover', null, $$$1.noop); }
                this._activeTrigger[Trigger.CLICK] = false;
                this._activeTrigger[Trigger.FOCUS] = false;
                this._activeTrigger[Trigger.HOVER] = false;
                if ($$$1(this.tip).hasClass(ClassName.FADE)) {
                    var transitionDuration = Util.getTransitionDurationFromElement(tip);
                    $$$1(tip).one(Util.TRANSITION_END, complete).emulateTransitionEnd(transitionDuration);
                } else { complete(); }
                this._hoverState = '';
            };
            _proto.update = function update() { if (this._popper !== null) { this._popper.scheduleUpdate(); } };
            _proto.isWithContent = function isWithContent() { return Boolean(this.getTitle()); };
            _proto.addAttachmentClass = function addAttachmentClass(attachment) { $$$1(this.getTipElement()).addClass(CLASS_PREFIX + "-" + attachment); };
            _proto.getTipElement = function getTipElement() { this.tip = this.tip || $$$1(this.config.template)[0]; return this.tip; };
            _proto.setContent = function setContent() {
                var tip = this.getTipElement();
                this.setElementContent($$$1(tip.querySelectorAll(Selector.TOOLTIP_INNER)), this.getTitle());
                $$$1(tip).removeClass(ClassName.FADE + " " + ClassName.SHOW);
            };
            _proto.setElementContent = function setElementContent($element, content) { var html = this.config.html; if (typeof content === 'object' && (content.nodeType || content.jquery)) { if (html) { if (!$$$1(content).parent().is($element)) { $element.empty().append(content); } } else { $element.text($$$1(content).text()); } } else { $element[html ? 'html' : 'text'](content); } };
            _proto.getTitle = function getTitle() {
                var title = this.element.getAttribute('data-original-title');
                if (!title) { title = typeof this.config.title === 'function' ? this.config.title.call(this.element) : this.config.title; }
                return title;
            };
            _proto._getAttachment = function _getAttachment(placement) { return AttachmentMap[placement.toUpperCase()]; };
            _proto._setListeners = function _setListeners() {
                var _this3 = this;
                var triggers = this.config.trigger.split(' ');
                triggers.forEach(function(trigger) {
                    if (trigger === 'click') { $$$1(_this3.element).on(_this3.constructor.Event.CLICK, _this3.config.selector, function(event) { return _this3.toggle(event); }); } else if (trigger !== Trigger.MANUAL) {
                        var eventIn = trigger === Trigger.HOVER ? _this3.constructor.Event.MOUSEENTER : _this3.constructor.Event.FOCUSIN;
                        var eventOut = trigger === Trigger.HOVER ? _this3.constructor.Event.MOUSELEAVE : _this3.constructor.Event.FOCUSOUT;
                        $$$1(_this3.element).on(eventIn, _this3.config.selector, function(event) { return _this3._enter(event); }).on(eventOut, _this3.config.selector, function(event) { return _this3._leave(event); });
                    }
                    $$$1(_this3.element).closest('.modal').on('hide.bs.modal', function() { return _this3.hide(); });
                });
                if (this.config.selector) { this.config = _objectSpread({}, this.config, { trigger: 'manual', selector: '' }); } else { this._fixTitle(); }
            };
            _proto._fixTitle = function _fixTitle() {
                var titleType = typeof this.element.getAttribute('data-original-title');
                if (this.element.getAttribute('title') || titleType !== 'string') {
                    this.element.setAttribute('data-original-title', this.element.getAttribute('title') || '');
                    this.element.setAttribute('title', '');
                }
            };
            _proto._enter = function _enter(event, context) {
                var dataKey = this.constructor.DATA_KEY;
                context = context || $$$1(event.currentTarget).data(dataKey);
                if (!context) {
                    context = new this.constructor(event.currentTarget, this._getDelegateConfig());
                    $$$1(event.currentTarget).data(dataKey, context);
                }
                if (event) { context._activeTrigger[event.type === 'focusin' ? Trigger.FOCUS : Trigger.HOVER] = true; }
                if ($$$1(context.getTipElement()).hasClass(ClassName.SHOW) || context._hoverState === HoverState.SHOW) { context._hoverState = HoverState.SHOW; return; }
                clearTimeout(context._timeout);
                context._hoverState = HoverState.SHOW;
                if (!context.config.delay || !context.config.delay.show) { context.show(); return; }
                context._timeout = setTimeout(function() { if (context._hoverState === HoverState.SHOW) { context.show(); } }, context.config.delay.show);
            };
            _proto._leave = function _leave(event, context) {
                var dataKey = this.constructor.DATA_KEY;
                context = context || $$$1(event.currentTarget).data(dataKey);
                if (!context) {
                    context = new this.constructor(event.currentTarget, this._getDelegateConfig());
                    $$$1(event.currentTarget).data(dataKey, context);
                }
                if (event) { context._activeTrigger[event.type === 'focusout' ? Trigger.FOCUS : Trigger.HOVER] = false; }
                if (context._isWithActiveTrigger()) { return; }
                clearTimeout(context._timeout);
                context._hoverState = HoverState.OUT;
                if (!context.config.delay || !context.config.delay.hide) { context.hide(); return; }
                context._timeout = setTimeout(function() { if (context._hoverState === HoverState.OUT) { context.hide(); } }, context.config.delay.hide);
            };
            _proto._isWithActiveTrigger = function _isWithActiveTrigger() {
                for (var trigger in this._activeTrigger) { if (this._activeTrigger[trigger]) { return true; } }
                return false;
            };
            _proto._getConfig = function _getConfig(config) {
                config = _objectSpread({}, this.constructor.Default, $$$1(this.element).data(), typeof config === 'object' && config ? config : {});
                if (typeof config.delay === 'number') { config.delay = { show: config.delay, hide: config.delay }; }
                if (typeof config.title === 'number') { config.title = config.title.toString(); }
                if (typeof config.content === 'number') { config.content = config.content.toString(); }
                Util.typeCheckConfig(NAME, config, this.constructor.DefaultType);
                return config;
            };
            _proto._getDelegateConfig = function _getDelegateConfig() {
                var config = {};
                if (this.config) { for (var key in this.config) { if (this.constructor.Default[key] !== this.config[key]) { config[key] = this.config[key]; } } }
                return config;
            };
            _proto._cleanTipClass = function _cleanTipClass() { var $tip = $$$1(this.getTipElement()); var tabClass = $tip.attr('class').match(BSCLS_PREFIX_REGEX); if (tabClass !== null && tabClass.length) { $tip.removeClass(tabClass.join('')); } };
            _proto._handlePopperPlacementChange = function _handlePopperPlacementChange(popperData) {
                var popperInstance = popperData.instance;
                this.tip = popperInstance.popper;
                this._cleanTipClass();
                this.addAttachmentClass(this._getAttachment(popperData.placement));
            };
            _proto._fixTransition = function _fixTransition() {
                var tip = this.getTipElement();
                var initConfigAnimation = this.config.animation;
                if (tip.getAttribute('x-placement') !== null) { return; }
                $$$1(tip).removeClass(ClassName.FADE);
                this.config.animation = false;
                this.hide();
                this.show();
                this.config.animation = initConfigAnimation;
            };
            Tooltip._jQueryInterface = function _jQueryInterface(config) {
                return this.each(function() {
                    var data = $$$1(this).data(DATA_KEY);
                    var _config = typeof config === 'object' && config;
                    if (!data && /dispose|hide/.test(config)) { return; }
                    if (!data) {
                        data = new Tooltip(this, _config);
                        $$$1(this).data(DATA_KEY, data);
                    }
                    if (typeof config === 'string') {
                        if (typeof data[config] === 'undefined') { throw new TypeError("No method named \"" + config + "\""); }
                        data[config]();
                    }
                });
            };
            _createClass(Tooltip, null, [{ key: "VERSION", get: function get() { return VERSION; } }, { key: "Default", get: function get() { return Default; } }, { key: "NAME", get: function get() { return NAME; } }, { key: "DATA_KEY", get: function get() { return DATA_KEY; } }, { key: "Event", get: function get() { return Event; } }, { key: "EVENT_KEY", get: function get() { return EVENT_KEY; } }, { key: "DefaultType", get: function get() { return DefaultType; } }]);
            return Tooltip;
        }();
        $$$1.fn[NAME] = Tooltip._jQueryInterface;
        $$$1.fn[NAME].Constructor = Tooltip;
        $$$1.fn[NAME].noConflict = function() { $$$1.fn[NAME] = JQUERY_NO_CONFLICT; return Tooltip._jQueryInterface; };
        return Tooltip;
    }($, Popper);
    var Popover = function($$$1) {
        var NAME = 'popover';
        var VERSION = '4.1.3';
        var DATA_KEY = 'bs.popover';
        var EVENT_KEY = "." + DATA_KEY;
        var JQUERY_NO_CONFLICT = $$$1.fn[NAME];
        var CLASS_PREFIX = 'bs-popover';
        var BSCLS_PREFIX_REGEX = new RegExp("(^|\\s)" + CLASS_PREFIX + "\\S+", 'g');
        var Default = _objectSpread({}, Tooltip.Default, { placement: 'right', trigger: 'click', content: '', template: '<div class="popover" role="tooltip">' + '<div class="arrow"></div>' + '<h3 class="popover-header"></h3>' + '<div class="popover-body"></div></div>' });
        var DefaultType = _objectSpread({}, Tooltip.DefaultType, { content: '(string|element|function)' });
        var ClassName = { FADE: 'fade', SHOW: 'show' };
        var Selector = { TITLE: '.popover-header', CONTENT: '.popover-body' };
        var Event = { HIDE: "hide" + EVENT_KEY, HIDDEN: "hidden" + EVENT_KEY, SHOW: "show" + EVENT_KEY, SHOWN: "shown" + EVENT_KEY, INSERTED: "inserted" + EVENT_KEY, CLICK: "click" + EVENT_KEY, FOCUSIN: "focusin" + EVENT_KEY, FOCUSOUT: "focusout" + EVENT_KEY, MOUSEENTER: "mouseenter" + EVENT_KEY, MOUSELEAVE: "mouseleave" + EVENT_KEY };
        var Popover = function(_Tooltip) {
            _inheritsLoose(Popover, _Tooltip);

            function Popover() { return _Tooltip.apply(this, arguments) || this; }
            var _proto = Popover.prototype;
            _proto.isWithContent = function isWithContent() { return this.getTitle() || this._getContent(); };
            _proto.addAttachmentClass = function addAttachmentClass(attachment) { $$$1(this.getTipElement()).addClass(CLASS_PREFIX + "-" + attachment); };
            _proto.getTipElement = function getTipElement() { this.tip = this.tip || $$$1(this.config.template)[0]; return this.tip; };
            _proto.setContent = function setContent() {
                var $tip = $$$1(this.getTipElement());
                this.setElementContent($tip.find(Selector.TITLE), this.getTitle());
                var content = this._getContent();
                if (typeof content === 'function') { content = content.call(this.element); }
                this.setElementContent($tip.find(Selector.CONTENT), content);
                $tip.removeClass(ClassName.FADE + " " + ClassName.SHOW);
            };
            _proto._getContent = function _getContent() { return this.element.getAttribute('data-content') || this.config.content; };
            _proto._cleanTipClass = function _cleanTipClass() { var $tip = $$$1(this.getTipElement()); var tabClass = $tip.attr('class').match(BSCLS_PREFIX_REGEX); if (tabClass !== null && tabClass.length > 0) { $tip.removeClass(tabClass.join('')); } };
            Popover._jQueryInterface = function _jQueryInterface(config) {
                return this.each(function() {
                    var data = $$$1(this).data(DATA_KEY);
                    var _config = typeof config === 'object' ? config : null;
                    if (!data && /destroy|hide/.test(config)) { return; }
                    if (!data) {
                        data = new Popover(this, _config);
                        $$$1(this).data(DATA_KEY, data);
                    }
                    if (typeof config === 'string') {
                        if (typeof data[config] === 'undefined') { throw new TypeError("No method named \"" + config + "\""); }
                        data[config]();
                    }
                });
            };
            _createClass(Popover, null, [{ key: "VERSION", get: function get() { return VERSION; } }, { key: "Default", get: function get() { return Default; } }, { key: "NAME", get: function get() { return NAME; } }, { key: "DATA_KEY", get: function get() { return DATA_KEY; } }, { key: "Event", get: function get() { return Event; } }, { key: "EVENT_KEY", get: function get() { return EVENT_KEY; } }, { key: "DefaultType", get: function get() { return DefaultType; } }]);
            return Popover;
        }(Tooltip);
        $$$1.fn[NAME] = Popover._jQueryInterface;
        $$$1.fn[NAME].Constructor = Popover;
        $$$1.fn[NAME].noConflict = function() { $$$1.fn[NAME] = JQUERY_NO_CONFLICT; return Popover._jQueryInterface; };
        return Popover;
    }($);
    var ScrollSpy = function($$$1) {
        var NAME = 'scrollspy';
        var VERSION = '4.1.3';
        var DATA_KEY = 'bs.scrollspy';
        var EVENT_KEY = "." + DATA_KEY;
        var DATA_API_KEY = '.data-api';
        var JQUERY_NO_CONFLICT = $$$1.fn[NAME];
        var Default = { offset: 10, method: 'auto', target: '' };
        var DefaultType = { offset: 'number', method: 'string', target: '(string|element)' };
        var Event = { ACTIVATE: "activate" + EVENT_KEY, SCROLL: "scroll" + EVENT_KEY, LOAD_DATA_API: "load" + EVENT_KEY + DATA_API_KEY };
        var ClassName = { DROPDOWN_ITEM: 'dropdown-item', DROPDOWN_MENU: 'dropdown-menu', ACTIVE: 'active' };
        var Selector = { DATA_SPY: '[data-spy="scroll"]', ACTIVE: '.active', NAV_LIST_GROUP: '.nav, .list-group', NAV_LINKS: '.nav-link', NAV_ITEMS: '.nav-item', LIST_ITEMS: '.list-group-item', DROPDOWN: '.dropdown', DROPDOWN_ITEMS: '.dropdown-item', DROPDOWN_TOGGLE: '.dropdown-toggle' };
        var OffsetMethod = { OFFSET: 'offset', POSITION: 'position' };
        var ScrollSpy = function() {
            function ScrollSpy(element, config) {
                var _this = this;
                this._element = element;
                this._scrollElement = element.tagName === 'BODY' ? window : element;
                this._config = this._getConfig(config);
                this._selector = this._config.target + " " + Selector.NAV_LINKS + "," + (this._config.target + " " + Selector.LIST_ITEMS + ",") + (this._config.target + " " + Selector.DROPDOWN_ITEMS);
                this._offsets = [];
                this._targets = [];
                this._activeTarget = null;
                this._scrollHeight = 0;
                $$$1(this._scrollElement).on(Event.SCROLL, function(event) { return _this._process(event); });
                this.refresh();
                this._process();
            }
            var _proto = ScrollSpy.prototype;
            _proto.refresh = function refresh() {
                var _this2 = this;
                var autoMethod = this._scrollElement === this._scrollElement.window ? OffsetMethod.OFFSET : OffsetMethod.POSITION;
                var offsetMethod = this._config.method === 'auto' ? autoMethod : this._config.method;
                var offsetBase = offsetMethod === OffsetMethod.POSITION ? this._getScrollTop() : 0;
                this._offsets = [];
                this._targets = [];
                this._scrollHeight = this._getScrollHeight();
                var targets = [].slice.call(document.querySelectorAll(this._selector));
                targets.map(function(element) {
                    var target;
                    var targetSelector = Util.getSelectorFromElement(element);
                    if (targetSelector) { target = document.querySelector(targetSelector); }
                    if (target) { var targetBCR = target.getBoundingClientRect(); if (targetBCR.width || targetBCR.height) { return [$$$1(target)[offsetMethod]().top + offsetBase, targetSelector]; } }
                    return null;
                }).filter(function(item) { return item; }).sort(function(a, b) { return a[0] - b[0]; }).forEach(function(item) {
                    _this2._offsets.push(item[0]);
                    _this2._targets.push(item[1]);
                });
            };
            _proto.dispose = function dispose() {
                $$$1.removeData(this._element, DATA_KEY);
                $$$1(this._scrollElement).off(EVENT_KEY);
                this._element = null;
                this._scrollElement = null;
                this._config = null;
                this._selector = null;
                this._offsets = null;
                this._targets = null;
                this._activeTarget = null;
                this._scrollHeight = null;
            };
            _proto._getConfig = function _getConfig(config) {
                config = _objectSpread({}, Default, typeof config === 'object' && config ? config : {});
                if (typeof config.target !== 'string') {
                    var id = $$$1(config.target).attr('id');
                    if (!id) {
                        id = Util.getUID(NAME);
                        $$$1(config.target).attr('id', id);
                    }
                    config.target = "#" + id;
                }
                Util.typeCheckConfig(NAME, config, DefaultType);
                return config;
            };
            _proto._getScrollTop = function _getScrollTop() { return this._scrollElement === window ? this._scrollElement.pageYOffset : this._scrollElement.scrollTop; };
            _proto._getScrollHeight = function _getScrollHeight() { return this._scrollElement.scrollHeight || Math.max(document.body.scrollHeight, document.documentElement.scrollHeight); };
            _proto._getOffsetHeight = function _getOffsetHeight() { return this._scrollElement === window ? window.innerHeight : this._scrollElement.getBoundingClientRect().height; };
            _proto._process = function _process() {
                var scrollTop = this._getScrollTop() + this._config.offset;
                var scrollHeight = this._getScrollHeight();
                var maxScroll = this._config.offset + scrollHeight - this._getOffsetHeight();
                if (this._scrollHeight !== scrollHeight) { this.refresh(); }
                if (scrollTop >= maxScroll) {
                    var target = this._targets[this._targets.length - 1];
                    if (this._activeTarget !== target) { this._activate(target); }
                    return;
                }
                if (this._activeTarget && scrollTop < this._offsets[0] && this._offsets[0] > 0) {
                    this._activeTarget = null;
                    this._clear();
                    return;
                }
                var offsetLength = this._offsets.length;
                for (var i = offsetLength; i--;) { var isActiveTarget = this._activeTarget !== this._targets[i] && scrollTop >= this._offsets[i] && (typeof this._offsets[i + 1] === 'undefined' || scrollTop < this._offsets[i + 1]); if (isActiveTarget) { this._activate(this._targets[i]); } }
            };
            _proto._activate = function _activate(target) {
                this._activeTarget = target;
                this._clear();
                var queries = this._selector.split(',');
                queries = queries.map(function(selector) { return selector + "[data-target=\"" + target + "\"]," + (selector + "[href=\"" + target + "\"]"); });
                var $link = $$$1([].slice.call(document.querySelectorAll(queries.join(','))));
                if ($link.hasClass(ClassName.DROPDOWN_ITEM)) {
                    $link.closest(Selector.DROPDOWN).find(Selector.DROPDOWN_TOGGLE).addClass(ClassName.ACTIVE);
                    $link.addClass(ClassName.ACTIVE);
                } else {
                    $link.addClass(ClassName.ACTIVE);
                    $link.parents(Selector.NAV_LIST_GROUP).prev(Selector.NAV_LINKS + ", " + Selector.LIST_ITEMS).addClass(ClassName.ACTIVE);
                    $link.parents(Selector.NAV_LIST_GROUP).prev(Selector.NAV_ITEMS).children(Selector.NAV_LINKS).addClass(ClassName.ACTIVE);
                }
                $$$1(this._scrollElement).trigger(Event.ACTIVATE, { relatedTarget: target });
            };
            _proto._clear = function _clear() {
                var nodes = [].slice.call(document.querySelectorAll(this._selector));
                $$$1(nodes).filter(Selector.ACTIVE).removeClass(ClassName.ACTIVE);
            };
            ScrollSpy._jQueryInterface = function _jQueryInterface(config) {
                return this.each(function() {
                    var data = $$$1(this).data(DATA_KEY);
                    var _config = typeof config === 'object' && config;
                    if (!data) {
                        data = new ScrollSpy(this, _config);
                        $$$1(this).data(DATA_KEY, data);
                    }
                    if (typeof config === 'string') {
                        if (typeof data[config] === 'undefined') { throw new TypeError("No method named \"" + config + "\""); }
                        data[config]();
                    }
                });
            };
            _createClass(ScrollSpy, null, [{ key: "VERSION", get: function get() { return VERSION; } }, { key: "Default", get: function get() { return Default; } }]);
            return ScrollSpy;
        }();
        $$$1(window).on(Event.LOAD_DATA_API, function() {
            var scrollSpys = [].slice.call(document.querySelectorAll(Selector.DATA_SPY));
            var scrollSpysLength = scrollSpys.length;
            for (var i = scrollSpysLength; i--;) {
                var $spy = $$$1(scrollSpys[i]);
                ScrollSpy._jQueryInterface.call($spy, $spy.data());
            }
        });
        $$$1.fn[NAME] = ScrollSpy._jQueryInterface;
        $$$1.fn[NAME].Constructor = ScrollSpy;
        $$$1.fn[NAME].noConflict = function() { $$$1.fn[NAME] = JQUERY_NO_CONFLICT; return ScrollSpy._jQueryInterface; };
        return ScrollSpy;
    }($);
    var Tab = function($$$1) {
        var NAME = 'tab';
        var VERSION = '4.1.3';
        var DATA_KEY = 'bs.tab';
        var EVENT_KEY = "." + DATA_KEY;
        var DATA_API_KEY = '.data-api';
        var JQUERY_NO_CONFLICT = $$$1.fn[NAME];
        var Event = { HIDE: "hide" + EVENT_KEY, HIDDEN: "hidden" + EVENT_KEY, SHOW: "show" + EVENT_KEY, SHOWN: "shown" + EVENT_KEY, CLICK_DATA_API: "click" + EVENT_KEY + DATA_API_KEY };
        var ClassName = { DROPDOWN_MENU: 'dropdown-menu', ACTIVE: 'active', DISABLED: 'disabled', FADE: 'fade', SHOW: 'show' };
        var Selector = { DROPDOWN: '.dropdown', NAV_LIST_GROUP: '.nav, .list-group', ACTIVE: '.active', ACTIVE_UL: '> li > .active', DATA_TOGGLE: '[data-toggle="tab"], [data-toggle="pill"], [data-toggle="list"]', DROPDOWN_TOGGLE: '.dropdown-toggle', DROPDOWN_ACTIVE_CHILD: '> .dropdown-menu .active' };
        var Tab = function() {
            function Tab(element) { this._element = element; }
            var _proto = Tab.prototype;
            _proto.show = function show() {
                var _this = this;
                if (this._element.parentNode && this._element.parentNode.nodeType === Node.ELEMENT_NODE && $$$1(this._element).hasClass(ClassName.ACTIVE) || $$$1(this._element).hasClass(ClassName.DISABLED)) { return; }
                var target;
                var previous;
                var listElement = $$$1(this._element).closest(Selector.NAV_LIST_GROUP)[0];
                var selector = Util.getSelectorFromElement(this._element);
                if (listElement) {
                    var itemSelector = listElement.nodeName === 'UL' ? Selector.ACTIVE_UL : Selector.ACTIVE;
                    previous = $$$1.makeArray($$$1(listElement).find(itemSelector));
                    previous = previous[previous.length - 1];
                }
                var hideEvent = $$$1.Event(Event.HIDE, { relatedTarget: this._element });
                var showEvent = $$$1.Event(Event.SHOW, { relatedTarget: previous });
                if (previous) { $$$1(previous).trigger(hideEvent); }
                $$$1(this._element).trigger(showEvent);
                if (showEvent.isDefaultPrevented() || hideEvent.isDefaultPrevented()) { return; }
                if (selector) { target = document.querySelector(selector); }
                this._activate(this._element, listElement);
                var complete = function complete() {
                    var hiddenEvent = $$$1.Event(Event.HIDDEN, { relatedTarget: _this._element });
                    var shownEvent = $$$1.Event(Event.SHOWN, { relatedTarget: previous });
                    $$$1(previous).trigger(hiddenEvent);
                    $$$1(_this._element).trigger(shownEvent);
                };
                if (target) { this._activate(target, target.parentNode, complete); } else { complete(); }
            };
            _proto.dispose = function dispose() {
                $$$1.removeData(this._element, DATA_KEY);
                this._element = null;
            };
            _proto._activate = function _activate(element, container, callback) {
                var _this2 = this;
                var activeElements;
                if (container.nodeName === 'UL') { activeElements = $$$1(container).find(Selector.ACTIVE_UL); } else { activeElements = $$$1(container).children(Selector.ACTIVE); }
                var active = activeElements[0];
                var isTransitioning = callback && active && $$$1(active).hasClass(ClassName.FADE);
                var complete = function complete() { return _this2._transitionComplete(element, active, callback); };
                if (active && isTransitioning) {
                    var transitionDuration = Util.getTransitionDurationFromElement(active);
                    $$$1(active).one(Util.TRANSITION_END, complete).emulateTransitionEnd(transitionDuration);
                } else { complete(); }
            };
            _proto._transitionComplete = function _transitionComplete(element, active, callback) {
                if (active) {
                    $$$1(active).removeClass(ClassName.SHOW + " " + ClassName.ACTIVE);
                    var dropdownChild = $$$1(active.parentNode).find(Selector.DROPDOWN_ACTIVE_CHILD)[0];
                    if (dropdownChild) { $$$1(dropdownChild).removeClass(ClassName.ACTIVE); }
                    if (active.getAttribute('role') === 'tab') { active.setAttribute('aria-selected', false); }
                }
                $$$1(element).addClass(ClassName.ACTIVE);
                if (element.getAttribute('role') === 'tab') { element.setAttribute('aria-selected', true); }
                Util.reflow(element);
                $$$1(element).addClass(ClassName.SHOW);
                if (element.parentNode && $$$1(element.parentNode).hasClass(ClassName.DROPDOWN_MENU)) {
                    var dropdownElement = $$$1(element).closest(Selector.DROPDOWN)[0];
                    if (dropdownElement) {
                        var dropdownToggleList = [].slice.call(dropdownElement.querySelectorAll(Selector.DROPDOWN_TOGGLE));
                        $$$1(dropdownToggleList).addClass(ClassName.ACTIVE);
                    }
                    element.setAttribute('aria-expanded', true);
                }
                if (callback) { callback(); }
            };
            Tab._jQueryInterface = function _jQueryInterface(config) {
                return this.each(function() {
                    var $this = $$$1(this);
                    var data = $this.data(DATA_KEY);
                    if (!data) {
                        data = new Tab(this);
                        $this.data(DATA_KEY, data);
                    }
                    if (typeof config === 'string') {
                        if (typeof data[config] === 'undefined') { throw new TypeError("No method named \"" + config + "\""); }
                        data[config]();
                    }
                });
            };
            _createClass(Tab, null, [{ key: "VERSION", get: function get() { return VERSION; } }]);
            return Tab;
        }();
        $$$1(document).on(Event.CLICK_DATA_API, Selector.DATA_TOGGLE, function(event) {
            event.preventDefault();
            Tab._jQueryInterface.call($$$1(this), 'show');
        });
        $$$1.fn[NAME] = Tab._jQueryInterface;
        $$$1.fn[NAME].Constructor = Tab;
        $$$1.fn[NAME].noConflict = function() { $$$1.fn[NAME] = JQUERY_NO_CONFLICT; return Tab._jQueryInterface; };
        return Tab;
    }($);
    (function($$$1) {
        if (typeof $$$1 === 'undefined') { throw new TypeError('Bootstrap\'s JavaScript requires jQuery. jQuery must be included before Bootstrap\'s JavaScript.'); }
        var version = $$$1.fn.jquery.split(' ')[0].split('.');
        var minMajor = 1;
        var ltMajor = 2;
        var minMinor = 9;
        var minPatch = 1;
        var maxMajor = 4;
        if (version[0] < ltMajor && version[1] < minMinor || version[0] === minMajor && version[1] === minMinor && version[2] < minPatch || version[0] >= maxMajor) { throw new Error('Bootstrap\'s JavaScript requires at least jQuery v1.9.1 but less than v4.0.0'); }
    })($);
    exports.Util = Util;
    exports.Alert = Alert;
    exports.Button = Button;
    exports.Carousel = Carousel;
    exports.Collapse = Collapse;
    exports.Dropdown = Dropdown;
    exports.Modal = Modal;
    exports.Popover = Popover;
    exports.Scrollspy = ScrollSpy;
    exports.Tab = Tab;
    exports.Tooltip = Tooltip;
    Object.defineProperty(exports, '__esModule', { value: true });
})));;
(function(factory) { 'use strict'; if (typeof define === 'function' && define.amd) { define(['jquery'], factory); } else if (typeof exports !== 'undefined') { module.exports = factory(require('jquery')); } else { factory(jQuery); } }(function($) {
    'use strict';
    var Slick = window.Slick || {};
    Slick = (function() {
        var instanceUid = 0;

        function Slick(element, settings) {
            var _ = this,
                dataSettings;
            _.defaults = { accessibility: true, adaptiveHeight: false, appendArrows: $(element), appendDots: $(element), arrows: true, asNavFor: null, prevArrow: '<button class="slick-prev" aria-label="Previous" type="button">Previous</button>', nextArrow: '<button class="slick-next" aria-label="Next" type="button">Next</button>', autoplay: false, autoplaySpeed: 3000, centerMode: false, centerPadding: '50px', cssEase: 'ease', customPaging: function(slider, i) { return $('<button type="button" />').text(i + 1); }, dots: false, dotsClass: 'slick-dots', draggable: true, easing: 'linear', edgeFriction: 0.35, fade: false, focusOnSelect: false, focusOnChange: false, infinite: true, initialSlide: 0, lazyLoad: 'ondemand', mobileFirst: false, pauseOnHover: true, pauseOnFocus: true, pauseOnDotsHover: false, respondTo: 'window', responsive: null, rows: 1, rtl: false, slide: '', slidesPerRow: 1, slidesToShow: 1, slidesToScroll: 1, speed: 500, swipe: true, swipeToSlide: false, touchMove: true, touchThreshold: 5, useCSS: true, useTransform: true, variableWidth: false, vertical: false, verticalSwiping: false, waitForAnimate: true, zIndex: 1000 };
            _.initials = { animating: false, dragging: false, autoPlayTimer: null, currentDirection: 0, currentLeft: null, currentSlide: 0, direction: 1, $dots: null, listWidth: null, listHeight: null, loadIndex: 0, $nextArrow: null, $prevArrow: null, scrolling: false, slideCount: null, slideWidth: null, $slideTrack: null, $slides: null, sliding: false, slideOffset: 0, swipeLeft: null, swiping: false, $list: null, touchObject: {}, transformsEnabled: false, unslicked: false };
            $.extend(_, _.initials);
            _.activeBreakpoint = null;
            _.animType = null;
            _.animProp = null;
            _.breakpoints = [];
            _.breakpointSettings = [];
            _.cssTransitions = false;
            _.focussed = false;
            _.interrupted = false;
            _.hidden = 'hidden';
            _.paused = true;
            _.positionProp = null;
            _.respondTo = null;
            _.rowCount = 1;
            _.shouldClick = true;
            _.$slider = $(element);
            _.$slidesCache = null;
            _.transformType = null;
            _.transitionType = null;
            _.visibilityChange = 'visibilitychange';
            _.windowWidth = 0;
            _.windowTimer = null;
            dataSettings = $(element).data('slick') || {};
            _.options = $.extend({}, _.defaults, settings, dataSettings);
            _.currentSlide = _.options.initialSlide;
            _.originalSettings = _.options;
            if (typeof document.mozHidden !== 'undefined') {
                _.hidden = 'mozHidden';
                _.visibilityChange = 'mozvisibilitychange';
            } else if (typeof document.webkitHidden !== 'undefined') {
                _.hidden = 'webkitHidden';
                _.visibilityChange = 'webkitvisibilitychange';
            }
            _.autoPlay = $.proxy(_.autoPlay, _);
            _.autoPlayClear = $.proxy(_.autoPlayClear, _);
            _.autoPlayIterator = $.proxy(_.autoPlayIterator, _);
            _.changeSlide = $.proxy(_.changeSlide, _);
            _.clickHandler = $.proxy(_.clickHandler, _);
            _.selectHandler = $.proxy(_.selectHandler, _);
            _.setPosition = $.proxy(_.setPosition, _);
            _.swipeHandler = $.proxy(_.swipeHandler, _);
            _.dragHandler = $.proxy(_.dragHandler, _);
            _.keyHandler = $.proxy(_.keyHandler, _);
            _.instanceUid = instanceUid++;
            _.htmlExpr = /^(?:\s*(<[\w\W]+>)[^>]*)$/;
            _.registerBreakpoints();
            _.init(true);
        }
        return Slick;
    }());
    Slick.prototype.activateADA = function() {
        var _ = this;
        _.$slideTrack.find('.slick-active').attr({ 'aria-hidden': 'false' }).find('a, input, button, select').attr({ 'tabindex': '0' });
    };
    Slick.prototype.addSlide = Slick.prototype.slickAdd = function(markup, index, addBefore) {
        var _ = this;
        if (typeof(index) === 'boolean') {
            addBefore = index;
            index = null;
        } else if (index < 0 || (index >= _.slideCount)) { return false; }
        _.unload();
        if (typeof(index) === 'number') { if (index === 0 && _.$slides.length === 0) { $(markup).appendTo(_.$slideTrack); } else if (addBefore) { $(markup).insertBefore(_.$slides.eq(index)); } else { $(markup).insertAfter(_.$slides.eq(index)); } } else { if (addBefore === true) { $(markup).prependTo(_.$slideTrack); } else { $(markup).appendTo(_.$slideTrack); } }
        _.$slides = _.$slideTrack.children(this.options.slide);
        _.$slideTrack.children(this.options.slide).detach();
        _.$slideTrack.append(_.$slides);
        _.$slides.each(function(index, element) { $(element).attr('data-slick-index', index); });
        _.$slidesCache = _.$slides;
        _.reinit();
    };
    Slick.prototype.animateHeight = function() {
        var _ = this;
        if (_.options.slidesToShow === 1 && _.options.adaptiveHeight === true && _.options.vertical === false) {
            var targetHeight = _.$slides.eq(_.currentSlide).outerHeight(true);
            _.$list.animate({ height: targetHeight }, _.options.speed);
        }
    };
    Slick.prototype.animateSlide = function(targetLeft, callback) {
        var animProps = {},
            _ = this;
        _.animateHeight();
        if (_.options.rtl === true && _.options.vertical === false) { targetLeft = -targetLeft; }
        if (_.transformsEnabled === false) { if (_.options.vertical === false) { _.$slideTrack.animate({ left: targetLeft }, _.options.speed, _.options.easing, callback); } else { _.$slideTrack.animate({ top: targetLeft }, _.options.speed, _.options.easing, callback); } } else {
            if (_.cssTransitions === false) {
                if (_.options.rtl === true) { _.currentLeft = -(_.currentLeft); }
                $({ animStart: _.currentLeft }).animate({ animStart: targetLeft }, {
                    duration: _.options.speed,
                    easing: _.options.easing,
                    step: function(now) {
                        now = Math.ceil(now);
                        if (_.options.vertical === false) {
                            animProps[_.animType] = 'translate(' +
                                now + 'px, 0px)';
                            _.$slideTrack.css(animProps);
                        } else {
                            animProps[_.animType] = 'translate(0px,' +
                                now + 'px)';
                            _.$slideTrack.css(animProps);
                        }
                    },
                    complete: function() { if (callback) { callback.call(); } }
                });
            } else {
                _.applyTransition();
                targetLeft = Math.ceil(targetLeft);
                if (_.options.vertical === false) { animProps[_.animType] = 'translate3d(' + targetLeft + 'px, 0px, 0px)'; } else { animProps[_.animType] = 'translate3d(0px,' + targetLeft + 'px, 0px)'; }
                _.$slideTrack.css(animProps);
                if (callback) {
                    setTimeout(function() {
                        _.disableTransition();
                        callback.call();
                    }, _.options.speed);
                }
            }
        }
    };
    Slick.prototype.getNavTarget = function() {
        var _ = this,
            asNavFor = _.options.asNavFor;
        if (asNavFor && asNavFor !== null) { asNavFor = $(asNavFor).not(_.$slider); }
        return asNavFor;
    };
    Slick.prototype.asNavFor = function(index) {
        var _ = this,
            asNavFor = _.getNavTarget();
        if (asNavFor !== null && typeof asNavFor === 'object') { asNavFor.each(function() { var target = $(this).slick('getSlick'); if (!target.unslicked) { target.slideHandler(index, true); } }); }
    };
    Slick.prototype.applyTransition = function(slide) {
        var _ = this,
            transition = {};
        if (_.options.fade === false) { transition[_.transitionType] = _.transformType + ' ' + _.options.speed + 'ms ' + _.options.cssEase; } else { transition[_.transitionType] = 'opacity ' + _.options.speed + 'ms ' + _.options.cssEase; }
        if (_.options.fade === false) { _.$slideTrack.css(transition); } else { _.$slides.eq(slide).css(transition); }
    };
    Slick.prototype.autoPlay = function() {
        var _ = this;
        _.autoPlayClear();
        if (_.slideCount > _.options.slidesToShow) { _.autoPlayTimer = setInterval(_.autoPlayIterator, _.options.autoplaySpeed); }
    };
    Slick.prototype.autoPlayClear = function() { var _ = this; if (_.autoPlayTimer) { clearInterval(_.autoPlayTimer); } };
    Slick.prototype.autoPlayIterator = function() {
        var _ = this,
            slideTo = _.currentSlide + _.options.slidesToScroll;
        if (!_.paused && !_.interrupted && !_.focussed) {
            if (_.options.infinite === false) {
                if (_.direction === 1 && (_.currentSlide + 1) === (_.slideCount - 1)) { _.direction = 0; } else if (_.direction === 0) { slideTo = _.currentSlide - _.options.slidesToScroll; if (_.currentSlide - 1 === 0) { _.direction = 1; } }
            }
            _.slideHandler(slideTo);
        }
    };
    Slick.prototype.buildArrows = function() {
        var _ = this;
        if (_.options.arrows === true) {
            _.$prevArrow = $(_.options.prevArrow).addClass('slick-arrow');
            _.$nextArrow = $(_.options.nextArrow).addClass('slick-arrow');
            if (_.slideCount > _.options.slidesToShow) {
                _.$prevArrow.removeClass('slick-hidden').removeAttr('aria-hidden tabindex');
                _.$nextArrow.removeClass('slick-hidden').removeAttr('aria-hidden tabindex');
                if (_.htmlExpr.test(_.options.prevArrow)) { _.$prevArrow.prependTo(_.options.appendArrows); }
                if (_.htmlExpr.test(_.options.nextArrow)) { _.$nextArrow.appendTo(_.options.appendArrows); }
                if (_.options.infinite !== true) { _.$prevArrow.addClass('slick-disabled').attr('aria-disabled', 'true'); }
            } else { _.$prevArrow.add(_.$nextArrow).addClass('slick-hidden').attr({ 'aria-disabled': 'true', 'tabindex': '-1' }); }
        }
    };
    Slick.prototype.buildDots = function() {
        var _ = this,
            i, dot;
        if (_.options.dots === true && _.slideCount > _.options.slidesToShow) {
            _.$slider.addClass('slick-dotted');
            dot = $('<ul />').addClass(_.options.dotsClass);
            for (i = 0; i <= _.getDotCount(); i += 1) { dot.append($('<li />').append(_.options.customPaging.call(this, _, i))); }
            _.$dots = dot.appendTo(_.options.appendDots);
            _.$dots.find('li').first().addClass('slick-active');
        }
    };
    Slick.prototype.buildOut = function() {
        var _ = this;
        _.$slides = _.$slider.children(_.options.slide + ':not(.slick-cloned)').addClass('slick-slide');
        _.slideCount = _.$slides.length;
        _.$slides.each(function(index, element) { $(element).attr('data-slick-index', index).data('originalStyling', $(element).attr('style') || ''); });
        _.$slider.addClass('slick-slider');
        _.$slideTrack = (_.slideCount === 0) ? $('<div class="slick-track"/>').appendTo(_.$slider) : _.$slides.wrapAll('<div class="slick-track"/>').parent();
        _.$list = _.$slideTrack.wrap('<div class="slick-list"/>').parent();
        _.$slideTrack.css('opacity', 0);
        if (_.options.centerMode === true || _.options.swipeToSlide === true) { _.options.slidesToScroll = 1; }
        $('img[data-lazy]', _.$slider).not('[src]').addClass('slick-loading');
        _.setupInfinite();
        _.buildArrows();
        _.buildDots();
        _.updateDots();
        _.setSlideClasses(typeof _.currentSlide === 'number' ? _.currentSlide : 0);
        if (_.options.draggable === true) { _.$list.addClass('draggable'); }
    };
    Slick.prototype.buildRows = function() {
        var _ = this,
            a, b, c, newSlides, numOfSlides, originalSlides, slidesPerSection;
        newSlides = document.createDocumentFragment();
        originalSlides = _.$slider.children();
        if (_.options.rows > 0) {
            slidesPerSection = _.options.slidesPerRow * _.options.rows;
            numOfSlides = Math.ceil(originalSlides.length / slidesPerSection);
            for (a = 0; a < numOfSlides; a++) {
                var slide = document.createElement('div');
                for (b = 0; b < _.options.rows; b++) {
                    var row = document.createElement('div');
                    for (c = 0; c < _.options.slidesPerRow; c++) { var target = (a * slidesPerSection + ((b * _.options.slidesPerRow) + c)); if (originalSlides.get(target)) { row.appendChild(originalSlides.get(target)); } }
                    slide.appendChild(row);
                }
                newSlides.appendChild(slide);
            }
            _.$slider.empty().append(newSlides);
            _.$slider.children().children().children().css({ 'width': (100 / _.options.slidesPerRow) + '%', 'display': 'inline-block' });
        }
    };
    Slick.prototype.checkResponsive = function(initial, forceUpdate) {
        var _ = this,
            breakpoint, targetBreakpoint, respondToWidth, triggerBreakpoint = false;
        var sliderWidth = _.$slider.width();
        var windowWidth = window.innerWidth || $(window).width();
        if (_.respondTo === 'window') { respondToWidth = windowWidth; } else if (_.respondTo === 'slider') { respondToWidth = sliderWidth; } else if (_.respondTo === 'min') { respondToWidth = Math.min(windowWidth, sliderWidth); }
        if (_.options.responsive && _.options.responsive.length && _.options.responsive !== null) {
            targetBreakpoint = null;
            for (breakpoint in _.breakpoints) { if (_.breakpoints.hasOwnProperty(breakpoint)) { if (_.originalSettings.mobileFirst === false) { if (respondToWidth < _.breakpoints[breakpoint]) { targetBreakpoint = _.breakpoints[breakpoint]; } } else { if (respondToWidth > _.breakpoints[breakpoint]) { targetBreakpoint = _.breakpoints[breakpoint]; } } } }
            if (targetBreakpoint !== null) {
                if (_.activeBreakpoint !== null) {
                    if (targetBreakpoint !== _.activeBreakpoint || forceUpdate) {
                        _.activeBreakpoint = targetBreakpoint;
                        if (_.breakpointSettings[targetBreakpoint] === 'unslick') { _.unslick(targetBreakpoint); } else {
                            _.options = $.extend({}, _.originalSettings, _.breakpointSettings[targetBreakpoint]);
                            if (initial === true) { _.currentSlide = _.options.initialSlide; }
                            _.refresh(initial);
                        }
                        triggerBreakpoint = targetBreakpoint;
                    }
                } else {
                    _.activeBreakpoint = targetBreakpoint;
                    if (_.breakpointSettings[targetBreakpoint] === 'unslick') { _.unslick(targetBreakpoint); } else {
                        _.options = $.extend({}, _.originalSettings, _.breakpointSettings[targetBreakpoint]);
                        if (initial === true) { _.currentSlide = _.options.initialSlide; }
                        _.refresh(initial);
                    }
                    triggerBreakpoint = targetBreakpoint;
                }
            } else {
                if (_.activeBreakpoint !== null) {
                    _.activeBreakpoint = null;
                    _.options = _.originalSettings;
                    if (initial === true) { _.currentSlide = _.options.initialSlide; }
                    _.refresh(initial);
                    triggerBreakpoint = targetBreakpoint;
                }
            }
            if (!initial && triggerBreakpoint !== false) { _.$slider.trigger('breakpoint', [_, triggerBreakpoint]); }
        }
    };
    Slick.prototype.changeSlide = function(event, dontAnimate) {
        var _ = this,
            $target = $(event.currentTarget),
            indexOffset, slideOffset, unevenOffset;
        if ($target.is('a')) { event.preventDefault(); }
        if (!$target.is('li')) { $target = $target.closest('li'); }
        unevenOffset = (_.slideCount % _.options.slidesToScroll !== 0);
        indexOffset = unevenOffset ? 0 : (_.slideCount - _.currentSlide) % _.options.slidesToScroll;
        switch (event.data.message) {
            case 'previous':
                slideOffset = indexOffset === 0 ? _.options.slidesToScroll : _.options.slidesToShow - indexOffset;
                if (_.slideCount > _.options.slidesToShow) { _.slideHandler(_.currentSlide - slideOffset, false, dontAnimate); }
                break;
            case 'next':
                slideOffset = indexOffset === 0 ? _.options.slidesToScroll : indexOffset;
                if (_.slideCount > _.options.slidesToShow) { _.slideHandler(_.currentSlide + slideOffset, false, dontAnimate); }
                break;
            case 'index':
                var index = event.data.index === 0 ? 0 : event.data.index || $target.index() * _.options.slidesToScroll;
                _.slideHandler(_.checkNavigable(index), false, dontAnimate);
                $target.children().trigger('focus');
                break;
            default:
                return;
        }
    };
    Slick.prototype.checkNavigable = function(index) {
        var _ = this,
            navigables, prevNavigable;
        navigables = _.getNavigableIndexes();
        prevNavigable = 0;
        if (index > navigables[navigables.length - 1]) { index = navigables[navigables.length - 1]; } else {
            for (var n in navigables) {
                if (index < navigables[n]) { index = prevNavigable; break; }
                prevNavigable = navigables[n];
            }
        }
        return index;
    };
    Slick.prototype.cleanUpEvents = function() {
        var _ = this;
        if (_.options.dots && _.$dots !== null) { $('li', _.$dots).off('click.slick', _.changeSlide).off('mouseenter.slick', $.proxy(_.interrupt, _, true)).off('mouseleave.slick', $.proxy(_.interrupt, _, false)); if (_.options.accessibility === true) { _.$dots.off('keydown.slick', _.keyHandler); } }
        _.$slider.off('focus.slick blur.slick');
        if (_.options.arrows === true && _.slideCount > _.options.slidesToShow) {
            _.$prevArrow && _.$prevArrow.off('click.slick', _.changeSlide);
            _.$nextArrow && _.$nextArrow.off('click.slick', _.changeSlide);
            if (_.options.accessibility === true) {
                _.$prevArrow && _.$prevArrow.off('keydown.slick', _.keyHandler);
                _.$nextArrow && _.$nextArrow.off('keydown.slick', _.keyHandler);
            }
        }
        _.$list.off('touchstart.slick mousedown.slick', _.swipeHandler);
        _.$list.off('touchmove.slick mousemove.slick', _.swipeHandler);
        _.$list.off('touchend.slick mouseup.slick', _.swipeHandler);
        _.$list.off('touchcancel.slick mouseleave.slick', _.swipeHandler);
        _.$list.off('click.slick', _.clickHandler);
        $(document).off(_.visibilityChange, _.visibility);
        _.cleanUpSlideEvents();
        if (_.options.accessibility === true) { _.$list.off('keydown.slick', _.keyHandler); }
        if (_.options.focusOnSelect === true) { $(_.$slideTrack).children().off('click.slick', _.selectHandler); }
        $(window).off('orientationchange.slick.slick-' + _.instanceUid, _.orientationChange);
        $(window).off('resize.slick.slick-' + _.instanceUid, _.resize);
        $('[draggable!=true]', _.$slideTrack).off('dragstart', _.preventDefault);
        $(window).off('load.slick.slick-' + _.instanceUid, _.setPosition);
    };
    Slick.prototype.cleanUpSlideEvents = function() {
        var _ = this;
        _.$list.off('mouseenter.slick', $.proxy(_.interrupt, _, true));
        _.$list.off('mouseleave.slick', $.proxy(_.interrupt, _, false));
    };
    Slick.prototype.cleanUpRows = function() {
        var _ = this,
            originalSlides;
        if (_.options.rows > 0) {
            originalSlides = _.$slides.children().children();
            originalSlides.removeAttr('style');
            _.$slider.empty().append(originalSlides);
        }
    };
    Slick.prototype.clickHandler = function(event) {
        var _ = this;
        if (_.shouldClick === false) {
            event.stopImmediatePropagation();
            event.stopPropagation();
            event.preventDefault();
        }
    };
    Slick.prototype.destroy = function(refresh) {
        var _ = this;
        _.autoPlayClear();
        _.touchObject = {};
        _.cleanUpEvents();
        $('.slick-cloned', _.$slider).detach();
        if (_.$dots) { _.$dots.remove(); }
        if (_.$prevArrow && _.$prevArrow.length) { _.$prevArrow.removeClass('slick-disabled slick-arrow slick-hidden').removeAttr('aria-hidden aria-disabled tabindex').css('display', ''); if (_.htmlExpr.test(_.options.prevArrow)) { _.$prevArrow.remove(); } }
        if (_.$nextArrow && _.$nextArrow.length) { _.$nextArrow.removeClass('slick-disabled slick-arrow slick-hidden').removeAttr('aria-hidden aria-disabled tabindex').css('display', ''); if (_.htmlExpr.test(_.options.nextArrow)) { _.$nextArrow.remove(); } }
        if (_.$slides) {
            _.$slides.removeClass('slick-slide slick-active slick-center slick-visible slick-current').removeAttr('aria-hidden').removeAttr('data-slick-index').each(function() { $(this).attr('style', $(this).data('originalStyling')); });
            _.$slideTrack.children(this.options.slide).detach();
            _.$slideTrack.detach();
            _.$list.detach();
            _.$slider.append(_.$slides);
        }
        _.cleanUpRows();
        _.$slider.removeClass('slick-slider');
        _.$slider.removeClass('slick-initialized');
        _.$slider.removeClass('slick-dotted');
        _.unslicked = true;
        if (!refresh) { _.$slider.trigger('destroy', [_]); }
    };
    Slick.prototype.disableTransition = function(slide) {
        var _ = this,
            transition = {};
        transition[_.transitionType] = '';
        if (_.options.fade === false) { _.$slideTrack.css(transition); } else { _.$slides.eq(slide).css(transition); }
    };
    Slick.prototype.fadeSlide = function(slideIndex, callback) {
        var _ = this;
        if (_.cssTransitions === false) {
            _.$slides.eq(slideIndex).css({ zIndex: _.options.zIndex });
            _.$slides.eq(slideIndex).animate({ opacity: 1 }, _.options.speed, _.options.easing, callback);
        } else {
            _.applyTransition(slideIndex);
            _.$slides.eq(slideIndex).css({ opacity: 1, zIndex: _.options.zIndex });
            if (callback) {
                setTimeout(function() {
                    _.disableTransition(slideIndex);
                    callback.call();
                }, _.options.speed);
            }
        }
    };
    Slick.prototype.fadeSlideOut = function(slideIndex) {
        var _ = this;
        if (_.cssTransitions === false) { _.$slides.eq(slideIndex).animate({ opacity: 0, zIndex: _.options.zIndex - 2 }, _.options.speed, _.options.easing); } else {
            _.applyTransition(slideIndex);
            _.$slides.eq(slideIndex).css({ opacity: 0, zIndex: _.options.zIndex - 2 });
        }
    };
    Slick.prototype.filterSlides = Slick.prototype.slickFilter = function(filter) {
        var _ = this;
        if (filter !== null) {
            _.$slidesCache = _.$slides;
            _.unload();
            _.$slideTrack.children(this.options.slide).detach();
            _.$slidesCache.filter(filter).appendTo(_.$slideTrack);
            _.reinit();
        }
    };
    Slick.prototype.focusHandler = function() {
        var _ = this;
        _.$slider.off('focus.slick blur.slick').on('focus.slick', '*', function(event) {
            var $sf = $(this);
            setTimeout(function() {
                if (_.options.pauseOnFocus) {
                    if ($sf.is(':focus')) {
                        _.focussed = true;
                        _.autoPlay();
                    }
                }
            }, 0);
        }).on('blur.slick', '*', function(event) {
            var $sf = $(this);
            if (_.options.pauseOnFocus) {
                _.focussed = false;
                _.autoPlay();
            }
        });
    };
    Slick.prototype.getCurrent = Slick.prototype.slickCurrentSlide = function() { var _ = this; return _.currentSlide; };
    Slick.prototype.getDotCount = function() {
        var _ = this;
        var breakPoint = 0;
        var counter = 0;
        var pagerQty = 0;
        if (_.options.infinite === true) {
            if (_.slideCount <= _.options.slidesToShow) {++pagerQty; } else {
                while (breakPoint < _.slideCount) {
                    ++pagerQty;
                    breakPoint = counter + _.options.slidesToScroll;
                    counter += _.options.slidesToScroll <= _.options.slidesToShow ? _.options.slidesToScroll : _.options.slidesToShow;
                }
            }
        } else if (_.options.centerMode === true) { pagerQty = _.slideCount; } else if (!_.options.asNavFor) { pagerQty = 1 + Math.ceil((_.slideCount - _.options.slidesToShow) / _.options.slidesToScroll); } else {
            while (breakPoint < _.slideCount) {
                ++pagerQty;
                breakPoint = counter + _.options.slidesToScroll;
                counter += _.options.slidesToScroll <= _.options.slidesToShow ? _.options.slidesToScroll : _.options.slidesToShow;
            }
        }
        return pagerQty - 1;
    };
    Slick.prototype.getLeft = function(slideIndex) {
        var _ = this,
            targetLeft, verticalHeight, verticalOffset = 0,
            targetSlide, coef;
        _.slideOffset = 0;
        verticalHeight = _.$slides.first().outerHeight(true);
        if (_.options.infinite === true) {
            if (_.slideCount > _.options.slidesToShow) {
                _.slideOffset = (_.slideWidth * _.options.slidesToShow) * -1;
                coef = -1
                if (_.options.vertical === true && _.options.centerMode === true) { if (_.options.slidesToShow === 2) { coef = -1.5; } else if (_.options.slidesToShow === 1) { coef = -2 } }
                verticalOffset = (verticalHeight * _.options.slidesToShow) * coef;
            }
            if (_.slideCount % _.options.slidesToScroll !== 0) {
                if (slideIndex + _.options.slidesToScroll > _.slideCount && _.slideCount > _.options.slidesToShow) {
                    if (slideIndex > _.slideCount) {
                        _.slideOffset = ((_.options.slidesToShow - (slideIndex - _.slideCount)) * _.slideWidth) * -1;
                        verticalOffset = ((_.options.slidesToShow - (slideIndex - _.slideCount)) * verticalHeight) * -1;
                    } else {
                        _.slideOffset = ((_.slideCount % _.options.slidesToScroll) * _.slideWidth) * -1;
                        verticalOffset = ((_.slideCount % _.options.slidesToScroll) * verticalHeight) * -1;
                    }
                }
            }
        } else {
            if (slideIndex + _.options.slidesToShow > _.slideCount) {
                _.slideOffset = ((slideIndex + _.options.slidesToShow) - _.slideCount) * _.slideWidth;
                verticalOffset = ((slideIndex + _.options.slidesToShow) - _.slideCount) * verticalHeight;
            }
        }
        if (_.slideCount <= _.options.slidesToShow) {
            _.slideOffset = 0;
            verticalOffset = 0;
        }
        if (_.options.centerMode === true && _.slideCount <= _.options.slidesToShow) { _.slideOffset = ((_.slideWidth * Math.floor(_.options.slidesToShow)) / 2) - ((_.slideWidth * _.slideCount) / 2); } else if (_.options.centerMode === true && _.options.infinite === true) { _.slideOffset += _.slideWidth * Math.floor(_.options.slidesToShow / 2) - _.slideWidth; } else if (_.options.centerMode === true) {
            _.slideOffset = 0;
            _.slideOffset += _.slideWidth * Math.floor(_.options.slidesToShow / 2);
        }
        if (_.options.vertical === false) { targetLeft = ((slideIndex * _.slideWidth) * -1) + _.slideOffset; } else { targetLeft = ((slideIndex * verticalHeight) * -1) + verticalOffset; }
        if (_.options.variableWidth === true) {
            if (_.slideCount <= _.options.slidesToShow || _.options.infinite === false) { targetSlide = _.$slideTrack.children('.slick-slide').eq(slideIndex); } else { targetSlide = _.$slideTrack.children('.slick-slide').eq(slideIndex + _.options.slidesToShow); }
            if (_.options.rtl === true) { if (targetSlide[0]) { targetLeft = (_.$slideTrack.width() - targetSlide[0].offsetLeft - targetSlide.width()) * -1; } else { targetLeft = 0; } } else { targetLeft = targetSlide[0] ? targetSlide[0].offsetLeft * -1 : 0; }
            if (_.options.centerMode === true) {
                if (_.slideCount <= _.options.slidesToShow || _.options.infinite === false) { targetSlide = _.$slideTrack.children('.slick-slide').eq(slideIndex); } else { targetSlide = _.$slideTrack.children('.slick-slide').eq(slideIndex + _.options.slidesToShow + 1); }
                if (_.options.rtl === true) { if (targetSlide[0]) { targetLeft = (_.$slideTrack.width() - targetSlide[0].offsetLeft - targetSlide.width()) * -1; } else { targetLeft = 0; } } else { targetLeft = targetSlide[0] ? targetSlide[0].offsetLeft * -1 : 0; }
                targetLeft += (_.$list.width() - targetSlide.outerWidth()) / 2;
            }
        }
        return targetLeft;
    };
    Slick.prototype.getOption = Slick.prototype.slickGetOption = function(option) { var _ = this; return _.options[option]; };
    Slick.prototype.getNavigableIndexes = function() {
        var _ = this,
            breakPoint = 0,
            counter = 0,
            indexes = [],
            max;
        if (_.options.infinite === false) { max = _.slideCount; } else {
            breakPoint = _.options.slidesToScroll * -1;
            counter = _.options.slidesToScroll * -1;
            max = _.slideCount * 2;
        }
        while (breakPoint < max) {
            indexes.push(breakPoint);
            breakPoint = counter + _.options.slidesToScroll;
            counter += _.options.slidesToScroll <= _.options.slidesToShow ? _.options.slidesToScroll : _.options.slidesToShow;
        }
        return indexes;
    };
    Slick.prototype.getSlick = function() { return this; };
    Slick.prototype.getSlideCount = function() {
        var _ = this,
            slidesTraversed, swipedSlide, swipeTarget, centerOffset;
        centerOffset = _.options.centerMode === true ? Math.floor(_.$list.width() / 2) : 0;
        swipeTarget = (_.swipeLeft * -1) + centerOffset;
        if (_.options.swipeToSlide === true) {
            _.$slideTrack.find('.slick-slide').each(function(index, slide) {
                var slideOuterWidth, slideOffset, slideRightBoundary;
                slideOuterWidth = $(slide).outerWidth();
                slideOffset = slide.offsetLeft;
                if (_.options.centerMode !== true) { slideOffset += (slideOuterWidth / 2); }
                slideRightBoundary = slideOffset + (slideOuterWidth);
                if (swipeTarget < slideRightBoundary) { swipedSlide = slide; return false; }
            });
            slidesTraversed = Math.abs($(swipedSlide).attr('data-slick-index') - _.currentSlide) || 1;
            return slidesTraversed;
        } else { return _.options.slidesToScroll; }
    };
    Slick.prototype.goTo = Slick.prototype.slickGoTo = function(slide, dontAnimate) {
        var _ = this;
        _.changeSlide({ data: { message: 'index', index: parseInt(slide) } }, dontAnimate);
    };
    Slick.prototype.init = function(creation) {
        var _ = this;
        if (!$(_.$slider).hasClass('slick-initialized')) {
            $(_.$slider).addClass('slick-initialized');
            _.buildRows();
            _.buildOut();
            _.setProps();
            _.startLoad();
            _.loadSlider();
            _.initializeEvents();
            _.updateArrows();
            _.updateDots();
            _.checkResponsive(true);
            _.focusHandler();
        }
        if (creation) { _.$slider.trigger('init', [_]); }
        if (_.options.accessibility === true) { _.initADA(); }
        if (_.options.autoplay) {
            _.paused = false;
            _.autoPlay();
        }
    };
    Slick.prototype.initADA = function() {
        var _ = this,
            numDotGroups = Math.ceil(_.slideCount / _.options.slidesToShow),
            tabControlIndexes = _.getNavigableIndexes().filter(function(val) { return (val >= 0) && (val < _.slideCount); });
        _.$slides.add(_.$slideTrack.find('.slick-cloned')).attr({ 'aria-hidden': 'true', 'tabindex': '-1' }).find('a, input, button, select').attr({ 'tabindex': '-1' });
        if (_.$dots !== null) {
            _.$slides.not(_.$slideTrack.find('.slick-cloned')).each(function(i) {
                var slideControlIndex = tabControlIndexes.indexOf(i);
                $(this).attr({ 'role': 'tabpanel', 'id': 'slick-slide' + _.instanceUid + i, 'tabindex': -1 });
                if (slideControlIndex !== -1) {
                    var ariaButtonControl = 'slick-slide-control' + _.instanceUid + slideControlIndex
                    if ($('#' + ariaButtonControl).length) { $(this).attr({ 'aria-describedby': ariaButtonControl }); }
                }
            });
            _.$dots.attr('role', 'tablist').find('li').each(function(i) {
                var mappedSlideIndex = tabControlIndexes[i];
                $(this).attr({ 'role': 'presentation' });
                $(this).find('button').first().attr({ 'role': 'tab', 'id': 'slick-slide-control' + _.instanceUid + i, 'aria-controls': 'slick-slide' + _.instanceUid + mappedSlideIndex, 'aria-label': (i + 1) + ' of ' + numDotGroups, 'aria-selected': null, 'tabindex': '-1' });
            }).eq(_.currentSlide).find('button').attr({ 'aria-selected': 'true', 'tabindex': '0' }).end();
        }
        for (var i = _.currentSlide, max = i + _.options.slidesToShow; i < max; i++) { if (_.options.focusOnChange) { _.$slides.eq(i).attr({ 'tabindex': '0' }); } else { _.$slides.eq(i).removeAttr('tabindex'); } }
        _.activateADA();
    };
    Slick.prototype.initArrowEvents = function() {
        var _ = this;
        if (_.options.arrows === true && _.slideCount > _.options.slidesToShow) {
            _.$prevArrow.off('click.slick').on('click.slick', { message: 'previous' }, _.changeSlide);
            _.$nextArrow.off('click.slick').on('click.slick', { message: 'next' }, _.changeSlide);
            if (_.options.accessibility === true) {
                _.$prevArrow.on('keydown.slick', _.keyHandler);
                _.$nextArrow.on('keydown.slick', _.keyHandler);
            }
        }
    };
    Slick.prototype.initDotEvents = function() {
        var _ = this;
        if (_.options.dots === true && _.slideCount > _.options.slidesToShow) { $('li', _.$dots).on('click.slick', { message: 'index' }, _.changeSlide); if (_.options.accessibility === true) { _.$dots.on('keydown.slick', _.keyHandler); } }
        if (_.options.dots === true && _.options.pauseOnDotsHover === true && _.slideCount > _.options.slidesToShow) { $('li', _.$dots).on('mouseenter.slick', $.proxy(_.interrupt, _, true)).on('mouseleave.slick', $.proxy(_.interrupt, _, false)); }
    };
    Slick.prototype.initSlideEvents = function() {
        var _ = this;
        if (_.options.pauseOnHover) {
            _.$list.on('mouseenter.slick', $.proxy(_.interrupt, _, true));
            _.$list.on('mouseleave.slick', $.proxy(_.interrupt, _, false));
        }
    };
    Slick.prototype.initializeEvents = function() {
        var _ = this;
        _.initArrowEvents();
        _.initDotEvents();
        _.initSlideEvents();
        _.$list.on('touchstart.slick mousedown.slick', { action: 'start' }, _.swipeHandler);
        _.$list.on('touchmove.slick mousemove.slick', { action: 'move' }, _.swipeHandler);
        _.$list.on('touchend.slick mouseup.slick', { action: 'end' }, _.swipeHandler);
        _.$list.on('touchcancel.slick mouseleave.slick', { action: 'end' }, _.swipeHandler);
        _.$list.on('click.slick', _.clickHandler);
        $(document).on(_.visibilityChange, $.proxy(_.visibility, _));
        if (_.options.accessibility === true) { _.$list.on('keydown.slick', _.keyHandler); }
        if (_.options.focusOnSelect === true) { $(_.$slideTrack).children().on('click.slick', _.selectHandler); }
        $(window).on('orientationchange.slick.slick-' + _.instanceUid, $.proxy(_.orientationChange, _));
        $(window).on('resize.slick.slick-' + _.instanceUid, $.proxy(_.resize, _));
        $('[draggable!=true]', _.$slideTrack).on('dragstart', _.preventDefault);
        $(window).on('load.slick.slick-' + _.instanceUid, _.setPosition);
        $(_.setPosition);
    };
    Slick.prototype.initUI = function() {
        var _ = this;
        if (_.options.arrows === true && _.slideCount > _.options.slidesToShow) {
            _.$prevArrow.show();
            _.$nextArrow.show();
        }
        if (_.options.dots === true && _.slideCount > _.options.slidesToShow) { _.$dots.show(); }
    };
    Slick.prototype.keyHandler = function(event) { var _ = this; if (!event.target.tagName.match('TEXTAREA|INPUT|SELECT')) { if (event.keyCode === 37 && _.options.accessibility === true) { _.changeSlide({ data: { message: _.options.rtl === true ? 'next' : 'previous' } }); } else if (event.keyCode === 39 && _.options.accessibility === true) { _.changeSlide({ data: { message: _.options.rtl === true ? 'previous' : 'next' } }); } } };
    Slick.prototype.lazyLoad = function() {
        var _ = this,
            loadRange, cloneRange, rangeStart, rangeEnd;

        function loadImages(imagesScope) {
            $('img[data-lazy]', imagesScope).each(function() {
                var image = $(this),
                    imageSource = $(this).attr('data-lazy'),
                    imageSrcSet = $(this).attr('data-srcset'),
                    imageSizes = $(this).attr('data-sizes') || _.$slider.attr('data-sizes'),
                    imageToLoad = document.createElement('img');
                imageToLoad.onload = function() {
                    image.animate({ opacity: 0 }, 100, function() {
                        if (imageSrcSet) { image.attr('srcset', imageSrcSet); if (imageSizes) { image.attr('sizes', imageSizes); } }
                        image.attr('src', imageSource).animate({ opacity: 1 }, 200, function() { image.removeAttr('data-lazy data-srcset data-sizes').removeClass('slick-loading'); });
                        _.$slider.trigger('lazyLoaded', [_, image, imageSource]);
                    });
                };
                imageToLoad.onerror = function() {
                    image.removeAttr('data-lazy').removeClass('slick-loading').addClass('slick-lazyload-error');
                    _.$slider.trigger('lazyLoadError', [_, image, imageSource]);
                };
                imageToLoad.src = imageSource;
            });
        }
        if (_.options.centerMode === true) {
            if (_.options.infinite === true) {
                rangeStart = _.currentSlide + (_.options.slidesToShow / 2 + 1);
                rangeEnd = rangeStart + _.options.slidesToShow + 2;
            } else {
                rangeStart = Math.max(0, _.currentSlide - (_.options.slidesToShow / 2 + 1));
                rangeEnd = 2 + (_.options.slidesToShow / 2 + 1) + _.currentSlide;
            }
        } else {
            rangeStart = _.options.infinite ? _.options.slidesToShow + _.currentSlide : _.currentSlide;
            rangeEnd = Math.ceil(rangeStart + _.options.slidesToShow);
            if (_.options.fade === true) { if (rangeStart > 0) rangeStart--; if (rangeEnd <= _.slideCount) rangeEnd++; }
        }
        loadRange = _.$slider.find('.slick-slide').slice(rangeStart, rangeEnd);
        if (_.options.lazyLoad === 'anticipated') {
            var prevSlide = rangeStart - 1,
                nextSlide = rangeEnd,
                $slides = _.$slider.find('.slick-slide');
            for (var i = 0; i < _.options.slidesToScroll; i++) {
                if (prevSlide < 0) prevSlide = _.slideCount - 1;
                loadRange = loadRange.add($slides.eq(prevSlide));
                loadRange = loadRange.add($slides.eq(nextSlide));
                prevSlide--;
                nextSlide++;
            }
        }
        loadImages(loadRange);
        if (_.slideCount <= _.options.slidesToShow) {
            cloneRange = _.$slider.find('.slick-slide');
            loadImages(cloneRange);
        } else
        if (_.currentSlide >= _.slideCount - _.options.slidesToShow) {
            cloneRange = _.$slider.find('.slick-cloned').slice(0, _.options.slidesToShow);
            loadImages(cloneRange);
        } else if (_.currentSlide === 0) {
            cloneRange = _.$slider.find('.slick-cloned').slice(_.options.slidesToShow * -1);
            loadImages(cloneRange);
        }
    };
    Slick.prototype.loadSlider = function() {
        var _ = this;
        _.setPosition();
        _.$slideTrack.css({ opacity: 1 });
        _.$slider.removeClass('slick-loading');
        _.initUI();
        if (_.options.lazyLoad === 'progressive') { _.progressiveLazyLoad(); }
    };
    Slick.prototype.next = Slick.prototype.slickNext = function() {
        var _ = this;
        _.changeSlide({ data: { message: 'next' } });
    };
    Slick.prototype.orientationChange = function() {
        var _ = this;
        _.checkResponsive();
        _.setPosition();
    };
    Slick.prototype.pause = Slick.prototype.slickPause = function() {
        var _ = this;
        _.autoPlayClear();
        _.paused = true;
    };
    Slick.prototype.play = Slick.prototype.slickPlay = function() {
        var _ = this;
        _.autoPlay();
        _.options.autoplay = true;
        _.paused = false;
        _.focussed = false;
        _.interrupted = false;
    };
    Slick.prototype.postSlide = function(index) {
        var _ = this;
        if (!_.unslicked) {
            _.$slider.trigger('afterChange', [_, index]);
            _.animating = false;
            if (_.slideCount > _.options.slidesToShow) { _.setPosition(); }
            _.swipeLeft = null;
            if (_.options.autoplay) { _.autoPlay(); }
            if (_.options.accessibility === true) {
                _.initADA();
                if (_.options.focusOnChange) {
                    var $currentSlide = $(_.$slides.get(_.currentSlide));
                    $currentSlide.attr('tabindex', 0).focus();
                }
            }
        }
    };
    Slick.prototype.prev = Slick.prototype.slickPrev = function() {
        var _ = this;
        _.changeSlide({ data: { message: 'previous' } });
    };
    Slick.prototype.preventDefault = function(event) { event.preventDefault(); };
    Slick.prototype.progressiveLazyLoad = function(tryCount) {
        tryCount = tryCount || 1;
        var _ = this,
            $imgsToLoad = $('img[data-lazy]', _.$slider),
            image, imageSource, imageSrcSet, imageSizes, imageToLoad;
        if ($imgsToLoad.length) {
            image = $imgsToLoad.first();
            imageSource = image.attr('data-lazy');
            imageSrcSet = image.attr('data-srcset');
            imageSizes = image.attr('data-sizes') || _.$slider.attr('data-sizes');
            imageToLoad = document.createElement('img');
            imageToLoad.onload = function() {
                if (imageSrcSet) { image.attr('srcset', imageSrcSet); if (imageSizes) { image.attr('sizes', imageSizes); } }
                image.attr('src', imageSource).removeAttr('data-lazy data-srcset data-sizes').removeClass('slick-loading');
                if (_.options.adaptiveHeight === true) { _.setPosition(); }
                _.$slider.trigger('lazyLoaded', [_, image, imageSource]);
                _.progressiveLazyLoad();
            };
            imageToLoad.onerror = function() {
                if (tryCount < 3) { setTimeout(function() { _.progressiveLazyLoad(tryCount + 1); }, 500); } else {
                    image.removeAttr('data-lazy').removeClass('slick-loading').addClass('slick-lazyload-error');
                    _.$slider.trigger('lazyLoadError', [_, image, imageSource]);
                    _.progressiveLazyLoad();
                }
            };
            imageToLoad.src = imageSource;
        } else { _.$slider.trigger('allImagesLoaded', [_]); }
    };
    Slick.prototype.refresh = function(initializing) {
        var _ = this,
            currentSlide, lastVisibleIndex;
        lastVisibleIndex = _.slideCount - _.options.slidesToShow;
        if (!_.options.infinite && (_.currentSlide > lastVisibleIndex)) { _.currentSlide = lastVisibleIndex; }
        if (_.slideCount <= _.options.slidesToShow) { _.currentSlide = 0; }
        currentSlide = _.currentSlide;
        _.destroy(true);
        $.extend(_, _.initials, { currentSlide: currentSlide });
        _.init();
        if (!initializing) { _.changeSlide({ data: { message: 'index', index: currentSlide } }, false); }
    };
    Slick.prototype.registerBreakpoints = function() {
        var _ = this,
            breakpoint, currentBreakpoint, l, responsiveSettings = _.options.responsive || null;
        if ($.type(responsiveSettings) === 'array' && responsiveSettings.length) {
            _.respondTo = _.options.respondTo || 'window';
            for (breakpoint in responsiveSettings) {
                l = _.breakpoints.length - 1;
                if (responsiveSettings.hasOwnProperty(breakpoint)) {
                    currentBreakpoint = responsiveSettings[breakpoint].breakpoint;
                    while (l >= 0) {
                        if (_.breakpoints[l] && _.breakpoints[l] === currentBreakpoint) { _.breakpoints.splice(l, 1); }
                        l--;
                    }
                    _.breakpoints.push(currentBreakpoint);
                    _.breakpointSettings[currentBreakpoint] = responsiveSettings[breakpoint].settings;
                }
            }
            _.breakpoints.sort(function(a, b) { return (_.options.mobileFirst) ? a - b : b - a; });
        }
    };
    Slick.prototype.reinit = function() {
        var _ = this;
        _.$slides = _.$slideTrack.children(_.options.slide).addClass('slick-slide');
        _.slideCount = _.$slides.length;
        if (_.currentSlide >= _.slideCount && _.currentSlide !== 0) { _.currentSlide = _.currentSlide - _.options.slidesToScroll; }
        if (_.slideCount <= _.options.slidesToShow) { _.currentSlide = 0; }
        _.registerBreakpoints();
        _.setProps();
        _.setupInfinite();
        _.buildArrows();
        _.updateArrows();
        _.initArrowEvents();
        _.buildDots();
        _.updateDots();
        _.initDotEvents();
        _.cleanUpSlideEvents();
        _.initSlideEvents();
        _.checkResponsive(false, true);
        if (_.options.focusOnSelect === true) { $(_.$slideTrack).children().on('click.slick', _.selectHandler); }
        _.setSlideClasses(typeof _.currentSlide === 'number' ? _.currentSlide : 0);
        _.setPosition();
        _.focusHandler();
        _.paused = !_.options.autoplay;
        _.autoPlay();
        _.$slider.trigger('reInit', [_]);
    };
    Slick.prototype.resize = function() {
        var _ = this;
        if ($(window).width() !== _.windowWidth) {
            clearTimeout(_.windowDelay);
            _.windowDelay = window.setTimeout(function() {
                _.windowWidth = $(window).width();
                _.checkResponsive();
                if (!_.unslicked) { _.setPosition(); }
            }, 50);
        }
    };
    Slick.prototype.removeSlide = Slick.prototype.slickRemove = function(index, removeBefore, removeAll) {
        var _ = this;
        if (typeof(index) === 'boolean') {
            removeBefore = index;
            index = removeBefore === true ? 0 : _.slideCount - 1;
        } else { index = removeBefore === true ? --index : index; }
        if (_.slideCount < 1 || index < 0 || index > _.slideCount - 1) { return false; }
        _.unload();
        if (removeAll === true) { _.$slideTrack.children().remove(); } else { _.$slideTrack.children(this.options.slide).eq(index).remove(); }
        _.$slides = _.$slideTrack.children(this.options.slide);
        _.$slideTrack.children(this.options.slide).detach();
        _.$slideTrack.append(_.$slides);
        _.$slidesCache = _.$slides;
        _.reinit();
    };
    Slick.prototype.setCSS = function(position) {
        var _ = this,
            positionProps = {},
            x, y;
        if (_.options.rtl === true) { position = -position; }
        x = _.positionProp == 'left' ? Math.ceil(position) + 'px' : '0px';
        y = _.positionProp == 'top' ? Math.ceil(position) + 'px' : '0px';
        positionProps[_.positionProp] = position;
        if (_.transformsEnabled === false) { _.$slideTrack.css(positionProps); } else {
            positionProps = {};
            if (_.cssTransitions === false) {
                positionProps[_.animType] = 'translate(' + x + ', ' + y + ')';
                _.$slideTrack.css(positionProps);
            } else {
                positionProps[_.animType] = 'translate3d(' + x + ', ' + y + ', 0px)';
                _.$slideTrack.css(positionProps);
            }
        }
    };
    Slick.prototype.setDimensions = function() {
        var _ = this;
        if (_.options.vertical === false) { if (_.options.centerMode === true) { _.$list.css({ padding: ('0px ' + _.options.centerPadding) }); } } else { _.$list.height(_.$slides.first().outerHeight(true) * _.options.slidesToShow); if (_.options.centerMode === true) { _.$list.css({ padding: (_.options.centerPadding + ' 0px') }); } }
        _.listWidth = _.$list.width();
        _.listHeight = _.$list.height();
        if (_.options.vertical === false && _.options.variableWidth === false) {
            _.slideWidth = Math.ceil(_.listWidth / _.options.slidesToShow);
            _.$slideTrack.width(Math.ceil((_.slideWidth * _.$slideTrack.children('.slick-slide').length)));
        } else if (_.options.variableWidth === true) { _.$slideTrack.width(5000 * _.slideCount); } else {
            _.slideWidth = Math.ceil(_.listWidth);
            _.$slideTrack.height(Math.ceil((_.$slides.first().outerHeight(true) * _.$slideTrack.children('.slick-slide').length)));
        }
        var offset = _.$slides.first().outerWidth(true) - _.$slides.first().width();
        if (_.options.variableWidth === false) _.$slideTrack.children('.slick-slide').width(_.slideWidth - offset);
    };
    Slick.prototype.setFade = function() {
        var _ = this,
            targetLeft;
        _.$slides.each(function(index, element) { targetLeft = (_.slideWidth * index) * -1; if (_.options.rtl === true) { $(element).css({ position: 'relative', right: targetLeft, top: 0, zIndex: _.options.zIndex - 2, opacity: 0 }); } else { $(element).css({ position: 'relative', left: targetLeft, top: 0, zIndex: _.options.zIndex - 2, opacity: 0 }); } });
        _.$slides.eq(_.currentSlide).css({ zIndex: _.options.zIndex - 1, opacity: 1 });
    };
    Slick.prototype.setHeight = function() {
        var _ = this;
        if (_.options.slidesToShow === 1 && _.options.adaptiveHeight === true && _.options.vertical === false) {
            var targetHeight = _.$slides.eq(_.currentSlide).outerHeight(true);
            _.$list.css('height', targetHeight);
        }
    };
    Slick.prototype.setOption = Slick.prototype.slickSetOption = function() {
        var _ = this,
            l, item, option, value, refresh = false,
            type;
        if ($.type(arguments[0]) === 'object') {
            option = arguments[0];
            refresh = arguments[1];
            type = 'multiple';
        } else if ($.type(arguments[0]) === 'string') {
            option = arguments[0];
            value = arguments[1];
            refresh = arguments[2];
            if (arguments[0] === 'responsive' && $.type(arguments[1]) === 'array') { type = 'responsive'; } else if (typeof arguments[1] !== 'undefined') { type = 'single'; }
        }
        if (type === 'single') { _.options[option] = value; } else if (type === 'multiple') { $.each(option, function(opt, val) { _.options[opt] = val; }); } else if (type === 'responsive') {
            for (item in value) {
                if ($.type(_.options.responsive) !== 'array') { _.options.responsive = [value[item]]; } else {
                    l = _.options.responsive.length - 1;
                    while (l >= 0) {
                        if (_.options.responsive[l].breakpoint === value[item].breakpoint) { _.options.responsive.splice(l, 1); }
                        l--;
                    }
                    _.options.responsive.push(value[item]);
                }
            }
        }
        if (refresh) {
            _.unload();
            _.reinit();
        }
    };
    Slick.prototype.setPosition = function() {
        var _ = this;
        _.setDimensions();
        _.setHeight();
        if (_.options.fade === false) { _.setCSS(_.getLeft(_.currentSlide)); } else { _.setFade(); }
        _.$slider.trigger('setPosition', [_]);
    };
    Slick.prototype.setProps = function() {
        var _ = this,
            bodyStyle = document.body.style;
        _.positionProp = _.options.vertical === true ? 'top' : 'left';
        if (_.positionProp === 'top') { _.$slider.addClass('slick-vertical'); } else { _.$slider.removeClass('slick-vertical'); }
        if (bodyStyle.WebkitTransition !== undefined || bodyStyle.MozTransition !== undefined || bodyStyle.msTransition !== undefined) { if (_.options.useCSS === true) { _.cssTransitions = true; } }
        if (_.options.fade) { if (typeof _.options.zIndex === 'number') { if (_.options.zIndex < 3) { _.options.zIndex = 3; } } else { _.options.zIndex = _.defaults.zIndex; } }
        if (bodyStyle.OTransform !== undefined) {
            _.animType = 'OTransform';
            _.transformType = '-o-transform';
            _.transitionType = 'OTransition';
            if (bodyStyle.perspectiveProperty === undefined && bodyStyle.webkitPerspective === undefined) _.animType = false;
        }
        if (bodyStyle.MozTransform !== undefined) {
            _.animType = 'MozTransform';
            _.transformType = '-moz-transform';
            _.transitionType = 'MozTransition';
            if (bodyStyle.perspectiveProperty === undefined && bodyStyle.MozPerspective === undefined) _.animType = false;
        }
        if (bodyStyle.webkitTransform !== undefined) {
            _.animType = 'webkitTransform';
            _.transformType = '-webkit-transform';
            _.transitionType = 'webkitTransition';
            if (bodyStyle.perspectiveProperty === undefined && bodyStyle.webkitPerspective === undefined) _.animType = false;
        }
        if (bodyStyle.msTransform !== undefined) {
            _.animType = 'msTransform';
            _.transformType = '-ms-transform';
            _.transitionType = 'msTransition';
            if (bodyStyle.msTransform === undefined) _.animType = false;
        }
        if (bodyStyle.transform !== undefined && _.animType !== false) {
            _.animType = 'transform';
            _.transformType = 'transform';
            _.transitionType = 'transition';
        }
        _.transformsEnabled = _.options.useTransform && (_.animType !== null && _.animType !== false);
    };
    Slick.prototype.setSlideClasses = function(index) {
        var _ = this,
            centerOffset, allSlides, indexOffset, remainder;
        allSlides = _.$slider.find('.slick-slide').removeClass('slick-active slick-center slick-current').attr('aria-hidden', 'true');
        _.$slides.eq(index).addClass('slick-current');
        if (_.options.centerMode === true) {
            var evenCoef = _.options.slidesToShow % 2 === 0 ? 1 : 0;
            centerOffset = Math.floor(_.options.slidesToShow / 2);
            if (_.options.infinite === true) {
                if (index >= centerOffset && index <= (_.slideCount - 1) - centerOffset) { _.$slides.slice(index - centerOffset + evenCoef, index + centerOffset + 1).addClass('slick-active').attr('aria-hidden', 'false'); } else {
                    indexOffset = _.options.slidesToShow + index;
                    allSlides.slice(indexOffset - centerOffset + 1 + evenCoef, indexOffset + centerOffset + 2).addClass('slick-active').attr('aria-hidden', 'false');
                }
                if (index === 0) { allSlides.eq(allSlides.length - 1 - _.options.slidesToShow).addClass('slick-center'); } else if (index === _.slideCount - 1) { allSlides.eq(_.options.slidesToShow).addClass('slick-center'); }
            }
            _.$slides.eq(index).addClass('slick-center');
        } else {
            if (index >= 0 && index <= (_.slideCount - _.options.slidesToShow)) { _.$slides.slice(index, index + _.options.slidesToShow).addClass('slick-active').attr('aria-hidden', 'false'); } else if (allSlides.length <= _.options.slidesToShow) { allSlides.addClass('slick-active').attr('aria-hidden', 'false'); } else {
                remainder = _.slideCount % _.options.slidesToShow;
                indexOffset = _.options.infinite === true ? _.options.slidesToShow + index : index;
                if (_.options.slidesToShow == _.options.slidesToScroll && (_.slideCount - index) < _.options.slidesToShow) { allSlides.slice(indexOffset - (_.options.slidesToShow - remainder), indexOffset + remainder).addClass('slick-active').attr('aria-hidden', 'false'); } else { allSlides.slice(indexOffset, indexOffset + _.options.slidesToShow).addClass('slick-active').attr('aria-hidden', 'false'); }
            }
        }
        if (_.options.lazyLoad === 'ondemand' || _.options.lazyLoad === 'anticipated') { _.lazyLoad(); }
    };
    Slick.prototype.setupInfinite = function() {
        var _ = this,
            i, slideIndex, infiniteCount;
        if (_.options.fade === true) { _.options.centerMode = false; }
        if (_.options.infinite === true && _.options.fade === false) {
            slideIndex = null;
            if (_.slideCount > _.options.slidesToShow) {
                if (_.options.centerMode === true) { infiniteCount = _.options.slidesToShow + 1; } else { infiniteCount = _.options.slidesToShow; }
                for (i = _.slideCount; i > (_.slideCount -
                        infiniteCount); i -= 1) {
                    slideIndex = i - 1;
                    $(_.$slides[slideIndex]).clone(true).attr('id', '').attr('data-slick-index', slideIndex - _.slideCount).prependTo(_.$slideTrack).addClass('slick-cloned');
                }
                for (i = 0; i < infiniteCount + _.slideCount; i += 1) {
                    slideIndex = i;
                    $(_.$slides[slideIndex]).clone(true).attr('id', '').attr('data-slick-index', slideIndex + _.slideCount).appendTo(_.$slideTrack).addClass('slick-cloned');
                }
                _.$slideTrack.find('.slick-cloned').find('[id]').each(function() { $(this).attr('id', ''); });
            }
        }
    };
    Slick.prototype.interrupt = function(toggle) {
        var _ = this;
        if (!toggle) { _.autoPlay(); }
        _.interrupted = toggle;
    };
    Slick.prototype.selectHandler = function(event) {
        var _ = this;
        var targetElement = $(event.target).is('.slick-slide') ? $(event.target) : $(event.target).parents('.slick-slide');
        var index = parseInt(targetElement.attr('data-slick-index'));
        if (!index) index = 0;
        if (_.slideCount <= _.options.slidesToShow) { _.slideHandler(index, false, true); return; }
        _.slideHandler(index);
    };
    Slick.prototype.slideHandler = function(index, sync, dontAnimate) {
        var targetSlide, animSlide, oldSlide, slideLeft, targetLeft = null,
            _ = this,
            navTarget;
        sync = sync || false;
        if (_.animating === true && _.options.waitForAnimate === true) { return; }
        if (_.options.fade === true && _.currentSlide === index) { return; }
        if (sync === false) { _.asNavFor(index); }
        targetSlide = index;
        targetLeft = _.getLeft(targetSlide);
        slideLeft = _.getLeft(_.currentSlide);
        _.currentLeft = _.swipeLeft === null ? slideLeft : _.swipeLeft;
        if (_.options.infinite === false && _.options.centerMode === false && (index < 0 || index > _.getDotCount() * _.options.slidesToScroll)) {
            if (_.options.fade === false) { targetSlide = _.currentSlide; if (dontAnimate !== true && _.slideCount > _.options.slidesToShow) { _.animateSlide(slideLeft, function() { _.postSlide(targetSlide); }); } else { _.postSlide(targetSlide); } }
            return;
        } else if (_.options.infinite === false && _.options.centerMode === true && (index < 0 || index > (_.slideCount - _.options.slidesToScroll))) {
            if (_.options.fade === false) { targetSlide = _.currentSlide; if (dontAnimate !== true && _.slideCount > _.options.slidesToShow) { _.animateSlide(slideLeft, function() { _.postSlide(targetSlide); }); } else { _.postSlide(targetSlide); } }
            return;
        }
        if (_.options.autoplay) { clearInterval(_.autoPlayTimer); }
        if (targetSlide < 0) { if (_.slideCount % _.options.slidesToScroll !== 0) { animSlide = _.slideCount - (_.slideCount % _.options.slidesToScroll); } else { animSlide = _.slideCount + targetSlide; } } else if (targetSlide >= _.slideCount) { if (_.slideCount % _.options.slidesToScroll !== 0) { animSlide = 0; } else { animSlide = targetSlide - _.slideCount; } } else { animSlide = targetSlide; }
        _.animating = true;
        _.$slider.trigger('beforeChange', [_, _.currentSlide, animSlide]);
        oldSlide = _.currentSlide;
        _.currentSlide = animSlide;
        _.setSlideClasses(_.currentSlide);
        if (_.options.asNavFor) {
            navTarget = _.getNavTarget();
            navTarget = navTarget.slick('getSlick');
            if (navTarget.slideCount <= navTarget.options.slidesToShow) { navTarget.setSlideClasses(_.currentSlide); }
        }
        _.updateDots();
        _.updateArrows();
        if (_.options.fade === true) {
            if (dontAnimate !== true) {
                _.fadeSlideOut(oldSlide);
                _.fadeSlide(animSlide, function() { _.postSlide(animSlide); });
            } else { _.postSlide(animSlide); }
            _.animateHeight();
            return;
        }
        if (dontAnimate !== true && _.slideCount > _.options.slidesToShow) { _.animateSlide(targetLeft, function() { _.postSlide(animSlide); }); } else { _.postSlide(animSlide); }
    };
    Slick.prototype.startLoad = function() {
        var _ = this;
        if (_.options.arrows === true && _.slideCount > _.options.slidesToShow) {
            _.$prevArrow.hide();
            _.$nextArrow.hide();
        }
        if (_.options.dots === true && _.slideCount > _.options.slidesToShow) { _.$dots.hide(); }
        _.$slider.addClass('slick-loading');
    };
    Slick.prototype.swipeDirection = function() {
        var xDist, yDist, r, swipeAngle, _ = this;
        xDist = _.touchObject.startX - _.touchObject.curX;
        yDist = _.touchObject.startY - _.touchObject.curY;
        r = Math.atan2(yDist, xDist);
        swipeAngle = Math.round(r * 180 / Math.PI);
        if (swipeAngle < 0) { swipeAngle = 360 - Math.abs(swipeAngle); }
        if ((swipeAngle <= 45) && (swipeAngle >= 0)) { return (_.options.rtl === false ? 'left' : 'right'); }
        if ((swipeAngle <= 360) && (swipeAngle >= 315)) { return (_.options.rtl === false ? 'left' : 'right'); }
        if ((swipeAngle >= 135) && (swipeAngle <= 225)) { return (_.options.rtl === false ? 'right' : 'left'); }
        if (_.options.verticalSwiping === true) { if ((swipeAngle >= 35) && (swipeAngle <= 135)) { return 'down'; } else { return 'up'; } }
        return 'vertical';
    };
    Slick.prototype.swipeEnd = function(event) {
        var _ = this,
            slideCount, direction;
        _.dragging = false;
        _.swiping = false;
        if (_.scrolling) { _.scrolling = false; return false; }
        _.interrupted = false;
        _.shouldClick = (_.touchObject.swipeLength > 10) ? false : true;
        if (_.touchObject.curX === undefined) { return false; }
        if (_.touchObject.edgeHit === true) { _.$slider.trigger('edge', [_, _.swipeDirection()]); }
        if (_.touchObject.swipeLength >= _.touchObject.minSwipe) {
            direction = _.swipeDirection();
            switch (direction) {
                case 'left':
                case 'down':
                    slideCount = _.options.swipeToSlide ? _.checkNavigable(_.currentSlide + _.getSlideCount()) : _.currentSlide + _.getSlideCount();
                    _.currentDirection = 0;
                    break;
                case 'right':
                case 'up':
                    slideCount = _.options.swipeToSlide ? _.checkNavigable(_.currentSlide - _.getSlideCount()) : _.currentSlide - _.getSlideCount();
                    _.currentDirection = 1;
                    break;
                default:
            }
            if (direction != 'vertical') {
                _.slideHandler(slideCount);
                _.touchObject = {};
                _.$slider.trigger('swipe', [_, direction]);
            }
        } else {
            if (_.touchObject.startX !== _.touchObject.curX) {
                _.slideHandler(_.currentSlide);
                _.touchObject = {};
            }
        }
    };
    Slick.prototype.swipeHandler = function(event) {
        var _ = this;
        if ((_.options.swipe === false) || ('ontouchend' in document && _.options.swipe === false)) { return; } else if (_.options.draggable === false && event.type.indexOf('mouse') !== -1) { return; }
        _.touchObject.fingerCount = event.originalEvent && event.originalEvent.touches !== undefined ? event.originalEvent.touches.length : 1;
        _.touchObject.minSwipe = _.listWidth / _.options.touchThreshold;
        if (_.options.verticalSwiping === true) { _.touchObject.minSwipe = _.listHeight / _.options.touchThreshold; }
        switch (event.data.action) {
            case 'start':
                _.swipeStart(event);
                break;
            case 'move':
                _.swipeMove(event);
                break;
            case 'end':
                _.swipeEnd(event);
                break;
        }
    };
    Slick.prototype.swipeMove = function(event) {
        var _ = this,
            edgeWasHit = false,
            curLeft, swipeDirection, swipeLength, positionOffset, touches, verticalSwipeLength;
        touches = event.originalEvent !== undefined ? event.originalEvent.touches : null;
        if (!_.dragging || _.scrolling || touches && touches.length !== 1) { return false; }
        curLeft = _.getLeft(_.currentSlide);
        _.touchObject.curX = touches !== undefined ? touches[0].pageX : event.clientX;
        _.touchObject.curY = touches !== undefined ? touches[0].pageY : event.clientY;
        _.touchObject.swipeLength = Math.round(Math.sqrt(Math.pow(_.touchObject.curX - _.touchObject.startX, 2)));
        verticalSwipeLength = Math.round(Math.sqrt(Math.pow(_.touchObject.curY - _.touchObject.startY, 2)));
        if (!_.options.verticalSwiping && !_.swiping && verticalSwipeLength > 4) { _.scrolling = true; return false; }
        if (_.options.verticalSwiping === true) { _.touchObject.swipeLength = verticalSwipeLength; }
        swipeDirection = _.swipeDirection();
        if (event.originalEvent !== undefined && _.touchObject.swipeLength > 4) {
            _.swiping = true;
            event.preventDefault();
        }
        positionOffset = (_.options.rtl === false ? 1 : -1) * (_.touchObject.curX > _.touchObject.startX ? 1 : -1);
        if (_.options.verticalSwiping === true) { positionOffset = _.touchObject.curY > _.touchObject.startY ? 1 : -1; }
        swipeLength = _.touchObject.swipeLength;
        _.touchObject.edgeHit = false;
        if (_.options.infinite === false) {
            if ((_.currentSlide === 0 && swipeDirection === 'right') || (_.currentSlide >= _.getDotCount() && swipeDirection === 'left')) {
                swipeLength = _.touchObject.swipeLength * _.options.edgeFriction;
                _.touchObject.edgeHit = true;
            }
        }
        if (_.options.vertical === false) { _.swipeLeft = curLeft + swipeLength * positionOffset; } else { _.swipeLeft = curLeft + (swipeLength * (_.$list.height() / _.listWidth)) * positionOffset; }
        if (_.options.verticalSwiping === true) { _.swipeLeft = curLeft + swipeLength * positionOffset; }
        if (_.options.fade === true || _.options.touchMove === false) { return false; }
        if (_.animating === true) { _.swipeLeft = null; return false; }
        _.setCSS(_.swipeLeft);
    };
    Slick.prototype.swipeStart = function(event) {
        var _ = this,
            touches;
        _.interrupted = true;
        if (_.touchObject.fingerCount !== 1 || _.slideCount <= _.options.slidesToShow) { _.touchObject = {}; return false; }
        if (event.originalEvent !== undefined && event.originalEvent.touches !== undefined) { touches = event.originalEvent.touches[0]; }
        _.touchObject.startX = _.touchObject.curX = touches !== undefined ? touches.pageX : event.clientX;
        _.touchObject.startY = _.touchObject.curY = touches !== undefined ? touches.pageY : event.clientY;
        _.dragging = true;
    };
    Slick.prototype.unfilterSlides = Slick.prototype.slickUnfilter = function() {
        var _ = this;
        if (_.$slidesCache !== null) {
            _.unload();
            _.$slideTrack.children(this.options.slide).detach();
            _.$slidesCache.appendTo(_.$slideTrack);
            _.reinit();
        }
    };
    Slick.prototype.unload = function() {
        var _ = this;
        $('.slick-cloned', _.$slider).remove();
        if (_.$dots) { _.$dots.remove(); }
        if (_.$prevArrow && _.htmlExpr.test(_.options.prevArrow)) { _.$prevArrow.remove(); }
        if (_.$nextArrow && _.htmlExpr.test(_.options.nextArrow)) { _.$nextArrow.remove(); }
        _.$slides.removeClass('slick-slide slick-active slick-visible slick-current').attr('aria-hidden', 'true').css('width', '');
    };
    Slick.prototype.unslick = function(fromBreakpoint) {
        var _ = this;
        _.$slider.trigger('unslick', [_, fromBreakpoint]);
        _.destroy();
    };
    Slick.prototype.updateArrows = function() {
        var _ = this,
            centerOffset;
        centerOffset = Math.floor(_.options.slidesToShow / 2);
        if (_.options.arrows === true && _.slideCount > _.options.slidesToShow && !_.options.infinite) {
            _.$prevArrow.removeClass('slick-disabled').attr('aria-disabled', 'false');
            _.$nextArrow.removeClass('slick-disabled').attr('aria-disabled', 'false');
            if (_.currentSlide === 0) {
                _.$prevArrow.addClass('slick-disabled').attr('aria-disabled', 'true');
                _.$nextArrow.removeClass('slick-disabled').attr('aria-disabled', 'false');
            } else if (_.currentSlide >= _.slideCount - _.options.slidesToShow && _.options.centerMode === false) {
                _.$nextArrow.addClass('slick-disabled').attr('aria-disabled', 'true');
                _.$prevArrow.removeClass('slick-disabled').attr('aria-disabled', 'false');
            } else if (_.currentSlide >= _.slideCount - 1 && _.options.centerMode === true) {
                _.$nextArrow.addClass('slick-disabled').attr('aria-disabled', 'true');
                _.$prevArrow.removeClass('slick-disabled').attr('aria-disabled', 'false');
            }
        }
    };
    Slick.prototype.updateDots = function() {
        var _ = this;
        if (_.$dots !== null) {
            _.$dots.find('li').removeClass('slick-active').end();
            _.$dots.find('li').eq(Math.floor(_.currentSlide / _.options.slidesToScroll)).addClass('slick-active');
        }
    };
    Slick.prototype.visibility = function() { var _ = this; if (_.options.autoplay) { if (document[_.hidden]) { _.interrupted = true; } else { _.interrupted = false; } } };
    $.fn.slick = function() {
        var _ = this,
            opt = arguments[0],
            args = Array.prototype.slice.call(arguments, 1),
            l = _.length,
            i, ret;
        for (i = 0; i < l; i++) {
            if (typeof opt == 'object' || typeof opt == 'undefined')
                _[i].slick = new Slick(_[i], opt);
            else
                ret = _[i].slick[opt].apply(_[i].slick, args);
            if (typeof ret != 'undefined') return ret;
        }
        return _;
    };
}));
/*! WOW wow.js - v1.3.0 - 2016-10-04
 * https://wowjs.uk
 * Copyright (c) 2016 Thomas Grainger; Licensed MIT */
! function(a, b) {
    if ("function" == typeof define && define.amd) define(["module", "exports"], b);
    else if ("undefined" != typeof exports) b(module, exports);
    else {
        var c = { exports: {} };
        b(c, c.exports), a.WOW = c.exports
    }
}(this, function(a, b) {
    "use strict";

    function c(a, b) { if (!(a instanceof b)) throw new TypeError("Cannot call a class as a function") }

    function d(a, b) { return b.indexOf(a) >= 0 }

    function e(a, b) {
        for (var c in b)
            if (null == a[c]) {
                var d = b[c];
                a[c] = d
            }
        return a
    }

    function f(a) { return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(a) }

    function g(a) {
        var b = arguments.length <= 1 || void 0 === arguments[1] ? !1 : arguments[1],
            c = arguments.length <= 2 || void 0 === arguments[2] ? !1 : arguments[2],
            d = arguments.length <= 3 || void 0 === arguments[3] ? null : arguments[3],
            e = void 0;
        return null != document.createEvent ? (e = document.createEvent("CustomEvent"), e.initCustomEvent(a, b, c, d)) : null != document.createEventObject ? (e = document.createEventObject(), e.eventType = a) : e.eventName = a, e
    }

    function h(a, b) { null != a.dispatchEvent ? a.dispatchEvent(b) : b in (null != a) ? a[b]() : "on" + b in (null != a) && a["on" + b]() }

    function i(a, b, c) { null != a.addEventListener ? a.addEventListener(b, c, !1) : null != a.attachEvent ? a.attachEvent("on" + b, c) : a[b] = c }

    function j(a, b, c) { null != a.removeEventListener ? a.removeEventListener(b, c, !1) : null != a.detachEvent ? a.detachEvent("on" + b, c) : delete a[b] }

    function k() { return "innerHeight" in window ? window.innerHeight : document.documentElement.clientHeight }
    Object.defineProperty(b, "__esModule", { value: !0 });
    var l, m, n = function() {
            function a(a, b) {
                for (var c = 0; c < b.length; c++) {
                    var d = b[c];
                    d.enumerable = d.enumerable || !1, d.configurable = !0, "value" in d && (d.writable = !0), Object.defineProperty(a, d.key, d)
                }
            }
            return function(b, c, d) { return c && a(b.prototype, c), d && a(b, d), b }
        }(),
        o = window.WeakMap || window.MozWeakMap || function() {
            function a() { c(this, a), this.keys = [], this.values = [] }
            return n(a, [{ key: "get", value: function(a) { for (var b = 0; b < this.keys.length; b++) { var c = this.keys[b]; if (c === a) return this.values[b] } } }, { key: "set", value: function(a, b) { for (var c = 0; c < this.keys.length; c++) { var d = this.keys[c]; if (d === a) return this.values[c] = b, this } return this.keys.push(a), this.values.push(b), this } }]), a
        }(),
        p = window.MutationObserver || window.WebkitMutationObserver || window.MozMutationObserver || (m = l = function() {
            function a() { c(this, a), "undefined" != typeof console && null !== console && (console.warn("MutationObserver is not supported by your browser."), console.warn("WOW.js cannot detect dom mutations, please call .sync() after loading new content.")) }
            return n(a, [{ key: "observe", value: function() {} }]), a
        }(), l.notSupported = !0, m),
        q = window.getComputedStyle || function(a) { var b = /(\-([a-z]){1})/g; return { getPropertyValue: function(c) { "float" === c && (c = "styleFloat"), b.test(c) && c.replace(b, function(a, b) { return b.toUpperCase() }); var d = a.currentStyle; return (null != d ? d[c] : void 0) || null } } },
        r = function() {
            function a() {
                var b = arguments.length <= 0 || void 0 === arguments[0] ? {} : arguments[0];
                c(this, a), this.defaults = { boxClass: "wow", animateClass: "animated", offset: 0, mobile: !0, live: !0, callback: null, scrollContainer: null, resetAnimation: !0 }, this.animate = function() { return "requestAnimationFrame" in window ? function(a) { return window.requestAnimationFrame(a) } : function(a) { return a() } }(), this.vendors = ["moz", "webkit"], this.start = this.start.bind(this), this.resetAnimation = this.resetAnimation.bind(this), this.scrollHandler = this.scrollHandler.bind(this), this.scrollCallback = this.scrollCallback.bind(this), this.scrolled = !0, this.config = e(b, this.defaults), null != b.scrollContainer && (this.config.scrollContainer = document.querySelector(b.scrollContainer)), this.animationNameCache = new o, this.wowEvent = g(this.config.boxClass)
            }
            return n(a, [{ key: "init", value: function() { this.element = window.document.documentElement, d(document.readyState, ["interactive", "complete"]) ? this.start() : i(document, "DOMContentLoaded", this.start), this.finished = [] } }, {
                key: "start",
                value: function() {
                    var a = this;
                    if (this.stopped = !1, this.boxes = [].slice.call(this.element.querySelectorAll("." + this.config.boxClass)), this.all = this.boxes.slice(0), this.boxes.length)
                        if (this.disabled()) this.resetStyle();
                        else
                            for (var b = 0; b < this.boxes.length; b++) {
                                var c = this.boxes[b];
                                this.applyStyle(c, !0)
                            }
                    if (this.disabled() || (i(this.config.scrollContainer || window, "scroll", this.scrollHandler), i(window, "resize", this.scrollHandler), this.interval = setInterval(this.scrollCallback, 50)), this.config.live) {
                        var d = new p(function(b) {
                            for (var c = 0; c < b.length; c++)
                                for (var d = b[c], e = 0; e < d.addedNodes.length; e++) {
                                    var f = d.addedNodes[e];
                                    a.doSync(f)
                                }
                        });
                        d.observe(document.body, { childList: !0, subtree: !0 })
                    }
                }
            }, { key: "stop", value: function() { this.stopped = !0, j(this.config.scrollContainer || window, "scroll", this.scrollHandler), j(window, "resize", this.scrollHandler), null != this.interval && clearInterval(this.interval) } }, { key: "sync", value: function() { p.notSupported && this.doSync(this.element) } }, {
                key: "doSync",
                value: function(a) {
                    if ("undefined" != typeof a && null !== a || (a = this.element), 1 === a.nodeType) {
                        a = a.parentNode || a;
                        for (var b = a.querySelectorAll("." + this.config.boxClass), c = 0; c < b.length; c++) {
                            var e = b[c];
                            d(e, this.all) || (this.boxes.push(e), this.all.push(e), this.stopped || this.disabled() ? this.resetStyle() : this.applyStyle(e, !0), this.scrolled = !0)
                        }
                    }
                }
            }, { key: "show", value: function(a) { return this.applyStyle(a), a.className = a.className + " " + this.config.animateClass, null != this.config.callback && this.config.callback(a), h(a, this.wowEvent), this.config.resetAnimation && (i(a, "animationend", this.resetAnimation), i(a, "oanimationend", this.resetAnimation), i(a, "webkitAnimationEnd", this.resetAnimation), i(a, "MSAnimationEnd", this.resetAnimation)), a } }, {
                key: "applyStyle",
                value: function(a, b) {
                    var c = this,
                        d = a.getAttribute("data-wow-duration"),
                        e = a.getAttribute("data-wow-delay"),
                        f = a.getAttribute("data-wow-iteration");
                    return this.animate(function() { return c.customStyle(a, b, d, e, f) })
                }
            }, {
                key: "resetStyle",
                value: function() {
                    for (var a = 0; a < this.boxes.length; a++) {
                        var b = this.boxes[a];
                        b.style.visibility = "visible"
                    }
                }
            }, {
                key: "resetAnimation",
                value: function(a) {
                    if (a.type.toLowerCase().indexOf("animationend") >= 0) {
                        var b = a.target || a.srcElement;
                        b.className = b.className.replace(this.config.animateClass, "").trim()
                    }
                }
            }, { key: "customStyle", value: function(a, b, c, d, e) { return b && this.cacheAnimationName(a), a.style.visibility = b ? "hidden" : "visible", c && this.vendorSet(a.style, { animationDuration: c }), d && this.vendorSet(a.style, { animationDelay: d }), e && this.vendorSet(a.style, { animationIterationCount: e }), this.vendorSet(a.style, { animationName: b ? "none" : this.cachedAnimationName(a) }), a } }, {
                key: "vendorSet",
                value: function(a, b) {
                    for (var c in b)
                        if (b.hasOwnProperty(c)) {
                            var d = b[c];
                            a["" + c] = d;
                            for (var e = 0; e < this.vendors.length; e++) {
                                var f = this.vendors[e];
                                a["" + f + c.charAt(0).toUpperCase() + c.substr(1)] = d
                            }
                        }
                }
            }, {
                key: "vendorCSS",
                value: function(a, b) {
                    for (var c = q(a), d = c.getPropertyCSSValue(b), e = 0; e < this.vendors.length; e++) {
                        var f = this.vendors[e];
                        d = d || c.getPropertyCSSValue("-" + f + "-" + b)
                    }
                    return d
                }
            }, { key: "animationName", value: function(a) { var b = void 0; try { b = this.vendorCSS(a, "animation-name").cssText } catch (c) { b = q(a).getPropertyValue("animation-name") } return "none" === b ? "" : b } }, { key: "cacheAnimationName", value: function(a) { return this.animationNameCache.set(a, this.animationName(a)) } }, { key: "cachedAnimationName", value: function(a) { return this.animationNameCache.get(a) } }, { key: "scrollHandler", value: function() { this.scrolled = !0 } }, {
                key: "scrollCallback",
                value: function() {
                    if (this.scrolled) {
                        this.scrolled = !1;
                        for (var a = [], b = 0; b < this.boxes.length; b++) {
                            var c = this.boxes[b];
                            if (c) {
                                if (this.isVisible(c)) { this.show(c); continue }
                                a.push(c)
                            }
                        }
                        this.boxes = a, this.boxes.length || this.config.live || this.stop()
                    }
                }
            }, { key: "offsetTop", value: function(a) { for (; void 0 === a.offsetTop;) a = a.parentNode; for (var b = a.offsetTop; a.offsetParent;) a = a.offsetParent, b += a.offsetTop; return b } }, {
                key: "isVisible",
                value: function(a) {
                    var b = a.getAttribute("data-wow-offset") || this.config.offset,
                        c = this.config.scrollContainer && this.config.scrollContainer.scrollTop || window.pageYOffset,
                        d = c + Math.min(this.element.clientHeight, k()) - b,
                        e = this.offsetTop(a),
                        f = e + a.clientHeight;
                    return d >= e && f >= c
                }
            }, { key: "disabled", value: function() { return !this.config.mobile && f(navigator.userAgent) } }]), a
        }();
    b["default"] = r, a.exports = b["default"]
});
/*! jQuery & Zepto Lazy v1.7.6 - http://jquery.eisbehr.de/lazy - MIT&GPL-2.0 license - Copyright 2012-2017 Daniel 'Eisbehr' Kern */
! function(t, e) {
    "use strict";

    function r(r, a, i, u, l) {
        function f() {
            L = t.devicePixelRatio > 1, i = c(i), a.delay >= 0 && setTimeout(function() { s(!0) }, a.delay), (a.delay < 0 || a.combined) && (u.e = v(a.throttle, function(t) { "resize" === t.type && (w = B = -1), s(t.all) }), u.a = function(t) { t = c(t), i.push.apply(i, t) }, u.g = function() { return i = n(i).filter(function() { return !n(this).data(a.loadedName) }) }, u.f = function(t) {
                for (var e = 0; e < t.length; e++) {
                    var r = i.filter(function() { return this === t[e] });
                    r.length && s(!1, r)
                }
            }, s(), n(a.appendScroll).on("scroll." + l + " resize." + l, u.e))
        }

        function c(t) {
            var i = a.defaultImage,
                o = a.placeholder,
                u = a.imageBase,
                l = a.srcsetAttribute,
                f = a.loaderAttribute,
                c = a._f || {};
            t = n(t).filter(function() {
                var t = n(this),
                    r = m(this);
                return !t.data(a.handledName) && (t.attr(a.attribute) || t.attr(l) || t.attr(f) || c[r] !== e)
            }).data("plugin_" + a.name, r);
            for (var s = 0, d = t.length; s < d; s++) {
                var A = n(t[s]),
                    g = m(t[s]),
                    h = A.attr(a.imageBaseAttribute) || u;
                g === N && h && A.attr(l) && A.attr(l, b(A.attr(l), h)), c[g] === e || A.attr(f) || A.attr(f, c[g]), g === N && i && !A.attr(E) ? A.attr(E, i) : g === N || !o || A.css(O) && "none" !== A.css(O) || A.css(O, "url('" + o + "')")
            }
            return t
        }

        function s(t, e) {
            if (!i.length) return void(a.autoDestroy && r.destroy());
            for (var o = e || i, u = !1, l = a.imageBase || "", f = a.srcsetAttribute, c = a.handledName, s = 0; s < o.length; s++)
                if (t || e || A(o[s])) {
                    var g = n(o[s]),
                        h = m(o[s]),
                        b = g.attr(a.attribute),
                        v = g.attr(a.imageBaseAttribute) || l,
                        p = g.attr(a.loaderAttribute);
                    g.data(c) || a.visibleOnly && !g.is(":visible") || !((b || g.attr(f)) && (h === N && (v + b !== g.attr(E) || g.attr(f) !== g.attr(F)) || h !== N && v + b !== g.css(O)) || p) || (u = !0, g.data(c, !0), d(g, h, v, p))
                }
            u && (i = n(i).filter(function() { return !n(this).data(c) }))
        }

        function d(t, e, r, i) {
            ++z;
            var o = function() { y("onError", t), p(), o = n.noop };
            y("beforeLoad", t);
            var u = a.attribute,
                l = a.srcsetAttribute,
                f = a.sizesAttribute,
                c = a.retinaAttribute,
                s = a.removeAttribute,
                d = a.loadedName,
                A = t.attr(c);
            if (i) {
                var g = function() { s && t.removeAttr(a.loaderAttribute), t.data(d, !0), y(T, t), setTimeout(p, 1), g = n.noop };
                t.off(I).one(I, o).one(D, g), y(i, t, function(e) { e ? (t.off(D), g()) : (t.off(I), o()) }) || t.trigger(I)
            } else {
                var h = n(new Image);
                h.one(I, o).one(D, function() { t.hide(), e === N ? t.attr(C, h.attr(C)).attr(F, h.attr(F)).attr(E, h.attr(E)) : t.css(O, "url('" + h.attr(E) + "')"), t[a.effect](a.effectTime), s && (t.removeAttr(u + " " + l + " " + c + " " + a.imageBaseAttribute), f !== C && t.removeAttr(f)), t.data(d, !0), y(T, t), h.remove(), p() });
                var m = (L && A ? A : t.attr(u)) || "";
                h.attr(C, t.attr(f)).attr(F, t.attr(l)).attr(E, m ? r + m : null), h.complete && h.trigger(D)
            }
        }

        function A(t) {
            var e = t.getBoundingClientRect(),
                r = a.scrollDirection,
                n = a.threshold,
                i = h() + n > e.top && -n < e.bottom,
                o = g() + n > e.left && -n < e.right;
            return "vertical" === r ? i : "horizontal" === r ? o : i && o
        }

        function g() { return w >= 0 ? w : w = n(t).width() }

        function h() { return B >= 0 ? B : B = n(t).height() }

        function m(t) { return t.tagName.toLowerCase() }

        function b(t, e) {
            if (e) {
                var r = t.split(",");
                t = "";
                for (var a = 0, n = r.length; a < n; a++) t += e + r[a].trim() + (a !== n - 1 ? "," : "")
            }
            return t
        }

        function v(t, e) {
            var n, i = 0;
            return function(o, u) {
                function l() { i = +new Date, e.call(r, o) }
                var f = +new Date - i;
                n && clearTimeout(n), f > t || !a.enableThrottle || u ? l() : n = setTimeout(l, t - f)
            }
        }

        function p() {--z, i.length || z || y("onFinishedAll") }

        function y(t, e, n) { return !!(t = a[t]) && (t.apply(r, [].slice.call(arguments, 1)), !0) }
        var z = 0,
            w = -1,
            B = -1,
            L = !1,
            T = "afterLoad",
            D = "load",
            I = "error",
            N = "img",
            E = "src",
            F = "srcset",
            C = "sizes",
            O = "background-image";
        "event" === a.bind || o ? f() : n(t).on(D + "." + l, f)
    }

    function a(a, o) {
        var u = this,
            l = n.extend({}, u.config, o),
            f = {},
            c = l.name + "-" + ++i;
        return u.config = function(t, r) { return r === e ? l[t] : (l[t] = r, u) }, u.addItems = function(t) { return f.a && f.a("string" === n.type(t) ? n(t) : t), u }, u.getItems = function() { return f.g ? f.g() : {} }, u.update = function(t) { return f.e && f.e({}, !t), u }, u.force = function(t) { return f.f && f.f("string" === n.type(t) ? n(t) : t), u }, u.loadAll = function() { return f.e && f.e({ all: !0 }, !0), u }, u.destroy = function() { return n(l.appendScroll).off("." + c, f.e), n(t).off("." + c), f = {}, e }, r(u, l, a, f, c), l.chainable ? a : u
    }
    var n = t.jQuery || t.Zepto,
        i = 0,
        o = !1;
    n.fn.Lazy = n.fn.lazy = function(t) { return new a(this, t) }, n.Lazy = n.lazy = function(t, r, i) { if (n.isFunction(r) && (i = r, r = []), n.isFunction(i)) { t = n.isArray(t) ? t : [t], r = n.isArray(r) ? r : [r]; for (var o = a.prototype.config, u = o._f || (o._f = {}), l = 0, f = t.length; l < f; l++)(o[t[l]] === e || n.isFunction(o[t[l]])) && (o[t[l]] = i); for (var c = 0, s = r.length; c < s; c++) u[r[c]] = t[0] } }, a.prototype.config = { name: "lazy", chainable: !0, autoDestroy: !0, bind: "load", threshold: 500, visibleOnly: !1, appendScroll: t, scrollDirection: "both", imageBase: null, defaultImage: "data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==", placeholder: null, delay: -1, combined: !1, attribute: "data-src", srcsetAttribute: "data-srcset", sizesAttribute: "data-sizes", retinaAttribute: "data-retina", loaderAttribute: "data-loader", imageBaseAttribute: "data-imagebase", removeAttribute: !0, handledName: "handled", loadedName: "loaded", effect: "show", effectTime: 0, enableThrottle: !0, throttle: 250, beforeLoad: e, afterLoad: e, onError: e, onFinishedAll: e }, n(t).on("load", function() { o = !0 })
}(window);
/*! Lity - v2.3.1 - 2018-04-20
 * http://sorgalla.com/lity/
 * Copyright (c) 2015-2018 Jan Sorgalla; Licensed MIT */
(function(window, factory) { if (typeof define === 'function' && define.amd) { define(['jquery'], function($) { return factory(window, $); }); } else if (typeof module === 'object' && typeof module.exports === 'object') { module.exports = factory(window, require('jquery')); } else { window.lity = factory(window, window.jQuery || window.Zepto); } }(typeof window !== "undefined" ? window : this, function(window, $) {
    'use strict';
    var document = window.document;
    var _win = $(window);
    var _deferred = $.Deferred;
    var _html = $('html');
    var _instances = [];
    var _attrAriaHidden = 'aria-hidden';
    var _dataAriaHidden = 'lity-' + _attrAriaHidden;
    var _focusableElementsSelector = 'a[href],area[href],input:not([disabled]),select:not([disabled]),textarea:not([disabled]),button:not([disabled]),iframe,object,embed,[contenteditable],[tabindex]:not([tabindex^="-"])';
    var _defaultOptions = { esc: true, handler: null, handlers: { image: imageHandler, inline: inlineHandler, youtube: youtubeHandler, vimeo: vimeoHandler, googlemaps: googlemapsHandler, facebookvideo: facebookvideoHandler, iframe: iframeHandler }, template: '<div id="liliModalOasis" class="lity" role="dialog" aria-label="Dialog Window (Press escape to close)" tabindex="-1"><div class="lity-wrap" data-lity-close role="document"><div class="lity-loader" aria-hidden="true">Loading...</div><div class="lity-container"><div class="lity-content"></div><button class="lity-close" type="button" aria-label="Close (Press escape to close)" data-lity-close>&times;</button></div></div></div>' };
    var _imageRegexp = /(^data:image\/)|(\.(png|jpe?g|gif|svg|webp|bmp|ico|tiff?)(\?\S*)?$)/i;
    var _youtubeRegex = /(youtube(-nocookie)?\.com|youtu\.be)\/(watch\?v=|v\/|u\/|embed\/?)?([\w-]{11})(.*)?/i;
    var _vimeoRegex = /(vimeo(pro)?.com)\/(?:[^\d]+)?(\d+)\??(.*)?$/;
    var _googlemapsRegex = /((maps|www)\.)?google\.([^\/\?]+)\/?((maps\/?)?\?)(.*)/i;
    var _facebookvideoRegex = /(facebook\.com)\/([a-z0-9_-]*)\/videos\/([0-9]*)(.*)?$/i;
    var _transitionEndEvent = (function() {
        var el = document.createElement('div');
        var transEndEventNames = { WebkitTransition: 'webkitTransitionEnd', MozTransition: 'transitionend', OTransition: 'oTransitionEnd otransitionend', transition: 'transitionend' };
        for (var name in transEndEventNames) { if (el.style[name] !== undefined) { return transEndEventNames[name]; } }
        return false;
    })();

    function transitionEnd(element) {
        var deferred = _deferred();
        if (!_transitionEndEvent || !element.length) { deferred.resolve(); } else {
            element.one(_transitionEndEvent, deferred.resolve);
            setTimeout(deferred.resolve, 500);
        }
        return deferred.promise();
    }

    function settings(currSettings, key, value) {
        if (arguments.length === 1) { return $.extend({}, currSettings); }
        if (typeof key === 'string') {
            if (typeof value === 'undefined') { return typeof currSettings[key] === 'undefined' ? null : currSettings[key]; }
            currSettings[key] = value;
        } else { $.extend(currSettings, key); }
        return this;
    }

    function parseQueryParams(params) {
        var pairs = decodeURI(params.split('#')[0]).split('&');
        var obj = {},
            p;
        for (var i = 0, n = pairs.length; i < n; i++) {
            if (!pairs[i]) { continue; }
            p = pairs[i].split('=');
            obj[p[0]] = p[1];
        }
        return obj;
    }

    function appendQueryParams(url, params) { return url + (url.indexOf('?') > -1 ? '&' : '?') + $.param(params); }

    function transferHash(originalUrl, newUrl) {
        var pos = originalUrl.indexOf('#');
        if (-1 === pos) { return newUrl; }
        if (pos > 0) { originalUrl = originalUrl.substr(pos); }
        return newUrl + originalUrl;
    }

    function error(msg) { return $('<span class="lity-error"/>').append(msg); }

    function imageHandler(target, instance) {
        var desc = (instance.opener() && instance.opener().data('lity-desc')) || 'Image with no description';
        var img = $('<img src="' + target + '" alt="' + desc + '"/>');
        var deferred = _deferred();
        var failed = function() { deferred.reject(error('Failed loading image')); };
        img.on('load', function() {
            if (this.naturalWidth === 0) { return failed(); }
            deferred.resolve(img);
        }).on('error', failed);
        return deferred.promise();
    }
    imageHandler.test = function(target) { return _imageRegexp.test(target); };

    function inlineHandler(target, instance) {
        var el, placeholder, hasHideClass;
        try { el = $(target); } catch (e) { return false; }
        if (!el.length) { return false; }
        placeholder = $('<i style="display:none !important"/>');
        hasHideClass = el.hasClass('lity-hide');
        instance.element().one('lity:remove', function() { placeholder.before(el).remove(); if (hasHideClass && !el.closest('.lity-content').length) { el.addClass('lity-hide'); } });
        return el.removeClass('lity-hide').after(placeholder);
    }

    function youtubeHandler(target) {
        var matches = _youtubeRegex.exec(target);
        if (!matches) { return false; }
        return iframeHandler(transferHash(target, appendQueryParams('https://www.youtube' + (matches[2] || '') + '.com/embed/' + matches[4], $.extend({ autoplay: 1 }, parseQueryParams(matches[5] || '')))));
    }

    function vimeoHandler(target) {
        var matches = _vimeoRegex.exec(target);
        if (!matches) { return false; }
        return iframeHandler(transferHash(target, appendQueryParams('https://player.vimeo.com/video/' + matches[3], $.extend({ autoplay: 1 }, parseQueryParams(matches[4] || '')))));
    }

    function facebookvideoHandler(target) {
        var matches = _facebookvideoRegex.exec(target);
        if (!matches) { return false; }
        if (0 !== target.indexOf('http')) { target = 'https:' + target; }
        return iframeHandler(transferHash(target, appendQueryParams('https://www.facebook.com/plugins/video.php?href=' + target, $.extend({ autoplay: 1 }, parseQueryParams(matches[4] || '')))));
    }

    function googlemapsHandler(target) {
        var matches = _googlemapsRegex.exec(target);
        if (!matches) { return false; }
        return iframeHandler(transferHash(target, appendQueryParams('https://www.google.' + matches[3] + '/maps?' + matches[6], { output: matches[6].indexOf('layer=c') > 0 ? 'svembed' : 'embed' })));
    }

    function iframeHandler(target) { return '<div class="lity-iframe-container"><iframe frameborder="0" allowfullscreen src="' + target + '"/></div>'; }

    function winHeight() { return document.documentElement.clientHeight ? document.documentElement.clientHeight : Math.round(_win.height()); }

    function keydown(e) {
        var current = currentInstance();
        if (!current) { return; }
        if (e.keyCode === 27 && !!current.options('esc')) { current.close(); }
        if (e.keyCode === 9) { handleTabKey(e, current); }
    }

    function handleTabKey(e, instance) {
        var focusableElements = instance.element().find(_focusableElementsSelector);
        var focusedIndex = focusableElements.index(document.activeElement);
        if (e.shiftKey && focusedIndex <= 0) {
            focusableElements.get(focusableElements.length - 1).focus();
            e.preventDefault();
        } else if (!e.shiftKey && focusedIndex === focusableElements.length - 1) {
            focusableElements.get(0).focus();
            e.preventDefault();
        }
    }

    function resize() { $.each(_instances, function(i, instance) { instance.resize(); }); }

    function registerInstance(instanceToRegister) {
        if (1 === _instances.unshift(instanceToRegister)) {
            _html.addClass('lity-active');
            _win.on({ resize: resize, keydown: keydown });
        }
        $('body > *').not(instanceToRegister.element()).addClass('lity-hidden').each(function() {
            var el = $(this);
            if (undefined !== el.data(_dataAriaHidden)) { return; }
            el.data(_dataAriaHidden, el.attr(_attrAriaHidden) || null);
        }).attr(_attrAriaHidden, 'true');
    }

    function removeInstance(instanceToRemove) {
        var show;
        instanceToRemove.element().attr(_attrAriaHidden, 'true');
        if (1 === _instances.length) {
            _html.removeClass('lity-active');
            _win.off({ resize: resize, keydown: keydown });
        }
        _instances = $.grep(_instances, function(instance) { return instanceToRemove !== instance; });
        if (!!_instances.length) { show = _instances[0].element(); } else { show = $('.lity-hidden'); }
        show.removeClass('lity-hidden').each(function() {
            var el = $(this),
                oldAttr = el.data(_dataAriaHidden);
            if (!oldAttr) { el.removeAttr(_attrAriaHidden); } else { el.attr(_attrAriaHidden, oldAttr); }
            el.removeData(_dataAriaHidden);
        });
    }

    function currentInstance() {
        if (0 === _instances.length) { return null; }
        return _instances[0];
    }

    function factory(target, instance, handlers, preferredHandler) {
        var handler = 'inline',
            content;
        var currentHandlers = $.extend({}, handlers);
        if (preferredHandler && currentHandlers[preferredHandler]) {
            content = currentHandlers[preferredHandler](target, instance);
            handler = preferredHandler;
        } else {
            $.each(['inline', 'iframe'], function(i, name) {
                delete currentHandlers[name];
                currentHandlers[name] = handlers[name];
            });
            $.each(currentHandlers, function(name, currentHandler) {
                if (!currentHandler) { return true; }
                if (currentHandler.test && !currentHandler.test(target, instance)) { return true; }
                content = currentHandler(target, instance);
                if (false !== content) { handler = name; return false; }
            });
        }
        return { handler: handler, content: content || '' };
    }

    function Lity(target, options, opener, activeElement) {
        var self = this;
        var result;
        var isReady = false;
        var isClosed = false;
        var element;
        var content;
        options = $.extend({}, _defaultOptions, options);
        element = $(options.template);
        self.element = function() { return element; };
        self.opener = function() { return opener; };
        self.options = $.proxy(settings, self, options);
        self.handlers = $.proxy(settings, self, options.handlers);
        self.resize = function() {
            if (!isReady || isClosed) { return; }
            content.css('max-height', winHeight() + 'px').trigger('lity:resize', [self]);
        };
        self.close = function() {
            if (!isReady || isClosed) { return; }
            isClosed = true;
            removeInstance(self);
            var deferred = _deferred();
            if (activeElement && (document.activeElement === element[0] || $.contains(element[0], document.activeElement))) { try { activeElement.focus(); } catch (e) {} }
            content.trigger('lity:close', [self]);
            element.removeClass('lity-opened').addClass('lity-closed');
            transitionEnd(content.add(element)).always(function() {
                content.trigger('lity:remove', [self]);
                element.remove();
                element = undefined;
                deferred.resolve();
            });
            return deferred.promise();
        };
        result = factory(target, self, options.handlers, options.handler);
        element.attr(_attrAriaHidden, 'false').addClass('lity-loading lity-opened lity-' + result.handler).appendTo('body').focus().on('click', '[data-lity-close]', function(e) { if ($(e.target).is('[data-lity-close]')) { self.close(); } }).trigger('lity:open', [self]);
        registerInstance(self);
        $.when(result.content).always(ready);

        function ready(result) {
            content = $(result).css('max-height', winHeight() + 'px');
            element.find('.lity-loader').each(function() {
                var loader = $(this);
                transitionEnd(loader).always(function() { loader.remove(); });
            });
            element.removeClass('lity-loading').find('.lity-content').empty().append(content);
            isReady = true;
            content.trigger('lity:ready', [self]);
        }
    }

    function lity(target, options, opener) {
        if (!target.preventDefault) { opener = $(opener); } else {
            target.preventDefault();
            opener = $(this);
            target = opener.data('lity-target') || opener.attr('href') || opener.attr('src');
        }
        var instance = new Lity(target, $.extend({}, opener.data('lity-options') || opener.data('lity'), options), opener, document.activeElement);
        if (!target.preventDefault) { return instance; }
    }
    lity.version = '2.3.1';
    lity.options = $.proxy(settings, lity, _defaultOptions);
    lity.handlers = $.proxy(settings, lity, _defaultOptions.handlers);
    lity.current = currentInstance;
    $(document).on('click.lity', '[data-lity]', lity);
    return lity;
}));
jQuery(document).ready(function($) {
    jQuery('.testimonialSlider').each(function() { jQuery(this).slick({ infinite: true, slidesToShow: 1, slidesToScroll: 1, rows: 0, slide: '.testimonial', dots: true, appendDots: jQuery(this).find('.dots'), nextArrow: jQuery(this).find('.arrow-next'), prevArrow: jQuery(this).find('.arrow-prev') }); });
    jQuery('.blurb-slider').not('.slick-initialized').slick({ infinite: true, slidesToShow: 1, slidesToScroll: 1, rows: 0, slide: '.blurb', dots: true, arrows: false });
    jQuery('.hamburger').click(function() { jQuery(this).toggleClass('is-active'); });
    window.onscroll = function() { myFunction() };
    var header = document.getElementById("header");
    var sticky = header.offsetTop;

    function myFunction() {
        if (window.pageYOffset > sticky) {
            header.classList.add("sticky");
            header.classList.add("shadow-sm");
        } else { header.classList.remove("sticky"); }
    }
    new WOW().init();
    $("a.faq-link").on('click', function(event) {
        if (this.hash !== "") {
            event.preventDefault();
            var hash = this.hash;
            $('html, body').animate({ scrollTop: $(hash).offset().top - 180 }, 800, function() {});
        }
    });
    $('.expander').click(function(e) {
        e.preventDefault();
        $(this).toggleClass('active');
        $(this).next().toggleClass('expanded');
    })
    $('.see-more').click(function(e) {
        e.preventDefault();
        $(this).toggleClass('active');
        $(this).parent().toggleClass('complete');
    });
    $(location.hash).trigger('click');
});
(function(e, h, l, c) {
    e.fn.sonar = function(o, n) {
        if (typeof o === "boolean") {
            n = o;
            o = c
        }
        return e.sonar(this[0], o, n)
    };
    var f = l.body,
        a = "scrollin",
        m = "scrollout",
        b = function(r, n, t) {
            if (r) {
                f || (f = l.body);
                var s = r,
                    u = 0,
                    v = f.offsetHeight,
                    o = h.innerHeight || l.documentElement.clientHeight || f.clientHeight || 0,
                    q = l.documentElement.scrollTop || h.pageYOffset || f.scrollTop || 0,
                    p = r.offsetHeight || 0;
                if (!r.sonarElemTop || r.sonarBodyHeight !== v) {
                    if (s.offsetParent) { do { u += s.offsetTop } while (s = s.offsetParent) }
                    r.sonarElemTop = u;
                    r.sonarBodyHeight = v
                }
                n = n === c ? 0 : n;
                return (!(r.sonarElemTop + (t ? 0 : p) < q - n) && !(r.sonarElemTop + (t ? p : 0) > q + o + n))
            }
        },
        d = {},
        j = 0,
        i = function() {
            setTimeout(function() {
                var s, o, t, q, p, r, n;
                for (t in d) {
                    o = d[t];
                    for (r = 0, n = o.length; r < n; r++) {
                        q = o[r];
                        s = q.elem;
                        p = b(s, q.px, q.full);
                        if (t === m ? !p : p) {
                            if (!q.tr) {
                                if (s[t]) {
                                    e(s).trigger(t);
                                    q.tr = 1
                                } else {
                                    o.splice(r, 1);
                                    r--;
                                    n--
                                }
                            }
                        } else { q.tr = 0 }
                    }
                }
            }, 25)
        },
        k = function(n, o) { n[o] = 0 },
        g = function(r, p) {
            var t = p.px,
                q = p.full,
                s = p.evt,
                o = b(r, t, q),
                n = 0;
            r[s] = 1;
            if (s === m ? !o : o) {
                setTimeout(function() { e(r).trigger(s === m ? m : a) }, 0);
                n = 1
            }
            d[s].push({ elem: r, px: t, full: q, tr: n });
            if (!j) {
                e(h).bind("scroll", i);
                j = 1
            }
        };
    e.sonar = b;
    d[a] = [];
    e.event.special[a] = {
        add: function(n) {
            var p = n.data || {},
                o = this;
            if (!o[a]) { g(this, { px: p.distance, full: p.full, evt: a }) }
        },
        remove: function(n) { k(this, a) }
    };
    d[m] = [];
    e.event.special[m] = {
        add: function(n) {
            var p = n.data || {},
                o = this;
            if (!o[m]) { g(o, { px: p.distance, full: p.full, evt: m }) }
        },
        remove: function(n) { k(this, m) }
    }
})(jQuery, window, document);
(function($) {
    lazy_load_init();
    $('body').bind('post-load', lazy_load_init);

    function lazy_load_init() {
        $('img[data-lazy-src]').bind('scrollin', { distance: 200 }, function() { lazy_load_image(this); });
        $('[data-carousel-extra]').each(function() { $(this).find('img[data-lazy-src]').each(function() { lazy_load_image(this); }); });
    }

    function lazy_load_image(img) {
        var $img = jQuery(img),
            src = $img.attr('data-lazy-src');
        if (!src || 'undefined' === typeof(src))
            return;
        $img.unbind('scrollin').hide().removeAttr('data-lazy-src').attr('data-lazy-loaded', 'true');
        img.src = src;
        $img.fadeIn();
    }
})(jQuery);
! function(d, l) {
    "use strict";
    var e = !1,
        o = !1;
    if (l.querySelector)
        if (d.addEventListener) e = !0;
    if (d.wp = d.wp || {}, !d.wp.receiveEmbedMessage)
        if (d.wp.receiveEmbedMessage = function(e) {
                var t = e.data;
                if (t)
                    if (t.secret || t.message || t.value)
                        if (!/[^a-zA-Z0-9]/.test(t.secret)) {
                            var r, a, i, s, n, o = l.querySelectorAll('iframe[data-secret="' + t.secret + '"]'),
                                c = l.querySelectorAll('blockquote[data-secret="' + t.secret + '"]');
                            for (r = 0; r < c.length; r++) c[r].style.display = "none";
                            for (r = 0; r < o.length; r++)
                                if (a = o[r], e.source === a.contentWindow) {
                                    if (a.removeAttribute("style"), "height" === t.message) {
                                        if (1e3 < (i = parseInt(t.value, 10))) i = 1e3;
                                        else if (~~i < 200) i = 200;
                                        a.height = i
                                    }
                                    if ("link" === t.message)
                                        if (s = l.createElement("a"), n = l.createElement("a"), s.href = a.getAttribute("src"), n.href = t.value, n.host === s.host)
                                            if (l.activeElement === a) d.top.location.href = t.value
                                }
                        }
            }, e) d.addEventListener("message", d.wp.receiveEmbedMessage, !1), l.addEventListener("DOMContentLoaded", t, !1), d.addEventListener("load", t, !1);

    function t() {
        if (!o) {
            o = !0;
            var e, t, r, a, i = -1 !== navigator.appVersion.indexOf("MSIE 10"),
                s = !!navigator.userAgent.match(/Trident.*rv:11\./),
                n = l.querySelectorAll("iframe.wp-embedded-content");
            for (t = 0; t < n.length; t++) { if (!(r = n[t]).getAttribute("data-secret")) a = Math.random().toString(36).substr(2, 10), r.src += "#?secret=" + a, r.setAttribute("data-secret", a); if (i || s)(e = r.cloneNode(!0)).removeAttribute("security"), r.parentNode.replaceChild(e, r) }
        }
    }
}(window, document);
! function(e) { "function" == typeof define && define.amd ? define(["jquery"], e) : "object" == typeof exports ? e(require("jquery")) : e(jQuery) }(function(R) {
    var a, e = navigator.userAgent,
        S = /iphone/i.test(e),
        i = /chrome/i.test(e),
        T = /android/i.test(e);
    R.mask = { definitions: { 9: "[0-9]", a: "[A-Za-z]", "*": "[A-Za-z0-9]" }, autoclear: !0, dataName: "rawMaskFn", placeholder: "_" }, R.fn.extend({
        caret: function(e, t) { var n; if (0 !== this.length && !this.is(":hidden") && this.get(0) === document.activeElement) return "number" == typeof e ? (t = "number" == typeof t ? t : e, this.each(function() { this.setSelectionRange ? this.setSelectionRange(e, t) : this.createTextRange && ((n = this.createTextRange()).collapse(!0), n.moveEnd("character", t), n.moveStart("character", e), n.select()) })) : (this[0].setSelectionRange ? (e = this[0].selectionStart, t = this[0].selectionEnd) : document.selection && document.selection.createRange && (n = document.selection.createRange(), e = 0 - n.duplicate().moveStart("character", -1e5), t = e + n.text.length), { begin: e, end: t }) },
        unmask: function() { return this.trigger("unmask") },
        mask: function(t, v) {
            var n, b, k, y, x, j, A;
            if (!t && 0 < this.length) { var e = R(this[0]).data(R.mask.dataName); return e ? e() : void 0 }
            return v = R.extend({ autoclear: R.mask.autoclear, placeholder: R.mask.placeholder, completed: null }, v), n = R.mask.definitions, b = [], k = j = t.length, y = null, t = String(t), R.each(t.split(""), function(e, t) { "?" == t ? (j--, k = e) : n[t] ? (b.push(new RegExp(n[t])), null === y && (y = b.length - 1), e < k && (x = b.length - 1)) : b.push(null) }), this.trigger("unmask").each(function() {
                var o = R(this),
                    c = R.map(t.split(""), function(e, t) { if ("?" != e) return n[e] ? f(t) : e }),
                    l = c.join(""),
                    r = o.val();

                function u() {
                    if (v.completed) {
                        for (var e = y; e <= x; e++)
                            if (b[e] && c[e] === f(e)) return;
                        v.completed.call(o)
                    }
                }

                function f(e) { return e < v.placeholder.length ? v.placeholder.charAt(e) : v.placeholder.charAt(0) }

                function s(e) { for (; ++e < j && !b[e];); return e }

                function h(e, t) {
                    var n, a;
                    if (!(e < 0)) {
                        for (n = e, a = s(t); n < j; n++)
                            if (b[n]) {
                                if (!(a < j && b[n].test(c[a]))) break;
                                c[n] = c[a], c[a] = f(a), a = s(a)
                            }
                        d(), o.caret(Math.max(y, e))
                    }
                }

                function g(e) { p(), o.val() != r && o.change() }

                function m(e, t) { var n; for (n = e; n < t && n < j; n++) b[n] && (c[n] = f(n)) }

                function d() { o.val(c.join("")) }

                function p(e) {
                    var t, n, a, i = o.val(),
                        r = -1;
                    for (a = t = 0; t < j; t++)
                        if (b[t]) {
                            for (c[t] = f(t); a++ < i.length;)
                                if (n = i.charAt(a - 1), b[t].test(n)) { c[t] = n, r = t; break }
                            if (a > i.length) { m(t + 1, j); break }
                        } else c[t] === i.charAt(a) && a++, t < k && (r = t);
                    return e ? d() : r + 1 < k ? v.autoclear || c.join("") === l ? (o.val() && o.val(""), m(0, j)) : d() : (d(), o.val(o.val().substring(0, r + 1))), k ? t : y
                }
                o.data(R.mask.dataName, function() { return R.map(c, function(e, t) { return b[t] && e != f(t) ? e : null }).join("") }), o.one("unmask", function() { o.off(".mask").removeData(R.mask.dataName) }).on("focus.mask", function() {
                    var e;
                    o.prop("readonly") || (clearTimeout(a), r = o.val(), e = p(), a = setTimeout(function() { o.get(0) === document.activeElement && (d(), e == t.replace("?", "").length ? o.caret(0, e) : o.caret(e)) }, 10))
                }).on("blur.mask", g).on("keydown.mask", function(e) {
                    if (!o.prop("readonly")) {
                        var t, n, a, i = e.which || e.keyCode;
                        A = o.val(), 8 === i || 46 === i || S && 127 === i ? (n = (t = o.caret()).begin, (a = t.end) - n == 0 && (n = 46 !== i ? function(e) { for (; 0 <= --e && !b[e];); return e }(n) : a = s(n - 1), a = 46 === i ? s(a) : a), m(n, a), h(n, a - 1), e.preventDefault()) : 13 === i ? g.call(this, e) : 27 === i && (o.val(r), o.caret(0, p()), e.preventDefault())
                    }
                }).on("keypress.mask", function(e) {
                    if (!o.prop("readonly")) {
                        var t, n, a, i = e.which || e.keyCode,
                            r = o.caret();
                        e.ctrlKey || e.altKey || e.metaKey || i < 32 || !i || 13 === i || (r.end - r.begin != 0 && (m(r.begin, r.end), h(r.begin, r.end - 1)), (t = s(r.begin - 1)) < j && (n = String.fromCharCode(i), b[t].test(n)) && (function(e) {
                            var t, n, a, i;
                            for (n = f(t = e); t < j; t++)
                                if (b[t]) {
                                    if (a = s(t), i = c[t], c[t] = n, !(a < j && b[a].test(i))) break;
                                    n = i
                                }
                        }(t), c[t] = n, d(), a = s(t), T ? setTimeout(function() { R.proxy(R.fn.caret, o, a)() }, 0) : o.caret(a), r.begin <= x && u()), e.preventDefault())
                    }
                }).on("input.mask paste.mask", function() {
                    o.prop("readonly") || setTimeout(function() {
                        var e = p(!0);
                        o.caret(e), u()
                    }, 0)
                }), i && T && o.off("input.mask").on("input.mask", function(e) {
                    var t = o.val(),
                        n = o.caret(),
                        a = function() { R.proxy(R.fn.caret, o, n.begin, n.begin)() };
                    if (A && A.length && A.length > t.length) {
                        for (p(!0); 0 < n.begin && !b[n.begin - 1];) n.begin--;
                        if (0 === n.begin)
                            for (; n.begin < y && !b[n.begin];) n.begin++;
                        setTimeout(a, 0)
                    } else {
                        var i = p(!0),
                            r = t.charAt(n.begin);
                        n.begin < j && (b[n.begin] ? b[n.begin].test(r) && n.begin++ : n.begin = i), setTimeout(a, 0)
                    }
                    u()
                }), p()
            })
        }
    })
});