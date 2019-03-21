<template>
	<view class="m-input-view">
		<input :focus="focus_" :type="inputType" :value="value" @input="onInput" class="m-input-input" :placeholder="placeholder"
		 :password="type==='password'&&!showPassword" @focus="onFocus" @blur="onBlur" />
		<!-- 优先显示密码可见按钮 -->
		<view v-if="clearable_&&!displayable_&&value.length" class="m-input-icon">
			<m-icon color="#666666" type="clear" size="20" @click="clear"></m-icon>
		</view>
		<view v-if="displayable_" class="m-input-icon">
			<m-icon :color="showPassword?'#666666':'#cccccc'" type="eye" size="20" @click="display"></m-icon>
		</view>
	</view>
</template>

<script>
	import mIcon from './m-icon/m-icon.vue'

	export default {
		components: {
			mIcon
		},
		props: {
			/**
			 * 输入类型
			 */
			type: String,
			/**
			 * 值
			 */
			value: String,
			/**
			 * 占位符
			 */
			placeholder: String,
			/**
			 * 是否显示清除按钮
			 */
			clearable: {
				type: [Boolean, String],
				default: false
			},
			/**
			 * 是否显示密码可见按钮
			 */
			displayable: {
				type: [Boolean, String],
				default: false
			},
			/**
			 * 自动获取焦点
			 */
			focus: {
				type: [Boolean, String],
				default: false
			}
		},
		model: {
			prop: 'value',
			event: 'input'
		},
		data() {
			return {
				/**
				 * 显示密码明文
				 */
				showPassword: false,
				/**
				 * 是否获取焦点
				 */
				isFocus: false
			}
		},
		computed: {
			inputType() {
				const type = this.type
				return type === 'password' ? 'text' : type
			},
			clearable_() {
				return String(this.clearable) !== 'false'
			},
			displayable_() {
				return String(this.displayable) !== 'false'
			},
			focus_() {
				return String(this.focus) !== 'false'
			}
		},
		methods: {
			clear() {
				this.value = ''
			},
			display() {
				this.showPassword = !this.showPassword
			},
			onFocus() {
				this.isFocus = true
			},
			onBlur() {
				this.$nextTick(() => {
					this.isFocus = false
				})
			},
			onInput(e) {
				this.$emit('input', e.target.value)
			}
		}
	}
</script>

<style>
	.m-input-view {
		width: 100%;
		height: 88upx;
		width: 100%;
		line-height: 88upx;
		color: #353535;
		font-size: 32upx;
		box-sizing: border-box;
		appearance: none;
		border: 2upx solid #e5e5e5;
		box-shadow: none;
		border-radius: 44upx;
		outline: 0;
		display: block;
		padding-left: 30upx;
		font-family: inherit;
		background: #fff;
		resize: none;
		margin: 30upx 0;

	}

	input {
		height: 42px;
	}

	.m-input-input {
		flex: 1;
		width: 100%;

	}

	.m-input-icon {
		width: 20px;
		margin-top: -90upx;
		position: absolute;
		right: 80upx;
		z-index: 100000;
	}
</style>
