import { ref } from "vue";

export const authUser = ref(null);

export function setAuthUser(user) {
    authUser.value = user;
    console.log({ authUser: authUser.value });
}
