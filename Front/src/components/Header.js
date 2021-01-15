import React, { Component, useState } from 'react';
import { Navbar, Nav, Form, FormControl, Button, Dropdown } from 'react-bootstrap';
import axios from 'axios';

export class Header extends Component {
    constructor() {
        super();
        this.state = {
            movies: [],
            text: '',
            errorMsg: '',
            checked: false
        };
        this.timer = null;
    }

    componentDidUpdate(prevProps, prevState) {
        if (prevState.text !== this.state.text) {
            this.handleCheck();
        }
    }

    onChange = e => {
        this.setState({
            text: e.target.value
        });
    };

    handleCheck = () => {
        // Clears running timer and starts a new one each time the user types
        clearTimeout(this.timer);
        this.timer = setTimeout(() => {
            this.searchMovie();
        }, 1000);
    }

    searchMovie = () => {
        const term = this.state.text;
        axios
            .get('http://localhost:8080/api/movies?term=' + term)
            .then(response => {
                console.log(response);
                this.setState({ movies: response["data"]["hydra:member"] })
            })
            .catch(error => {
                this.setState({ errorMsg: 'Error retrieving data' })
            })
    }

    render() {
        const { movies, errorMsg, } = this.state;
        return (
            <Navbar bg="dark" variant="dark" fixed="top">
                <Navbar.Brand href="#home">WeCine</Navbar.Brand>
                <Nav className="mr-auto">
                </Nav>
                <Form inline>
                    <Dropdown>
                        <Dropdown.Toggle variant="success" id="dropdown-basic">
                            <input
                                type="text"
                                value={this.state.text} onChange={this.onChange}
                            />
                        </Dropdown.Toggle>

                        <Dropdown.Menu>
                            {movies.map((movie, index) => (
                                <div>
                                    <Dropdown.Item key={movie.id}>{movie.title}</Dropdown.Item>
                                </div>
                            ))}
                        </Dropdown.Menu>
                    </Dropdown>
                    <Button variant="outline-info">Rechercher</Button>
                </Form>
            </Navbar>
        )
    }
}

export default Header