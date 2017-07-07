/**
 * Created by voronkov_vs on 14.07.2016.
 */
export default class Modal {
    constructor() {
        this._$SelectorModal = "";
        this._$SelectorModalHeader = "";
        this._$SelectorModalBody = "";
    }

    static create(body, title) {
        this._$SelectorModal = $("#modal-state");
        this._$SelectorModalHeader = this._$SelectorModal.find("#modal-state-label");
        this._$SelectorModalBody = this._$SelectorModal.find(".js_modal-body");

        this._$SelectorModalHeader.html(title);
        this._$SelectorModalBody.html(body);
        this._$SelectorModal.modal('show');
        setTimeout(() => this._$SelectorModal.modal('hide'), 5000);
    }
}