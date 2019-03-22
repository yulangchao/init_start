<template>

	<view class="content">
		
		<view class="input-group">
			<view class="input-row border avatar-row">
				<image :src="avatar_url" class="avatar"></image> <button size="mini" @tap="crop">编辑图像</button> <text class=" grace-animate jackInTheBox">{{avatar_status}}</text>
			</view>
			<view class="input-row border">
				<m-input class="is-input " clearable type="text" v-model="nickname" placeholder="请输入昵称"></m-input>
			</view>
			<view class="input-row">
				<m-input class="is-input " clearable type="text" v-model="bio" placeholder="请输入个性签名"></m-input>
			</view>
		</view>
		<view class="btn-row registerbtn">
			<button type="primary" class="primary" @tap="changeprofile">修改个人信息</button>
		</view>
	</view>
</template>

<script>
	import {
		mapState,
		mapMutations
	} from 'vuex'

	import mInput from '../../components/m-input.vue';
	export default {
		onLoad() {
			if (!this.hasLogin) {
				uni.navigateTo({
					url: './login',
				});
			}
			
			this.nickname = this.userInfo.nickname;
			this.bio = this.userInfo.bio;
			this.avatar = this.userInfo.avatar;
			this.$eventHub.$on('fire',  (data) => {
				this.avatar_status = "头像未保存";
				uni.uploadFile({
					url: this.$configdata.APIHOST + 'common/upload', //仅为示例，非真实的接口地址
					filePath: data,
					name: 'file',
					formData: {
						'tmp_name': 'test'
					},
					success: (uploadFileRes) => {
						var res = JSON.parse(uploadFileRes.data);
						if (res.code == 1){
							this.avatar = res.data.url;
						}
						
					}
				});
			});
		},
		computed: {
			...mapState(['hasLogin', 'userInfo']),
			avatar_url() {
				if (this.hasLogin) {
					return this.$configdata.ROOTPATH + this.avatar;
				}
			}
		},
		components: {
			mInput
		},
		data() {
			return {
				nickname: '',
				bio: '',
				avatar: '',
				avatar_status: ''
			}
		},
		methods: {
			crop() {
				uni.navigateTo({
					url: './crop'
				})
			},
			changeprofile() {
				if (this.nickname.length == 0) {
					uni.showToast({
						icon: 'none',
						title: '昵称是必须的'
					});
					return;
				}
				
				var data = {
					nickname: this.nickname,
					bio: this.bio,
					avatar: this.avatar_status != "" ? this.avatar : this.userInfo.avatar,
					token: uni.getStorageSync('userToken')
				}	
				
				this.$Request.post(this.$api.member.profile, data).then(res => {
					if (res.code == 1) {
						uni.showToast({
							title: '修改成功'
						});
						this.userInfo.nickname = this.nickname;
						this.userInfo.bio = this.bio;
						this.userInfo.avatar = this.avatar;
						
						
						setTimeout(() => {
							uni.navigateBack({
								delta: 1
							});
						}, 1000)
						
						
						// 						this.navlist = res.data;
						// 						this.$SysCache.put("app_index_navlist",res.data,86400);
					} else {
						uni.showToast({
							title: res.msg
						});
					}
				})

			}
		}
	}
</script>

<style lang="scss">
	@import url("../../graceUI/animate.css");
	
	page {
		min-height: 100%;
		background-color: #FFFFFF;
	}
	
	.avatar-row{
		text-align: center;
		padding: 20px;
		.avatar{
			border-radius: 100%;
			width:200upx;
			height:200upx;
		}
		button{
			position: absolute;
			right: 30upx;
			background :#f35;
			color:white;
		}
		
		text{
			display: block;
			animation-iteration-count: 1;
			color:#f35;
		}
	}

	.content {
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
