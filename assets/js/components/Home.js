import React, {Component} from 'react';
import {Route, Routes,Navigate, Link, withRouter} from 'react-router-dom';
import axios from "axios";

const server = require('../../../public/images/ServerCabinet.svg');

// Country flags
const lithuania = require('../../../public/images/flags/lithuania-flag.png');
const poland = require('../../../public/images/flags/poland-flag.png');
const germany = require('../../../public/images/flags/germany-flag.png');
const england = require('../../../public/images/flags/england-flag.png');
const sweden = require('../../../public/images/flags/sweden-flag.png');

class Home extends Component {

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
        return (
            <div>

                <div className={"container"}>
                    <div className={"welcome"}>
                        <div className={"row"}>
                            <div className={"col-lg-7"}>
                                <div className={"header-text"}>
                                    <h6>Welcome to my project</h6>
                                    <h4>
                                        <em>Browse</em>
                                        &nbsp;Our Popular Machines
                                    </h4>
                                    <div className={"main-button"}>
                                        <Link to={"/machines"}>Browse Now</Link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div className={"our-locations"}>
                        <div className={"row"}>
                            <div className={"col-lg-12"}>
                                <div className={"heading-section"}>
                                    <h4>
                                        <em>Most Popular</em>
                                        &nbsp;Locations
                                    </h4>
                                    <div className={"row"}>
                                        {this.state.locations.map(locations =>
                                            <div className={"col-lg-3 col-sm-6 countries"} key={locations.id}>
                                                <div className={"item"}>
                                                    {locations.name == "Lithuania" && <img src={lithuania} />}
                                                    {locations.name == "Poland" && <img src={poland} />}
                                                    {locations.name == "Germany" && <img src={germany} />}
                                                    {locations.name == "England" && <img src={england} />}
                                                    {locations.name == "Sweden" && <img src={sweden} />}
                                                    <h4>
                                                        {locations.name}
                                                    </h4>
                                                </div>
                                            </div>
                                        )}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        )
    }
}

export default Home;