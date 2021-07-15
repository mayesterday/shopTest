import Vue from 'vue'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'
const self = Vue

const text_array = [{}]
const toast = (title, text, variant, icon) => {
	self.$toast.clear()
	self.$toast({
		component: ToastificationContent,
		position: 'top-right',
		props: {
			title,
			icon,
			variant,
			text,
		},
	})
}

export default function(Vue) {
  Vue.alert = {
    /**
     * จัดการ Response ที่เป็นการเชื่อมต่อกับ Server
     * @param {Object} data ข้อมูลตอบกลับจาก server
     * @param {String} text ข้อความที่ต้องการแสดง
     */
    respCreateOrUpdate(data, text) {
      if (data.data.errors) {
        toast('Response Success', text, 'success', 'outline-danger')
      } else {
        toast('Response Error',text, 'danger', 'outline-danger')
      }
    },

    success(obj) {
      const title = obj.title ?? 'Success'
      const text = obj.text
			toast(title, text, 'success', 'outline-danger')
    },

    validator(obj = {title:null,text:null}) {
			const title = obj.title ?? 'Form Validate'
      const text = obj.text ?? 'กรุณากรอกข้อมูล ที่มีเครื่องหมาย * ห้ามเป็นค่าว่าง'
			toast(title, text, 'danger', 'outline-danger')
    },
    clear() {
      self.$toast.clear()
      },
        error(obj = {title:null,text:null}) {
			const title = obj.title ?? 'Form Validate'
      const text = obj.text ?? 'กรุณากรอกข้อมูล ที่มีเครื่องหมาย * ห้ามเป็นค่าว่าง'
			toast(title, text, 'danger', 'outline-danger')
    },
    async confirmDelete(obj) {
        try {
          const customText = {
            title: 'ยืนยันการลบข้อมูล', text: 'คุณต้องการลบข้อมูลนี้',
            btnConfirmText :'ยืนยัน',
            btnCancelText:'ยกเลิก',
            ...obj
          }

          const _action = await self.swal({
            title: customText.title,
            icon: 'warning',
            html:customText.text,
            showCloseButton: true,
            showCancelButton: true,
            focusConfirm: false,
            confirmButtonText: customText.btnConfirmText,
            cancelButtonText: customText.btnCancelText,
            confirmButtonAriaLabel: 'Thumbs up, great!',
            cancelButtonAriaLabel: 'Thumbs down',
            customClass: {
              confirmButton: 'btn btn-outline-success',
              cancelButton: 'btn btn-outline-danger ml-1',
            },
            buttonsStyling: false,
          })
          if (_action.value) {
            return true
          }
          return false

        } catch (error) {
         return error
        }
    }


  }

	Object.defineProperties(Vue.prototype, {
		alert: {
			get() {
				return Vue.alert
			},
		},
	})
}
