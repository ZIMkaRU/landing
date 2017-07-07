/**
 * Created by voronkov_vs on 13.07.2016.
 */
'use strict';

import Modal from './Modal'

export default class Contact {
    constructor() {
        this._container = ".js_contact";
        this._$container = $(this._container);
        this._$btnSubmit = this._$container.find(".js_submit");
        this._mapFieldForm = "";

        this._$btnSubmit.on("click", e => {
            e.preventDefault();
            this.postContactAction(e)
        });
    }

    initProp($container) {
        this._mapFieldForm = new Map();

        this._mapFieldForm.set("name", $container.find(".js_name"));
        this._mapFieldForm.set("email", $container.find(".js_email"));
        this._mapFieldForm.set("phone", $container.find(".js_phone"));
    }

    getJSONData() {
        let data = {};

        for (let entry of this._mapFieldForm) {
            data[entry[0]] = entry[1].val();
        }

        return JSON.stringify(data);
    }

    jsValidation() {
        let state = false;
        for (let val of this._mapFieldForm.values()) {
            if (!val.closest(".has-feedback").hasClass("has-success")) {
                state = false;
                break
            } else {
                state = true;
            }
        }

        return state
    }

    renderMessageError(dataMessage) {
        dataMessage.forEach((item, i, arr) => {
            let state = false;
            let key = item.property_path;
            let message = item.message;

            for (let entry of this._mapFieldForm) {
                if (entry[0] == key) {
                    let container = entry[1].closest(".has-feedback");
                    state = true;

                    entry[1].attr("placeholder", message);
                    container.removeClass("has-success").addClass("has-error");
                    container.find(".error_text").text(message);
                }
            }

            if (!state) {
                console.log(`The error message in the properties of an entity are not displayed`);
                console.log(`Property: ${key}, message: ${message}`);
            }
        });
    }

    postContactAction(e) {
        let $container = $(e.currentTarget).closest(this._container);

        this.initProp($container);

        if (this.jsValidation()) $.ajax({
            type: "POST",
            url: Routing.generate('post_contact'),
            data: this.getJSONData(),
            dataType: 'json',
            success: (data, dataType) => {

                if (data.state) {
                    Modal.create("Спасибо за запрос<br>" +
                        "Контакты отправленны<br>" +
                        "В ближайшее время менеджер с Вами свяжется!",
                        "Состояние запроса");
                } else {
                    this.renderMessageError(JSON.parse(data.errors));
                }
            },
            error: (XMLHttpRequest, textStatus, errorThrown) => {
                Modal.create("Error : " + errorThrown,
                    "Состояние запроса");
            }
        });
    }
}