<template>
	<view class="s-page-wrapper">
		<view class="index-goods" v-if="loadGoods">
			<view class="swiper" v-if="goods.picture.length > 0">
				<swiper
					class="swiper-container"
					:autoplay="true"
					:interval="4000"
					:circular="true"
					:indicator-dots="true"
					indicator-active-color="#FC3F78"
					indicator-color="#cccccc"
				>
					<block v-for="item in goods.picture" :key="item">
						<swiper-item class="swiper-wrapper">
							<image lazy-load :src="item" mode="widthFix" class="is-response"></image>
						</swiper-item>
					</block>
				</swiper>
			</view>
			<view class="goods_info">
				<view class="title">
					<text>{{ goods.shopType }}</text>
					{{ goods.title }}
				</view>
				<view class="coupon-price s-row">
					<view class="price">
						券后价￥
						<text>{{ goods.yprice }}</text>
					</view>
					<view class="volume">已售{{ goods.volume }}件</view>
				</view>
				<view class="coupon-price s-row">
					<view class="yprice">
						原价￥
						<text>{{ goods.price }}</text>
					</view>
					<view class="tag-list">
						<view class="tag">
							<text class="iconfont icon-detail_icon_gou"></text>
							包邮
						</view>
						<view class="tag">
							<text class="iconfont icon-detail_icon_gou"></text>
							运费险
						</view>
					</view>
				</view>
			</view>
			<view class="goods_quan s-row">
				<view class="row getGoodsLink">
					<view class="is-col-16 money">
						<view>
							<text>20</text>
							元优惠券
						</view>
						<view class="date-coupon">使用期限:2019.02.22-2019.02.23</view>
					</view>
					<view class="is-col-8 name"><text>立即领券</text></view>
				</view>
				<image
					lazy-load
					src="../../static/img/goods/goods_quan.png"
					mode="widthFix"
					class="is-response"
				></image>
			</view>
			<view class="goods_desc">{{ goods.goods_desc }}</view>
			<view class="hr10"></view>
			<view class="goods_shop">
				<view class="info">
					<image
						lazy-load
						src="https://img.alicdn.com/imgextra//a5/2c/TB1Z8klKpXXXXcCXpXXSutbFXXX.jpg_310x310.jpg"
						mode="widthFix"
						class="is-response"
					></image>
					<view class="shop-text">
						<view class="shop-title">文苑图书专营店</view>
						<view class="col-main"><text class="iconfont icon-taobao"></text></view>
						<navigator class="shop-new" url="/pages/cate/index" open-type="switchTab" hover-class="">
							店铺所有优惠
							<text class="iconfont icon-youjiantou"></text>
						</navigator>
					</view>
				</view>
				<view class="goods-tab s-row">
					<view class="is-col-8">
						宝贝描述:4.8
						<text class="iconfont icon-ping lv_p"></text>
					</view>
					<view class="is-col-8">
						卖家服务:4.8
						<text class="iconfont icon-di lv_d"></text>
					</view>
					<view class="is-col-8">
						物流服务:4.8
						<text class="iconfont icon-gao lv_g"></text>
					</view>
				</view>
			</view>
			<view class="hr10"></view>
			<view class="goods_reco">
				<view class="goods-info-title">宝贝详情</view>
				<view class="imglist"  v-if="goods.goodsinfo.length > 0">
					<block  v-for="(item,index) in goods.goodsinfo" :key="index">
						<image lazy-load :src="item" mode="widthFix" class="is-response"></image>
					</block>
				</view>
			</view>
			<!-- 购买按钮 -->
			<view class="goods_shop_cart">
				<view class="cent s-row">
					<view class="is-col-4 is-center but" @tap="showShopCartBg('cart')">
						<view class="img">
							<image src="http://cmsstatic.dataoke.com//wap_new/main/images/detail_tab_share.svg?v=201902151532"></image>
						</view>
						分享
					</view>
					<view class="is-col-4 is-center but">
						<view class="img">
							<text class="iconfont icon-shoucang"></text>
						</view>
						收藏
					</view>
					<view class="is-col-16">
						<view class="btn s-row">
							<view class="is-col-10 tkl" @tap="shopCartShare('tklbuy')">口令购买</view>
							<view class="is-col-14 coupon-buy">领券购买</view>
						</view>
					</view>
				</view>	
			</view>
			
			<!-- 购买按钮 active-->
			<view v-if="shopCartBg" class="goods_shop_cart_bg" @tap="showShopCartBg('cart')" @touchmove.stop.prevent="moveHandleStop"></view>
			<view class="goods_share" v-bind:class="[shopCartBg ? 'active' : '','']">
				<view class="cent">
					<view class="" @tap="shopCartShare('tkl')">
						<text class="iconfont icon-kouling"></text>通过口令分享
					</view>
	<!-- 				<view class="" @tap="shopCartShare('picture')">
						<text class="iconfont icon-tupian"></text>通过图片分享
					</view> -->
					<text class="em"></text>
				</view>
			</view>
			
			<!-- 悬浮上拉 -->
			<view class="scroll_top" @tap="topScrollTap" v-bind:class="[scrollTop ? 'active' : '','']" style="bottom: 56px;">
				<text class="iconfont icon-shangla"></text>
			</view>

			<view class="navBarButtonBox">
				<!-- 顶部右侧菜单 -->
				<view v-if="navBarButton" class="goods_shop_cart_bg navBarButton" @tap="showShopCartBg('nav')" @touchmove.stop.prevent="moveHandleStop"></view>
				<view class="h_newlit" v-bind:class="[navBarButton ? 'active' : '','']">
					<view class="em">
						<view class="" @tap="navBarButtontO('home')">
							<text class="iconfont icon-shouye"></text>首页
						</view>
						<view class="" @tap="navBarButtontO('search')">
							<text class="iconfont icon-sousuo"></text>搜索
						</view>
						<view class="" @tap="navBarButtontO('kefu')">
							<text class="iconfont icon-kefu-"></text>客服
						</view>
						<view class="" @tap="navBarButtontO('member')">
							<text class="iconfont icon-wode"></text>我的
						</view>
					</view>
				</view>
			</view>
			<!-- 顶部右侧菜单 -->
			
			<!-- 淘口令分享 -->
			<simpleModal ref="simpleModalTkl" @maskClose="TklmaskClose">
				<view class="buy-box-title">复制分享文案</view>
				<view class="buy-box-center">
					<view class="code-cent">
						<div class="cente-text">
							<div>
								<view class="textarea">星火英语四级真题详解+标准预测试卷<br>【原价】36.8元<br>【券后】16.8元<br>【复制此信息打开手机淘宝即可查看并下单】￥ECAybu9BU41￥<br>【必买理由】分册定装，刷题方便，练习更轻松又高效，含10套真题+10套听力+5套预测+口语宝典+高频词汇卡等，独家app刷题好搭档，助你轻松过关【赠运费险】！</view>
							</div>
						</div>
						<view class="closeTips">点击非内容区域关闭弹窗~</view>
					</view>
					<view class="buy-btn-copy" v-bind:class="[copyTklStatus ? 'active' : '','']" @tap="copyTklWenAn">{{copyTklStatus?"复制成功":"一键复制"}}</view>
				</view>
			</simpleModal> 
			<!-- 淘口令分享 -->
			
			<!-- 淘口令购买 -->
			<simpleModal ref="simpleModalTklBuy" @maskClose="TklBuymaskClose">
				<view class="buy-box-center">
					<view class="code-cent" style="margin-top: 10px;">
						<div class="cente-text" style="height: auto;">
							<div>
								<view class="textarea" style="height: auto;">复制框内整段文字，打开【手淘APP】即可领券购买。￥ECAybu9BU41￥</view>
							</div>
						</div>
					</view>
					<view class="buy-btn-copy" v-bind:class="[copyTklStatus ? 'active' : '','']" @tap="copyTklWenAn">{{copyTklStatus?"复制成功":"一键复制"}}</view>
				</view>
			</simpleModal>
			<!-- 淘口令购买 -->
		</view>
		<view class="" v-if="!loadGoods">
			<view class="s-page">
				<view class="is-100vh is-flex is-column is-justify-center is-align-center ">
					<image
						src="../../static/img/load.gif"
						style="width:75px;height: 75px;"
						class="is-response"
						mode="widthFix"
					></image>
				</view>
			</view>
		</view>
	</view>
