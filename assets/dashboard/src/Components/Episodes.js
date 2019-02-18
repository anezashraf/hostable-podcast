import React from 'react'
import {bindActionCreators} from "redux";
import {fetchEpisodes, updateEpisode, uploadImage, uploadAudio} from "../modules/episode";
import {connect} from "react-redux";
import EpisodeForm from '../Components/Forms/EpisodeForm'


class Episodes extends React.Component {

    componentDidMount() {
        this.props.fetchEpisodes()
    }


    render() {
        let {episodes, updateEpisode, uploadImage, uploadAudio} = this.props;
        console.log(this.props);

        return (
            <section>
                    {episodes.map((value, index) => {
                        return(
                            <EpisodeForm uploadAudio={uploadAudio} uploadImage={uploadImage} key={index} episode={value} handleSave={updateEpisode} />
                            )
                    })}
            </section>
        )
    }
}


const mapStateToProps = ({ episode }) => ({
    episodes: episode.episodes
});

const mapDispatchToProps = dispatch =>
    bindActionCreators(
        {
            fetchEpisodes,
            updateEpisode,
            uploadImage,
            uploadAudio,
        },
        dispatch
    );

export default connect(
    mapStateToProps,
    mapDispatchToProps
)(Episodes)