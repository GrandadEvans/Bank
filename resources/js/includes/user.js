let User = function () {
    return JSON.parse(document.querySelector("meta[name='user']").getAttribute('content'));
};

User.prototype.get = function (field = null) {
    let obj = this.raw;
    if (null !== field) {
        try {
            return obj.field;
        } catch (e) {
            console.error(e);
        }
    }
    return obj;
};

User.prototype.badges = function (...vars) {
    let badges = User.get('badges')
    return badges;
}
export default User();
