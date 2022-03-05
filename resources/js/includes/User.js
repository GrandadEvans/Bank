const {store} = require("../vue/vueComponents");
const _ = require('lodash');

export default class User {
    badges = {};
    email;
    name;
    loggedIn;

    constructor() {
        let details = this.getJsonDetails();

        if (this.isUserLoggedIn()) {
            try {
                this.email = details.email;
                this.name = details.name;
                this.loggedIn = true;
            } catch (error) {
                console.error(error);
            }

            return this;
        } else {
            this.loggedIn = false;
            this.badges = {};
            this.name = null;
            this.email = null;
        }
    }

    login() {}

    logout() {}

    register() {}

    htmlDetails(tag = 'user', attrribute = 'content') {
        let userDetails;

        try {
            userDetails = document.querySelector("meta[name='" + tag + "']").getAttribute(attrribute);
        } catch(error) {
            console.error(error);
        }

        return userDetails;
    }

    getJsonDetails() {
        let json;

        try {
            json = JSON.parse(this.htmlDetails());
        } catch(error) {
            console.error(error);
        }

        return json;
    }

    badges() {
        let all;

        try {
            badges = this.get('badges');
        } catch (error) {
            console.error(error);
        }

        this.badges = badges;
        return badges;
    }

    isUserLoggedIn() {
        try {
            let details = this.htmlDetails();
            if (details === "null") {
                return false;
            }
            return true;
        } catch (error) {
            console.error(error);
        }
    }

    logData() {
        if (this.loggedIn()) {
            console.groupCollapsed('User Details');
            console.info('User', User);
            console.info('User Badges', User.badges);
            console.groupEnd();
        } else {
            console.log("No user: currently logged out");
        }
    }

}
