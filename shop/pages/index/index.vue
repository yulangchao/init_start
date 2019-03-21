<template>
	<view class="index-content">

		<!-- 搜索板块 -->
		<view class="index-header">
			<view class="icon_header">
				<view class="index-search" @tap="toSearchIndex">
					<view class="icon_search">
						<text class="iconfont icon-search"></text>
						<text>请输入您需要搜索的商品名称</text>
					</view>
				</view>
				<view class="icon_suji" @tap="toZujiIndex">
					<text class="iconfont icon-zuji"></text>
				</view>
			</view>
		</view>
		<!-- 搜索板块 -->

		<!-- banner板块 -->
		<view class="index-banner">
			<view class="swiper" v-if="banner.length > 0">
				<swiper class="swiper-container" :autoplay="true" :interval="4000" :circular="true" :indicator-dots="true"
				 indicator-active-color="#FC3F78" indicator-color="#cccccc">
					<block v-for="(item,index) in banner" :key="index">
						<swiper-item class="swiper-wrapper">
							<image :src="item.image" mode="widthFix"></image>
						</swiper-item>
					</block>
				</swiper>
			</view>
		</view>
		<!-- banner -->

		<!-- 导航栏板块 -->
		<view class="index-navlist s-grids has-bg-white has-pdtb-10" v-if="navlist.length > 0">
			<view class="is-col-1-5 is-center" v-for="(nav,index) in navlist" :key="index" @tap="toNavList(nav.url,nav.title)">
				<view class="has-pdtb-5">
					<image :src="nav.image" mode="widthFix"></image>
					<view class="is-size-14">{{nav['title']}}</view>
				</view>
			</view>
		</view>
		<!-- 导航栏板块 -->

		<!-- 聚拼团板块 -->
		<view class="home_ant_juhuasuan has-bg-white" v-if="juhuasuanlist.length > 0">
			<view class="juhuasuan-tab s-row">
				<text class="fl-jutext">聚拼团</text>
				<text class="fr-jutext">查看更多拼团</text>
			</view>
			<view class="s-row juhuasuan-list">
				<view class="juhuasuan-list-goods" v-for="(item,index) in juhuasuanlist" :key="index" @tap="toGoodsInfo(item.itemid)">
					<view class="image">
						<image :src="item.picture" mode="widthFix"></image>
						<view class="name">
							<text class="pinname">￥{{item.price}}</text>
							<text class="price"></text>
						</view>
					</view>

				</view>
			</view>
		</view>
		<!-- 聚拼团板块 -->

		<!-- 领券直播 -->
		<view class="index-coupon has-bg-white has-pd-10">
			<view class="coupon-tab s-row">
				<text class="fl-jutext">领券直播</text>
				<text class="fr-jutext">专享超值优惠券</text>
			</view>
			<view class="goods-list" v-if="couponlist.length > 0">
				<view class="coupon-page s-row" v-for="(item,index) in couponlist" :key="index" @tap="toGoodsInfo(item.itemid)">
					<view class="image">
						<image :src="item.picture"></image>
					</view>
					<view class="content">
						<view class="title">{{item.title}}</view>
						<view class="num s-row">
							<text class="tmprice"> 天猫价 ¥{{item.price}}</text>
							<text class="volume">已售{{item.volume}}件</text>
						</view>
						<view class="money s-row">
							<text class="coupon-price">券后价<text>¥{{item.yprice}}</text></text>
							<text class="quan">
								<i></i>{{item.coupon}}元券<i></i>
							</text>
						</view>
					</view>
				</view>
			</view>
		</view>
		<!-- 领券直播 -->
		
		<!-- 加载更多提示 -->
		<view class="s-col is-col-24" v-if="couponlist.length > 0">
			<load-more :loadingType="loadingType" :contentText="contentText"></load-more>
		</view>
		<!-- 加载更多提示 -->
		
	</view>
</template>

