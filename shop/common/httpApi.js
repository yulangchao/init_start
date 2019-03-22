/**
 * API接口配置文件
 */
module.exports = {
	home : {
		banner:"home/banner", // 首页banner 
		navlist:"home/navlist", // 首页导航
		juhusuan:"home/juhuasuanlist", // 首页聚划算推荐
	},
	common:{
		couponlist:"home/couponlist", // 公共加载商品
		config:"config/getinfo", // 获取服务端配置
		update:"config/update", // 检测更新 ,
		checkToken: 'token/check',
		refreshToken: 'token/refresh'
	},
	goods:{
		iteminfo:"items/goodsinfo", // 商品详情 加载 
	},
	member:{
		register: "user/register",
		sendcode: "sms/send",
		login: "user/login",
		resetpwd : "user/resetpwd",
		profile: "user/profile"
	}
}