<template>
	<a
		:href="linkRoute"
		:class="`px-4 py-2 flex gap-2 flex-nowrap items-center whitespace-nowrap text-white transform rounded-lg shadow-sm hover:-translate-y-0.5 disabled:cursor-not-allowed disabled:text-tertiary disabled:bg-disabled disabled:border-gray-300 disabled:shadow-sm ${defaultBgColors}  ${ 
			iconPosition === 'left' ? 'flex-row-reverse' : 'flex-row'}`"
		:disabled="isDisabled">
		{{ title }}
		<slot />
		<slot name="icon" />
	</a>
</template>

<script>
export default {
	name: 'ButtonWithIcon',

	props: {
		linkRoute: {
			type: String,
			default: '#'
		},
		
		title: {
			type: String,
			default: 'View'
		},
		disabled: {
			type: Boolean,
			default: false
		},
		iconPosition: {
			type: String,
			default: 'right'
		},
		defaultBgColors: {
			type: String,
			default: 'bg-gray-800 hover:bg-blue-900 active:bg-blue-900'
		}
	},

	data() {
		return {
			isDisabled: this.disabled
		};
	},

	watch: {
		disabled(newValue) {
			this.isDisabled = newValue;
		}
	}
};
</script>
