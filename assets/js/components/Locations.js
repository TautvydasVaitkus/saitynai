import React, {Component} from "react";
import {Route, Routes, Navigate, Link, withRouter, useNavigate} from 'react-router-dom';
import axios from "axios";
import Machines from './Machines';
import lithuania from "../../../public/images/flags/lithuania-flag.png";
import poland from "../../../public/images/flags/poland-flag.png";
import germany from "../../../public/images/flags/germany-flag.png";
import england from "../../../public/images/flags/england-flag.png";
import sweden from "../../../public/images/flags/sweden-flag.png";

class Locations extends Component {
    constructor() {
        super();
        this.state = {locations: [], loading: true}
    }

    componentDidMount() {
        this.getLocations();
    }

    getLocations() {
        axios.get('http://saitynai.ktu/api/v1/locations').then(locations => {
            this.setState({locations: locations.data, loading: false})
        })
    }

    render() {
        return(
            <div>
                <div className={"container"}>
                    <div className={"col-lg-12"}>
                        <div className={"all-locations"}>
                            <div className={"heading-section"}>
                                <h4>
                                    <em>All</em>
                                    &nbsp;Locations
                                </h4>
                            </div>
                            <ul>
                                {this.state.locations.map(locations =>
                                    <li key={locations.id}>
                                        {locations.name == "Lithuania" && <img src={lithuania}/>}
                                        {locations.name == "Poland" && <img src={poland}/>}
                                        {locations.name == "Germany" && <img src={germany}/>}
                                        {locations.name == "England" && <img src={england}/>}
                                        {locations.name == "Sweden" && <img src={sweden}/>}
                                        <h4 style={{color: "white"}}>
                                            {locations.name}
                                        </h4>
                                    </li>
                                )}
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        )
    }
}

export default Locations;