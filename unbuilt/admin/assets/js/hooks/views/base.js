/**
 * wp.wordpoints.hooks.view.Base
 *
 * @class
 * @augments Backbone.View
 */
var hooks = wp.wordpoints.hooks,
	extend = hooks.util.extend,
	Base;

// Add a base view so we can have a standardized view bootstrap for this app.
Base = Backbone.View.extend( {

	// First, we let each view specify its own namespace, so we can use it as
	// a prefix for any standard events we want to fire.
	namespace: '_base',

	// We have an initialization bootstrap. Below we'll set things up so that
	// this gets called even when an extending view specifies an `initialize`
	// function.
	initialize: function ( options ) {

		// The first thing we do is to allow for a namespace to be passed in
		// as an option when the view is constructed, instead of forcing it
		// to be part of the prototype only.
		if ( typeof options.namespace !== 'undefined' ) {
			this.namespace = options.namespace;
		}

		if ( typeof options.reaction !== 'undefined' ) {
			this.reaction = options.reaction;
		}

		// Once things are set up, we call the extending view's `initialize`
		// function. It is mapped to `_initialize` on the current object.
		this.__child__.initialize.apply( this, arguments );

		// Finally, we trigger an action to let the whole app know we just
		// created this view.
		hooks.trigger( this.namespace + ':view:init', this );
	}

}, { extend: extend } );

module.exports = Base;
