import Vue from 'vue'
import App from './App'
import httpApi from './common/httpApi'
import HttpRequest from './common/httpRequest'
import HttpCache from './common/cache'
import store from './store'
import configdata from './common/config'

import loadMore from './components/uni-pro/load-more'

import graceHeader from "./graceUI/components/graceHeader.vue";
Vue.component('graceHeader', graceHeader);


Vue.config.productionTip = false
Vue.prototype.$api = httpApi
Vue.prototype.$Request = HttpRequest
Vue.prototype.$Sysconf = HttpRequest.config
Vue.prototype.$SysCache = HttpCache
Vue.prototype.$store = store
Vue.prototype.$configdata = configdata

App.mpType = 'app'

Vue.component('load-more',loadMore)
const app = new Vue({
    ...App
})
app.$mount()
