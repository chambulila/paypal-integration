<template>
	<button
		:type="buttonType"
		:disabled="isDisabled"
		:class="`px-4 py-2 items-center text-white transform rounded-lg shadow-sm hover:-translate-y-0.5 disabled:cursor-not-allowed disabled:text-tertiary disabled:bg-disabled disabled:border-gray-300 disabled:shadow-sm ${defaultBgColors}`"
		@click="$emit('click')"
		@submit="$emit('submit')">
		<slot />
	</button>
</template>

<script>
export default {
	name: 'PrimaryButton',

	props: {
		buttonType: {
			type: String,
			default: 'button'
		},
		disabled: {
			type: Boolean,
			default: false
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
