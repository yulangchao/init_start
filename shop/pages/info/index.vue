<template>
	<view class="s-page-wrapper jiu-page">
		<view class="main-title">
			<view class="menu-cat">
				<view class="span">
					<image
						src="http://cmsstatic.dataoke.com//web/nine_special/images/nine_title.svg?v=201902151532"
						class="is-response"
					></image>
				</view>
			</view>
		</view>
	</view>
</template>
<script>
export default {
	data() {
		return {
			nineNavTab:[
				{id:"1",name:"男装"},
				{id:"1",name:"女装"},
				{id:"1",name:"母婴"},
				{id:"1",name:"鞋包"},
				{id:"1",name:"数码配件"},
				{id:"1",name:"文娱车品"},
			],
			tabIndex:0
		};
	},
	onReady: function() {},
	onLoad: function() {},
	methods: {
		tapTab:function(index){
			console.log( index )
		}
	}
};
</script>
<style lang="scss">
@import '../../static/css/index.css';
</style>
