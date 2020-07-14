import axios from 'axios';

export default ()=>{
    let params = {
        headers : {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    };
    return axios.create(params)
}
