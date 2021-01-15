import React, { Component } from 'react';
import axios from 'axios';
import { ListGroup, Card } from 'react-bootstrap'
import MovieList from './MovieList'

export class GenreList extends Component {
    constructor(props) {
        super(props)

        this.state = {
            genres: [],
            genreSelected: null,
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

    changeGenre(genreId) {
        if (this.state.genreSelected && genreId === this.state.genreSelected.id) {
            this.setState({ genreSelected: this.state.genreSelected });
            return;
        }

        <MovieList valueFromGenre={this.state.genreSelected} />

        // axios
        //     .get('http://localhost:8080/api/movies/' + id)
        //     .then(response => {
        //         this.setState({ genreSelected: response["data"] });
        //     })
        //     .catch(error => {
        //         this.setState({ errorMsg: 'Error retrieving movie' })
        //     })
    };

    render() {
        const { genres, errorMsg, genreSelected } = this.state
        return (
            <Card>
                <ListGroup variant="flush">
                    {genres.length
                        ? genres.map(genre => <ListGroup.Item action key={genre.id} onClick={(e) => { this.changeGenre(genre.id) }}>{genre.name}</ListGroup.Item>)
                        : null}
                    {errorMsg ? <div>{errorMsg}</div> : null}
                </ListGroup>
            </Card>
        )
    }
}

export default GenreList