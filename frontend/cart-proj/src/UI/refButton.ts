import {h} from "vue";
import { ref } from 'vue';
import type { SetupContext } from 'vue'
import { useRouter, useRoute } from 'vue-router'
const router = useRouter()
const route = useRoute()

type FComponentProps = {
    padding: string,
    background: string
}

const refButton = (props: FComponentProps, context) => {
    let tmp = ref(context.slots.href()[0]);
    console.log(props.padding)

    tmp.value.children = h('button', {
        onClick() {
            context.emit('sendPath', '/category')
        },
        style: `padding: ${props.padding}; 
        background: ${props.background};
        border-radius: 5px;
        outline: none;
        color: white;
        border: none;`
    }, context.slots.content());

    return tmp.value;
}

refButton.emits = {
    sendPath: (value: unknown) => typeof value === 'string'
}

export default refButton;