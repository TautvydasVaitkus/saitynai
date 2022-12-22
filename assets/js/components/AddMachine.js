import React, {useState} from "react";
import {useNavigate} from "react-router-dom";
import axios from "axios";

const AddMachine = () => {

    const navigate = useNavigate();

    const [formValue, setformValue] = useState({
       nameValue: '',
       cpu: '',
       storage: '',
       ram: '',
       price: ''
    });

    const handleSubmit = (event) => {
        event.preventDefault();

        const data = {
            name: formValue.nameValue,
            cpu: formValue.cpu,
            storage: formValue.storage,
            ram: formValue.ram,
            price: parseInt(formValue.price)
        }

        const customConfig = {
            headers: {
                'Content-Type': 'application/json'
            }
        };

        axios.post("http://saitynai.ktu/api/machines", JSON.stringify(data), customConfig)
            .then(res => console.log(res))
            .catch(err => console.log(err));

        navigate('success');
    }

    const handleChange = (event) => {
        setformValue({
           ...formValue,
           [event.target.name]: event.target.value
        });
    }

    return (
        <form onSubmit={handleSubmit}>
            <p>Add Machine Form</p>
            <input
                type="text"
                name="nameValue"
                placeholder="Enter Machine Name"
                value={formValue.nameValue}
                onChange={handleChange}
            />
            <input
                type="text"
                name="cpu"
                placeholder="Enter CPU"
                value={formValue.cpu}
                onChange={handleChange}
            />
            <input
                type="text"
                name="storage"
                placeholder="Enter Storage Amount"
                value={formValue.storage}
                onChange={handleChange}
            />
            <input
                type="text"
                name="ram"
                placeholder="Enter RAM"
                value={formValue.ram}
                onChange={handleChange}
            />
            <input
                type="number"
                name="price"
                placeholder="Enter Monthly Price"
                value={formValue.price}
                onChange={handleChange}
            />

            <button type="submit">Add Machine</button>
        </form>
    )
};

export default AddMachine;