/*
 Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 For licensing, see LICENSE.html or http://ckeditor.com/license
 */

/*
 * This file is used/requested by the 'Styles' button.
 * The 'Styles' button is not enabled by default in DrupalFull and DrupalFiltered toolbars.
 */
if ( typeof (CKEDITOR) !== 'undefined') {
  CKEDITOR.addStylesSet('drupal', [
    {
      name : 'Big',
      element : 'big'
    }, {
      name : 'Small',
      element : 'small'
    },

    /* Object Styles */

    {
      name : 'Image Left',
      element : 'img',
      attributes : {
        'class' : 'image-align-left'
      }
    }, {
      name : 'Image Centered',
      element : 'img',
      attributes : {
        'class' : 'image-align-center'
      }
    }, {
      name : 'Image Right',
      element : 'img',
      attributes : {
        'class' : 'image-align-right'
      }
    }, {
      name : 'Table header',
      element : 'table',
      attributes : {
        'class' : 'specsheet'
      }
    }, {
      name : 'Table cell header',
      element : 'td',
      attributes : {
        'class' : 'header'
      }
    }, {
      name : 'Table cell feat',
      element : 'td',
      attributes : {
        'class' : 'feat'
      }
    }
  ]);
}