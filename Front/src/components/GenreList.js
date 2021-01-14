import React, { Component } from 'react';
import axios from 'axios';
import ListGroup from 'react-bootstrap/ListGroup'

export class GenreList extends Component {
    constructor(props) {
        super(props)

        this.state = {
            genres: [],
            errorMsg: ''
        }
    }

    componentDidMount() {
        axios
            .get('http://localhost:8080/api/genres')
            .then(response => {
                console.log(response)
                this.setState({ genres: response["data"]["hydra:member"] })
            })
            .catch(error => {
                console.log(error)
                this.setState({ errorMsg: 'Error retrieving data' })
            })
    }

    render() {
        const { genres, errorMsg } = this.state
        return (
            <ListGroup>
                {genres.length
                    ? genres.map(genre => <ListGroup.Item action key={genre.id}>{genre.name}</ListGroup.Item>)
                    : null}
                {errorMsg ? <div>{errorMsg}</div> : null}
            </ListGroup>
        )
    }
}

export default GenreList