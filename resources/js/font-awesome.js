/*
 * More information on styling etc of icons with Vue can be seen here
 * https://fontawesome.com/docs/web/use-with/vue/style
 */
import {config, library} from '@fortawesome/fontawesome-svg-core'
/* import specific icons */
import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome'
import {fas} from '@fortawesome/free-solid-svg-icons'
import {fab} from '@fortawesome/free-brands-svg-icons'
import {far} from '@fortawesome/free-regular-svg-icons'

library.add(fas, fab, far)

/* add font awesome icon component */
Vue.component('font-awesome-icon', FontAwesomeIcon)

/* Do a bit of additional config */
config.observeMutations = true;
config.autoA11y = true;