<script>
	export default {
		data() {
			return {
				banner: [],
				navlist: [],
				juhuasuanlist: [],
				couponlist: [],
				page: 1,
				loadingType: 0,
				contentText: {
					contentdown: "上拉显示更多",
					contentrefresh: "正在加载...",
					contentnomore: "没有更多数据了"
				}
			}
		},
		methods: {
			loadBanner: function(Refresh) {
				var indexBanner = this.$SysCache.get("app_index_banner");
				if(indexBanner && Refresh == undefined ){
					this.banner  = indexBanner;
				}else{
					this.$Request.post(this.$api.home.banner).then(res => {
						res = '{"code":200,"msg":"获取成功","data":[{"image":"https:\/\/img.alicdn.com\/imgextra\/i4\/2508158775\/O1CN01cwwomF2EgzySqHw17_!!2508158775.jpg","title":"精选","url":"#"},{"image":"https:\/\/img.alicdn.com\/imgextra\/i1\/2508158775\/O1CN015yFAP22EgzyPY4cCN_!!2508158775.jpg","title":"精选","url":"#"},{"image":"https:\/\/img.alicdn.com\/imgextra\/i4\/2053469401\/O1CN01vm11kZ2JJhuTYCmRk-2053469401.jpg","title":"精选","url":"#"}],"time":1553194434}';
						res = JSON.parse(res);
						if (res.code == 200) {
							this.banner = res.data;
							this.$SysCache.put("app_index_banner",res.data,43200);
						}
					})
				}
			},
			loadNavList: function() {
				var indexNav = this.$SysCache.get("app_index_navlist");
				if(indexNav){
					this.navlist = indexNav;
				}else{
					this.$Request.post(this.$api.home.navlist).then(res => {
						res = '{"code":200,"msg":"获取成功","data":[{"image":"https:\/\/img.alicdn.com\/imgextra\/i1\/2053469401\/TB2G1wjoBnTBKNjSZPfXXbf1XXa-2053469401.png","title":"疯抢排行","url":"#"},{"image":"https:\/\/img.alicdn.com\/imgextra\/i2\/2053469401\/TB2Z1Qso7UmBKNjSZFOXXab2XXa-2053469401.png","title":"咚咚抢","url":"#"},{"image":"https:\/\/img.alicdn.com\/imgextra\/i3\/2053469401\/TB2do7GoVooBKNjSZFPXXXa2XXa-2053469401.png","title":"每日半价","url":"#"},{"image":"https:\/\/img.alicdn.com\/imgextra\/i1\/2053469401\/TB2qYeWoRjTBKNjSZFuXXb0HFXa-2053469401.png","title":"折上折","url":"#"},{"image":"https:\/\/img.alicdn.com\/imgextra\/i1\/2053469401\/O1CN012JJhsPlAS4fsv7s-2053469401.png","title":"聚拼团","url":"#"}],"time":1553194434}'
						
						res = JSON.parse(res);
						if (res.code == 200) {
							this.navlist = res.data;
							this.$SysCache.put("app_index_navlist",res.data,86400);
						}
					})	
				}
			},
			loadJuhuasuanlist: function() {
				this.$Request.post(this.$api.home.juhusuan).then(res => {
					res = '{"code":200,"msg":"获取成功","data":[{"picture":"http:\/\/gju3.alicdn.com\/tps\/i4\/O1CN01GSuoqq2BBRpIlLwni_!!1-juitemmedia.gif_480x480.jpg","price":"125.1","itemid":"11"},{"picture":"http:\/\/gju2.alicdn.com\/tps\/i1\/O1CN01M8bqgQ246gOeiSzKM_!!0-juitemmedia.jpg_480x480.jpg","price":"12.5","itemid":"22"},{"picture":"http:\/\/gju4.alicdn.com\/tps\/i2\/720750381\/O1CN01e6gyue1EgXNdnIGzx_!!720750381.jpg_480x480.jpg","price":"22.5","itemid":"33"},{"picture":"http:\/\/gju3.alicdn.com\/tps\/i4\/0\/TB2QvYUaAfb_uJkSndVXXaBkpXa_!!0-juitemmedia.jpg_480x480.jpg","price":"106.2","itemid":"44"}],"time":1553194434}'
					res = JSON.parse(res);
					if (res.code == 200) {
						this.juhuasuanlist = res.data;
					}
				})
			},
			loadCouponList: function(type) {
				this.loadingType = 1; 
				this.$Request.post(this.$api.common.couponlist, {
					page: this.page
				}).then(res => {
					this.loadingType = 0; 
					
					
					res = '{"code":200,"msg":"获取成功","data":[{"picture":"http:\/\/gju3.alicdn.com\/tps\/i4\/O1CN01GSuoqq2BBRpIlLwni_!!1-juitemmedia.gif_480x480.jpg","price":"125.1","itemid":"11","title":"大牌晶大牌晶钻推拉口红大牌晶钻推拉口红钻推拉口红","coupon":"10","volume":"3.4万","yprice":"92.5"},{"picture":"http:\/\/gju2.alicdn.com\/tps\/i1\/O1CN01M8bqgQ246gOeiSzKM_!!0-juitemmedia.jpg_480x480.jpg","price":"12.5","itemid":"22","title":"小迷糊玻尿酸黑面膜共发42片 玻尿酸黑面膜共发42片","coupon":"10","volume":"3.4万","yprice":"92.5"},{"picture":"http:\/\/gju4.alicdn.com\/tps\/i2\/720750381\/O1CN01e6gyue1EgXNdnIGzx_!!720750381.jpg_480x480.jpg","price":"22.5","itemid":"33","title":"美颜秘美颜秘笈大牌晶钻推拉口红笈大牌晶钻推拉口红","coupon":"10","volume":"3.4万","yprice":"92.5"},{"picture":"http:\/\/gju3.alicdn.com\/tps\/i4\/0\/TB2QvYUaAfb_uJkSndVXXaBkpXa_!!0-juitemmedia.jpg_480x480.jpg","price":"106.2","itemid":"44","title":"9韩瑟护肤套装任选4件只要29.9韩瑟护肤套装","coupon":"10","volume":"3.4万","yprice":"92.5"},{"picture":"http:\/\/gju3.alicdn.com\/tps\/i4\/0\/TB2QvYUaAfb_uJkSndVXXaBkpXa_!!0-juitemmedia.jpg_480x480.jpg","price":"106.2","itemid":"44","title":"冈本 超薄003+SKIN组合避孕套SKIN组合避孕套","coupon":"10","volume":"3.4万","yprice":"92.5"}],"time":1553194434}'
					res = JSON.parse(res);
					if (res.code == 200) {
						if (this.page == 1) {
							this.couponlist = [];
						}
						res.data.forEach(d => {
							this.couponlist.push(d);
						})
					}else{
						this.loadingType = 2; 
					}
					if (type == "Refresh") {
						uni.stopPullDownRefresh(); // 停止刷新
					}
					setTimeout(t=>{
						this.loadBanner("Refresh"); // 当首页数据加载完毕后 刷新banner
					},1000); 
				}).catch(err=>{
// 					this.loadingType = 2; 
// 					this.contentText.contentnomore = "网络繁忙，请稍后再试"
				})
			},
			toNavList: function(url, title) {
				uni.showToast({
					title: title,
					mask: false,
					duration: 1500,
					icon: "none"
				});
			},
			toGoodsInfo: function(itemid) {
				uni.navigateTo({
					url:"/pages/detail/goodsinfo?itemid="+itemid,
				})
			},
			toSearchIndex:function(){
				uni.navigateTo({
					url:"/pages/search/index"
				})
			},
			toZujiIndex:function(){
				uni.showToast({
					title: "去足迹页面",
					mask: false,
					duration: 1500,
					icon: "none"
				});
			}
		},
		onReady:function(){
			this.loadCouponList();
		},
		onLoad: function() {
			this.loadBanner();
			this.loadNavList();
			this.loadJuhuasuanlist();
		},
		onReachBottom: function() {
			this.page = this.page + 1;
			this.loadCouponList();
		},
		onPullDownRefresh: function() {
			this.page = 1;
			this.loadJuhuasuanlist();
			this.loadCouponList("Refresh");
		}
	}
</script>

<style>
	@import "../../static/css/index.css";
</style>
