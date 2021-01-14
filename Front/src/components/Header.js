import React, { Component } from 'react';
import { Navbar, Nav, Form, FormControl, Button } from 'react-bootstrap';

export class Header extends Component {
    render() {
        return (
            <Navbar bg="dark" variant="dark" fixed="top">
                <Navbar.Brand href="#home">WeCine</Navbar.Brand>
                <Nav className="mr-auto">
                </Nav>
                <Form inline>
                    <FormControl type="text" placeholder="Recherche" className="mr-sm-2" />
                    <Button variant="outline-info">Rechercher</Button>
                </Form>
            </Navbar>
        )
    }
}

export default Header