</template>

<script>
import simpleModal from '@/components/simple-pro/customModal.vue';
export default {
	data() {
		return {
			itemid: '',
			loadGoods: false,
			goods: [],
			shopCartBg:false,
			scrollTop:false,
			navBarButton:false,
			copyTklStatus:false,
		};
	},
	components:{
		simpleModal
	},
	onShow:function(){
		this.copyTklStatus = false;	
	},
	onLoad: function(e) {
		if (e.itemid) {
			this.itemid = e.itemid;
			this.loadGoodsInfo();
		} else {
			uni.navigateBack();
		}
	},
	onPageScroll:function(e){
		if(e.scrollTop > 200 ){
			this.scrollTop = true;
		}else{
			this.scrollTop = false; 
		}
	},
	onNavigationBarButtonTap:function(){
		this.navBarButton = !this.navBarButton; 
	},
	methods: {
		loadGoodsInfo: function() {
			this.$Request.post(this.$api.goods.iteminfo, { itemid: this.itemid }).then(res => {
				res = '{"code":200,"msg":"获取成功","data":{"picture":["https:\/\/img.alicdn.com\/imgextra\/i4\/2374358222\/O1CN01gPaCag2AbivnkWgww_!!2374358222.jpg","https:\/\/img.alicdn.com\/imgextra\/i1\/2899059632\/O1CN012L1VMqO37XtrF3G_!!2899059632.jpg","https:\/\/img.alicdn.com\/imgextra\/i4\/2374339304\/O1CN012IbHSUV4Yy33soL_!!2374339304.jpg","https:\/\/img.alicdn.com\/imgextra\/i4\/789372247\/O1CN011STAR30wqGPmfqv_!!789372247.jpg"],"title":"孙大欣复古麻花宽松套头网红毛衣","shopType":"淘宝","goods_desc":"【2万好评】经典麻花毛衣，舒适保暖，版型为宽松慵懒风，胖瘦都可以穿搭，内穿一个打底衫，一点也不觉得冷~","volume":1115,"price":125,"coupon_price":10,"storeInfo":{"mall_logo":"https:\/\/img.alicdn.com\/imgextra\/\/ad\/74\/TB16MTinW6qK1RjSZFmSut0PFXa.jpg_310x310.jpg","mall_name":"SUNDAXIN孙大欣 女装定制","mall_type":"taobao"},"goodsinfo":["https:\/\/img.alicdn.com\/imgextra\/i3\/789372247\/O1CN01nmbKew1STARqU8teG_!!789372247.jpg","https:\/\/img.alicdn.com\/imgextra\/i3\/789372247\/O1CN016zVTM51STAR8A6fXm_!!789372247.jpg","https:\/\/img.alicdn.com\/imgextra\/i4\/789372247\/O1CN01EQ3qnK1STAR6yXCk2_!!789372247.jpg","https:\/\/img.alicdn.com\/imgextra\/i4\/789372247\/O1CN01btuiIv1STAR5wAfEh_!!789372247.jpg","https:\/\/img.alicdn.com\/imgextra\/i2\/789372247\/O1CN01NAysN71STAR8We9X6_!!789372247.jpg","https:\/\/img.alicdn.com\/imgextra\/i2\/789372247\/O1CN01MZ2VMi1STAR8KeTSP_!!789372247.jpg","https:\/\/img.alicdn.com\/imgextra\/i3\/789372247\/O1CN01rs1w1z1STAR7tN2BN_!!789372247.jpg","https:\/\/img.alicdn.com\/imgextra\/i4\/789372247\/O1CN01tOID3d1STAR6yXsQA_!!789372247.jpg"]},"time":1553198459}'
				res = JSON.parse(res)
				if (res.code == 200) {
					if (res.data.yprice == undefined) {
						res.data.yprice = res.data.price - res.data.coupon_price;
					}
					this.goods = res.data;
					this.loadGoods = true;
				} else {
					uni.navigateBack();
				}
			});
		},
		moveHandleStop:function(){
			console.log("111")
		},
		showShopCartBg:function(type){
			if(type == "cart") {
				this.shopCartBg = !this.shopCartBg;
			}
			if(type == "nav") {
				this.navBarButton = !this.navBarButton;
			}	
		},
		topScrollTap:function(){
			uni.pageScrollTo({
				scrollTop: 0,
				duration: 300
			});
		},
		navBarButtontO:function(type){
			console.log(type);
		},
		shopCartShare:function(type){
			// tkl = 淘口令  picture = 图片
			if(type == "tkl"){
				this.showShopCartBg("cart"); // 隐藏弹出的内容
				this.copyTklStatus = false;
				this.$refs.simpleModalTkl.show({
					showConfirmButton:false,
				}); 
			}else if(type == "tklbuy"){
				// 淘口令购买
				this.copyTklStatus = false;
				this.$refs.simpleModalTklBuy.show({
					showConfirmButton:false,
				}); 
			}
		},
		TklmaskClose:function(e){
			this.$refs.simpleModalTkl.hide();
			this.copyTklStatus = false;
		},
		copyTklWenAn:function(){
			uni.setClipboardData({
				data:"复制内容测试！",
				success:(r=>{
					this.copyTklStatus = true;
				})
			})
		},
		TklBuymaskClose:function(){
			this.$refs.simpleModalTklBuy.hide();
			this.copyTklStatus = false;
		}
	}
};
</script>

<style>
@import '../../static/css/index.css';
.swiper-container {
	min-height: 100vw;
}
.swiper-wrapper {
	width: 100%;
}
</style>
