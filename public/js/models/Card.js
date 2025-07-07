"use strict";
class Card {
    constructor(name, type, image, manaCost) {
        this._name = name;
        this._type = type;
        this._image = image;
        this._manaCost = manaCost;
    }

    get name() {
        return this._name;
    }

    get type() {
        return this._type;
    }

    get image() {
        return this._image;
    }

    get manaCost() {
        return this._manaCost;
    }

    set name(name) {
        this._name = name;
    }

    set type(type) {
        this._type = type;
    }

    set image(image) {
        this._image = image;
    }

    set manaCost(manaCost) {
        this._manaCost = manaCost;
    }
    
}

export { Card };