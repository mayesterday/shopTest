import Vue from 'vue'
// axios
import axios from '@/libs/axios'
// const domain = process.env.VUE_APP_API_BASEURL
// const api = axios.create({
// 	baseURL: domain,
// 	// domain
// 	// You can add your headers here
// })

export default function(Vue) {
    Vue.api = {
        async get(url) {
            try {

                let {
                    data: {
                        data
                    }
                } = await axios.get(url)
              
                return Promise.resolve(data)
            } catch (error) {

                console.error(error)
                return Promise.reject(error)
            }
        },
        /**
         * ทำใหม่แบ่บไม่ตัด data ออก ให้ return เต็ม
         * @param {String} url ไม่ตัด Data
         */
        async _get(url) {
            try {
                const data = await axios.get(url)
                return Promise.resolve(data)
            } catch (error) {
                if (error?.response?.headers?.requestid) {
                    $.gritter.add({
                        title: error?.response?.headers?.requestid,
                        text: url,
                        time: null,
                        class_name: 'my-sticky-class'
                    })
                }
                console.error(error)
                return Promise.reject(error)
            }
        },
        async post(url, request) {
            try {
                // let redule = coppyParam(request)
                // await checkDate(data)

                let {
                    data: {
                        data,
                        code,
                        errors
                    }
                } = await axios.post(url, request)

                if (data === "not select major data id") {
                    return Promise.reject(data)
                }

                if (code === 200 || code === 201 || code === 204) {
                    return Promise.resolve(data)
                } else {
                    return Promise.reject(data)
                }
            } catch (error) {
                if (error?.response?.headers?.requestid) {
                    $.gritter.add({
                        title: error?.response?.headers?.requestid,
                        text: url,
                        time: null,
                        class_name: 'my-sticky-class'
                    })
                }
                return Promise.reject(error)
            }
        },
        async patch(url, request) {
            try {
                let {
                    data: {
                        data
                    }
                } = await axios.patch(url, request)
                return Promise.resolve(data)
            } catch (error) {
                if (error?.response?.headers?.requestid) {
                    $.gritter.add({
                        title: error?.response?.headers?.requestid,
                        text: url,
                        time: null,
                        class_name: 'my-sticky-class'
                    })
                }
                return Promise.reject(error)
            }
        },
        async put(url, request) {
            // every method need to return status code to handle error each scenarios
            try {
                // let redule = coppyParam(request)
                // await checkDate(data)
                let {
                    data: {
                        data,
                        code
                    }
                } = await axios.put(url, request)
                return Promise.resolve(data)
            } catch (error) {
                if (error?.response?.headers?.requestid) {
                    $.gritter.add({
                        title: error?.response?.headers?.requestid,
                        text: url,
                        time: null,
                        class_name: 'my-sticky-class'
                    })
                }
                return Promise.reject(error)
            }
        },
        async del(url, request, confirmDelete = false) {
            try {
                /**
                 * Overwrite data
                 */
                request = {
                    params: request
                }

                if (confirmDelete) {
                    const result = await Vue.swal({
                        title: 'ยืนยันการดำเนินการ',
                        text: 'คุณต้องดำเนินการต่อใช่หรือไม่',
                        icon: 'warning',

                        showCancelButton: true,
                        confirmButtonText: 'ยืนยันการลบข้อมูล',
                        cancelButtonText: 'ยกเลิก',
                        customClass: {
                            confirmButton: 'btn btn-primary',
                            cancelButton: 'btn btn-outline-danger ml-1',
                        },
                        buttonsStyling: false,
                    })
                    /**
                     * If Confirm Delete data
                     */
                    if (result.value) {
                        let {
                            data: {
                                data,
                                errors
                            }
                        } = await axios.delete(url, request)
                        await Vue.swal({
                            icon: 'success',
                            title: 'ทำการลบข้อมูลสำเร็จ',
                            // text: 'Your file has been deleted.',
                            customClass: {
                                confirmButton: 'btn btn-success',
                            },
                        })
                        return Promise.resolve(data)
                    } else {
                        return Promise.resolve(data)
                    }
                }
                let {
                    data: {
                        data,
                        errors
                    }
                } = await axios.delete(url, request)
                return Promise.resolve(data)
            } catch (error) {
                if (error?.response?.headers?.requestid) {
                    $.gritter.add({
                        title: error?.response?.headers?.requestid,
                        text: url,
                        time: null,
                        class_name: 'my-sticky-class'
                    })
                }
                console.error(error)

                return Promise.reject(error)
            }
        },
        async createOrUpdate(url, form, popupMessage = '', fillCheck = 'id') {
            try {
                let resources = '';
                if (!form.id) {
                    resources = await axios.post(url, form)
                } else {
                    /**
                     * ตรวจสอบว่ามี / มาหรือไม่
                     */
                    if (!(url.slice(-1) === '/')) {
                        url = url + '/' + form[fillCheck]
                    } else {
                        url = url + form[fillCheck]
                    }

                    resources = await axios.patch(url, form)
                }
                if (popupMessage) {
                    if (form[fillCheck]) {
                        popupMessage = `ทำการแก้ไขข้อมูล ${popupMessage}`
                    } else {
                        popupMessage = `ทำการเพิ่มข้อมูล ${popupMessage}`
                    }
                    Vue.alert.respCreateOrUpdate(resources, popupMessage)
                }
                return resources
            } catch (error) {
                console.log(error)
            }
        },

    }

    Object.defineProperties(Vue.prototype, {
        api: {
            get() {
                return Vue.api
            }
        }
    })
}