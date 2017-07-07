/**
 * Created by voronkov_vs on 12.03.2016.
 */
"use strict";

// Libs, plugins

// Styles

// Modules
import './frontend'
import Contact from './modules/Contact'

// Templates


// Document ready
$(function () {

    new Contact();

    // Отрисовка изо заглушек
    Holder.run();
});