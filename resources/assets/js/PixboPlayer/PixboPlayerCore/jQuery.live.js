/** 
 * Forward function jQuery.live()
 * Wrapper for newer jQuery.on()
 * Uses optimized selector context 
 * Only add if live() not already existing.
 * Information: The live() method was deprecated in jQuery version 1.7,
 *              and removed in version 1.9.
 *              Use the on() method instead.
 * Reason: Ticker-plugin uses live() @control, forward function instead of refactor plugin.
*/
if (typeof jQuery.fn.live == 'undefined' || !(jQuery.isFunction(jQuery.fn.live))) {
    jQuery.fn.extend({
        live: function (event, callback) {
            if (this.selector)
                jQuery(document).on(event, this.selector, callback);
        }
    });
}
