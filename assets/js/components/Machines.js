import React, {Component, useState} from "react";
import {Route, Routes, Navigate, Link, withRouter, useParams, useLocation, generatePath} from 'react-router-dom';
import axios from "axios";
import Machine from './Machine'
import AddMachine from './AddMachine'
import {Modal} from "react-overlays";
import lithuania from "../../../public/images/flags/lithuania-flag.png";
import poland from "../../../public/images/flags/poland-flag.png";
import germany from "../../../public/images/flags/germany-flag.png";
import england from "../../../public/images/flags/england-flag.png";
import sweden from "../../../public/images/flags/sweden-flag.png";
const inputData = {};
const fetchData = () => {
    axios({
        method: 'GET',
        url: inputData.cUrl,
        headers: {
            'content-type': 'text/html'
        }
    })
        .then(response => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(response, 'text/html');
            console.log(doc)
        })
        .catch(e => console.log(e))
}

class Machines extends Component {

    constructor() {
        super();
        this.state = {machines: [], loading: true}
    }

    componentDidMount() {
        this.getMachines();
    }

    getMachines() {
        axios.get('http://saitynai.ktu/api/v1/machines').then(machines => {
            this.setState({machines: machines.data, loading: false});
        })
    }

    render() {
        return(
            <div>
                <div className={"container"}>
                    <div className={"col-lg-12"}>
                        <button className={"btn btn-primary"} style={{marginTop: 20 + 'px'}}>
                            <Link to="/add-machine">Add Machine</Link>
                        </button>
                        <div className={"all-locations"}>
                            <div className={"heading-section"}>
                                <h4>
                                    <em>All</em>
                                    &nbsp;Machines
                                </h4>
                            </div>
                            <ul>
                                {this.state.machines.map(machines =>
                                    <li key={machines.id}>
                                        <h4 style={{color: "white"}}>
                                            <span style={{color: '#007bff'}}>{machines.name}</span> <br/>
                                            <span style={{color: '#007bff'}}>CPU:</span> {machines.cpu}<br/>
                                            <span style={{color: '#007bff'}}>STORAGE:</span> {machines.storage}<br/>
                                            <span style={{color: '#007bff'}}>RAM:</span> {machines.ram}<br/>
                                            <span style={{color: '#007bff'}}>Location:</span> {inputData.cUrl = machines.location}<br/>
                                            <span style={{color: 'red'}}>${machines.price}</span>/mo
                                        </h4>
                                        <div className={"main-button"}>
                                            <Link to={'/machine/' + machines.id}>Order Now</Link>
                                        </div>
                                        <Routes>
                                            <Route path={'/machine/:id'} element={<Machine />} />
                                        </Routes>
                                    </li>
                                )}
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        );
    }

}

export default Machines;