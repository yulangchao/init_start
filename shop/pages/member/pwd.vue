<template>

	<view class="pwdcontent">
		<view class="is-33vh has-mgt-10">
			<view class="is-flex is-column is-justify-center  is-align-center is-height-100">
				<image src="../../static/img/load.gif" mode="aspectFit" class="logoimg"></image>
			</view>
		</view>
		<view class="input-group">
			<view class="input-row border">
				<m-input class="is-input " clearable type="text" v-model="mobile" placeholder="请输入手机号 (北美手机,无须+1)"></m-input>
			</view>
			<view class="input-row border">
				<m-input class="is-input code-input" type="text" v-model="captcha" placeholder="请输入验证码"></m-input>
				<button type="button" class="codeimg" @tap='getVCode'>{{vcodeBtnName}}</button>
			</view>
			<view class="input-row border">
				<m-input class="is-input " displayable type="password" v-model="newpassword" placeholder="请输入密码"></m-input>
			</view>
		</view>
		<view class="btn-row registerbtn">
			<button type="primary" class="primary" @tap="resetpwd">修改密码</button>
		</view>
	</view>
</template>

<script>
	import {
		mapState,
		mapMutations
	} from 'vuex';
	import service from '../../service.js';
	import mInput from '../../components/m-input.vue';
	export default {
		components: {
			mInput
		},
		computed: {
			...mapState(['hasLogin', 'forcedLogin', 'userInfo'])
		},
		data() {
			return {
				mobile: '',
				vcodeBtnName: "获取验证码",
				countNum: 120,
				countDownTimer: null,
				captcha: '',
				newpassword: ''
			}
		},
		onLoad() {
			if (this.userInfo){
				console.log(this.userInfo);
				this.mobile = this.userInfo.mobile;
			}
		},
		methods: {
			...mapMutations(['login']),
			countDown: function() {
				if (this.countNum < 1) {
					clearInterval(this.countDownTimer);
					this.vcodeBtnName = "重新发送";
					return;
				}
				this.countNum--;
				this.vcodeBtnName = this.countNum + '秒重发';
			},
			getVCode() {
				// vcodeBtnName 可以阻止按钮被多次点击 多次发送 return 会终止函数继续运行
				if (this.vcodeBtnName != '获取验证码' && this.vcodeBtnName != '重新发送') {
					console.log(2);
					return;
				}

				this.$Request.get(this.$api.member.sendcode, {
					mobile: this.mobile,
					event: "resetpwd"
				}).then(res => {
					if (res.code == 1) {

						this.vcodeBtnName = "发送中...";
						// 与后端 api 交互，发送验证码 【自己写的具体业务代码】
						// 假设发送成功，给用户提示
						uni.showToast({
							title: '短信已发送，请注意查收',
							icon: "none"
						});
						// 倒计时
						this.countNum = 120;
						this.countDownTimer = setInterval(function() {
							this.countDown();
						}.bind(this), 1000);
					} else {
						uni.showToast({
							title: res.msg
						});
					}
				})

			},
			resetpwd() {
				if (this.mobile.length < 10) {
					uni.showToast({
						icon: 'none',
						title: '请输入正确的手机号'
					});
					return;
				}
				if (this.newpassword.length < 6) {
					uni.showToast({
						icon: 'none',
						title: '密码最短为 6 个字符'
					});
					return;
				}

				const data = {
					mobile: this.mobile,
					captcha: this.captcha,
					newpassword: this.newpassword
				}

				this.$Request.get(this.$api.member.resetpwd, data).then(res => {
					if (res.code == 1) {
						uni.showToast({
							icon: 'none',
							title: res.msg
						});
						setTimeout(() => {
							uni.navigateBack({
								delta: 1
							});
						}, 1000)

					} else {
						uni.showToast({
							icon: 'none',
							title: res.msg
						});
					}
				})

			},
			toMain(userName) {
				this.login(userName);
				/**
				 * 强制登录时使用reLaunch方式跳转过来
				 * 返回首页也使用reLaunch方式
				 */

				uni.reLaunch({
					url: '../index/index',
				});

			}
		}
	}
</script>

<style>
	page {
		min-height: 100%;
		background-color: #FFFFFF;
	}

	.pwdcontent {
		width: 85%;
		margin: 0 auto;
	}

	.logoimg {
		width: 200upx;
		height: 200upx;
		border-radius: 50%;
	}



	.iconfont {
		position: absolute;
		font-size: 40upx;
		right: 90upx;
		z-index: 999;
		width: 105upx;
		text-align: center;
		color: #353535;
		margin-top: -90upx;
		background: #fff;
		border-top-right-radius: 44upx;
		border-bottom-right-radius: 44upx;
		height: 80upx;
		line-height: 80upx;
	}

	.codeimg {
		position: absolute;
		font-size: 28upx;
		right: 60upx;
		z-index: 999;
		width: 200upx;
		text-align: center;

		color: #353535;
		margin-top: -114upx;
		background: white;
		border-top-right-radius: 44upx;
		border-bottom-right-radius: 44upx;
		height: 80upx;
		line-height: 80upx;
	}

	uni-button:after {
		border: none !important;
	}

	.registerbtn button {
		margin-top: 20upx;
		height: 88upx;
		width: 100%;
		line-height: 88upx;
		color: #ffffff;
		font-size: 32upx;
		border-radius: 44upx;
		outline: 0;
		display: block;
		margin: 0;
		font-family: inherit;
		background: #f35;
		opacity: 0.8;
	}

	button:after {
		border: 2upx solid #f2f2f2;
	}

	.has-mgt-80 {
		margin-top: 40upx;
	}

	.is-input {
		height: 88rpx;
		width: 100%;
		line-height: 88rpx;
		color: #353535;
		font-size: 32rpx;
		box-sizing: border-box;
		appearance: none;
		border: 2rpx solid #e5e5e5;
		box-shadow: none;
		border-radius: 44rpx;
		outline: 0;
		display: block;
		padding-left: 30rpx;
		font-family: inherit;
		background: #fff;
		resize: none;
		margin: 30upx 0;
	}
</style>
