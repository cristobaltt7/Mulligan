"use strict";
import { Card } from "./Card.js";
class Deck {
    constructor(name, commander) {
        this._name = name;
        this._commander = commander;
        this._decklist = new Map();
    }

    get name() {
        return this._name;
    }

    get commander() {
        return this._commander;
    }

    get decklist() {
        return this._decklist;
    }

    set name(name) {
        this._name = name;
    }

    set commander(commander) {
        this._commander = commander;
    }

    set decklist(decklist) {
        this._decklist = decklist;
    }

    addCard(card) {
        if (this._decklist.has(card)) {
            this._decklist.set(card, this._decklist.get(card.name) + 1);
        } else {
            this._decklist.set(card, 1);
        }
    }

    removeCard(card) {
        if (this._decklist.has(card.name)) {
            if (this._decklist.get(card.name) > 1) {
                this._decklist.set(card.name, this._decklist.get(card.name) - 1);
            } else {
                this._decklist.delete(card.name);
            }
        }
    }
}
export { Deck };