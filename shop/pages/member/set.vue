<template>
	<view>
		<view class="main-title">
			<view class="menu-cat">
				<view class="span">
					<image src="http://cmsstatic.dataoke.com//web/nine_special/images/nine_title.svg?v=201902151532" class="is-response"></image>
				</view>
			</view>
		</view>
		<graceHeader :imgurl="avatar_url" :title="userInfo.nickname" :desc="userInfo.bio"></graceHeader>

		<view class="list">
			<view class="li" hover-class="hover" @tap="changeprofile">
				<view class="icon">
					<image :src="'../../static/HM-PersonalCenter/sever/profile.png'"></image>
				</view>
				<view class="text">修改个人信息</view>
				<image class="to" src="../../static/HM-PersonalCenter/to.png"></image>
			</view>
			<view class="li" hover-class="hover" @tap="resetpwd">
				<view class="icon">
					<image :src="'../../static/HM-PersonalCenter/sever/lock.png'"></image>
				</view>
				<view class="text">修改密码</view>
				<image class="to" src="../../static/HM-PersonalCenter/to.png"></image>
			</view>
			<view class="li" hover-class="hover">
				<view class="icon">
					<image :src="'../../static/HM-PersonalCenter/sever/email.png'"></image>
				</view>
				<view class="text">修改邮箱</view>
				<image class="to" src="../../static/HM-PersonalCenter/to.png"></image>
			</view>
		</view>

		<view class="list">
			<view class="li" hover-class="hover">
				<view class="icon">
					<image :src="'../../static/HM-PersonalCenter/sever/language.png'"></image>
				</view>
				<view class="text">语言</view>
				<switch checked style='float:right'></switch>
			</view>
			<view class="li" hover-class="hover">
				<view class="icon">
					<image :src="'../../static/HM-PersonalCenter/sever/notification.png'"></image>
				</view>
				<view class="text">推送</view>
				<switch checked style='float:right'></switch>
			</view>
		</view>


		<view class="list">
			<view class="li" hover-class="hover" @tap="bindLogout">
				<view class="icon">
					<image :src="'../../static/HM-PersonalCenter/sever/logout1.png'"></image>
				</view>
				<view class="text">退出登录</view>
				<image class="to" src="../../static/HM-PersonalCenter/to.png"></image>
			</view>
		</view>



		<!-- 		<view class="grace-list grace-bg-white grace-common-mt">
			<view class='items'>
				<view class="title">认证<text>已认证</text></view>
				<view class="arrow-right"></view>
			</view>
			<view class='items'>
				<view class="title">
				  通知
				  <switch checked style='float:right'></switch>
				</view>
				<view class="arrow-right"></view>
			</view>
		</view> -->
	</view>
</template>
<script>
	import {
		mapState,
		mapMutations
	} from 'vuex'

	export default {
		computed: {
			...mapState(['hasLogin', 'forcedLogin', 'userInfo']),
			avatar_url() {
				if (this.hasLogin) {
					return this.$configdata.ROOTPATH + this.userInfo.avatar;
				}
			}
		},
		onLoad() {
			//加载
			if (!this.hasLogin) {
				uni.navigateTo({
					url: './login',
				});
			}
		},
		methods: {
			...mapMutations(['logout']),
			bindLogout() {


				this.logout();
				uni.removeStorageSync('userInfo');
				uni.removeStorageSync('userToken');
				/**
				 * 如果需要强制登录跳转回登录页面
				 */
				uni.switchTab({
					url: '../member/index',
				});
			},
			resetpwd() {
				uni.navigateTo({
					url: './pwd',
					animationType: 'pop-in',
					animationDuration: 200
				})
			},
			changeprofile() {
				uni.navigateTo({
					url: './profile',
					animationType: 'pop-in',
					animationDuration: 200
				})
			}
		}
	}
</script>
<style lang="scss">
	@import '../../static/css/index.css';

	page {
		background-color: #f1f1f1
	}

	.list {
		width: 100%;
		border-bottom: solid 26upx #f1f1f1;

		.li {
			background: #fff;
			width: 92%;
			height: 100upx;
			padding: 0 4%;
			border-bottom: solid 1upx #e7e7e7;
			display: flex;
			align-items: center;

			&.noborder {
				border-bottom: 0
			}

			.icon {
				flex-shrink: 0;
				width: 50upx;
				height: 50upx;

				image {
					width: 50upx;
					height: 50upx
				}
			}

			.text {
				padding-left: 20upx;
				width: 100%;
				color: #666
			}

			.to {
				flex-shrink: 0;
				width: 40upx;
				height: 40upx
			}
		}
	}
</style>
