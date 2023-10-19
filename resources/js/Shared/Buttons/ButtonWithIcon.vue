<template>
	<button
		:type="buttonType"
		:class="`px-4 py-2 flex gap-2 items-center whitespace-nowrap text-white transform rounded-lg shadow-sm hover:-translate-y-0.5 disabled:cursor-not-allowed disabled:text-tertiary disabled:bg-disabled disabled:border-gray-300 disabled:shadow-sm ${defaultBgColors}  ${ 
			iconPosition === 'left' ? 'flex-row-reverse' : 'flex-row'
		}`"
		:disabled="isDisabled"
		@click="$emit('click')"
		@submit="$emit('submit')">
		<slot />
		<slot name="icon" />
	</button>
</template>

<script>
export default {
	name: 'ButtonWithIcon',

	props: {
		buttonType: {
			type: String,
			default: 'button'
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
