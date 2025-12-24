--
-- PostgreSQL database dump
--

-- Dumped from database version 14.18 (Homebrew)
-- Dumped by pg_dump version 14.18 (Homebrew)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: video_status; Type: TYPE; Schema: public; Owner: -
--

CREATE TYPE public.video_status AS ENUM (
    'en_attente',
    'active',
    'terminee'
);


SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: apprenant_cours_statut; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.apprenant_cours_statut (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    formateur_id bigint NOT NULL,
    matiere_nom character varying(255) NOT NULL,
    statut character varying(30) DEFAULT 'en_cours'::character varying NOT NULL,
    created_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    updated_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    CONSTRAINT apprenant_cours_statut_formateur_id_check CHECK ((formateur_id > 0)),
    CONSTRAINT apprenant_cours_statut_id_check CHECK ((id > 0)),
    CONSTRAINT apprenant_cours_statut_statut_check CHECK (((statut)::text = ANY ((ARRAY['en_cours'::character varying, 'termine'::character varying, 'enregistre'::character varying])::text[]))),
    CONSTRAINT apprenant_cours_statut_user_id_check CHECK ((user_id > 0))
);


--
-- Name: apprenant_cours_statut_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

ALTER TABLE public.apprenant_cours_statut ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.apprenant_cours_statut_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: cache; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.cache (
    key character varying(255) NOT NULL,
    value text NOT NULL,
    expiration integer NOT NULL
);


--
-- Name: cache_locks; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.cache_locks (
    key character varying(255) NOT NULL,
    owner character varying(255) NOT NULL,
    expiration integer NOT NULL
);


--
-- Name: calls; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.calls (
    id bigint NOT NULL,
    caller_id bigint NOT NULL,
    receiver_id bigint NOT NULL,
    started_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    ended_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    duration integer,
    status character varying(30) DEFAULT 'missed'::character varying NOT NULL,
    was_answered smallint DEFAULT 0 NOT NULL,
    created_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    updated_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    CONSTRAINT calls_caller_id_check CHECK ((caller_id > 0)),
    CONSTRAINT calls_id_check CHECK ((id > 0)),
    CONSTRAINT calls_receiver_id_check CHECK ((receiver_id > 0)),
    CONSTRAINT calls_status_check CHECK (((status)::text = ANY ((ARRAY['missed'::character varying, 'rejected'::character varying, 'ended'::character varying, 'answered'::character varying])::text[])))
);


--
-- Name: calls_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

ALTER TABLE public.calls ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.calls_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: classe_semestre; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.classe_semestre (
    id bigint NOT NULL,
    classe_id bigint NOT NULL,
    semestre integer NOT NULL,
    actif smallint DEFAULT 1 NOT NULL,
    created_at timestamp without time zone,
    updated_at timestamp without time zone,
    CONSTRAINT classe_semestre_classe_id_check CHECK ((classe_id > 0)),
    CONSTRAINT classe_semestre_id_check CHECK ((id > 0))
);


--
-- Name: COLUMN classe_semestre.semestre; Type: COMMENT; Schema: public; Owner: -
--

COMMENT ON COLUMN public.classe_semestre.semestre IS 'Numéro du semestre (1-10)';


--
-- Name: classe_semestre_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

ALTER TABLE public.classe_semestre ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.classe_semestre_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: classe_user; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.classe_user (
    id bigint NOT NULL,
    classe_id bigint NOT NULL,
    user_id bigint NOT NULL,
    role character varying(30) DEFAULT 'apprenant'::character varying NOT NULL,
    created_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    updated_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    CONSTRAINT classe_user_classe_id_check CHECK ((classe_id > 0)),
    CONSTRAINT classe_user_id_check CHECK ((id > 0)),
    CONSTRAINT classe_user_role_check CHECK (((role)::text = ANY ((ARRAY['apprenant'::character varying, 'formateur'::character varying])::text[]))),
    CONSTRAINT classe_user_user_id_check CHECK ((user_id > 0))
);


--
-- Name: classe_user_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

ALTER TABLE public.classe_user ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.classe_user_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: classes; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.classes (
    id bigint NOT NULL,
    code character varying(50) DEFAULT NULL::character varying,
    filiere character varying(255) DEFAULT NULL::character varying,
    niveau_etude character varying(255) DEFAULT NULL::character varying,
    description text,
    actif smallint DEFAULT 1 NOT NULL,
    created_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    updated_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    CONSTRAINT classes_id_check CHECK ((id > 0))
);


--
-- Name: classes_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

ALTER TABLE public.classes ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.classes_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: cours; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.cours (
    id bigint NOT NULL,
    titre character varying(255) NOT NULL,
    description text,
    image_couverture character varying(255) DEFAULT NULL::character varying,
    contenu jsonb,
    filiere character varying(255) NOT NULL,
    niveau_etude character varying(255) NOT NULL,
    formateur_id bigint,
    duree character varying(255) DEFAULT NULL::character varying,
    duree_quiz integer,
    ordre integer DEFAULT 0 NOT NULL,
    actif smallint DEFAULT 1 NOT NULL,
    created_at timestamp without time zone,
    updated_at timestamp without time zone,
    CONSTRAINT cours_formateur_id_check CHECK ((formateur_id > 0)),
    CONSTRAINT cours_id_check CHECK ((id > 0))
);


--
-- Name: cours_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

ALTER TABLE public.cours ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.cours_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: devoir_questions; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.devoir_questions (
    id bigint NOT NULL,
    devoir_id bigint NOT NULL,
    type character varying(20) DEFAULT 'vrai_faux'::character varying NOT NULL,
    question text NOT NULL,
    options jsonb,
    image character varying(255) DEFAULT NULL::character varying,
    reponse_correcte text,
    ordre integer DEFAULT 0 NOT NULL,
    points integer DEFAULT 1 NOT NULL,
    explication text,
    created_at timestamp without time zone,
    updated_at timestamp without time zone,
    CONSTRAINT devoir_questions_type_check CHECK (((type)::text = ANY ((ARRAY['vrai_faux'::character varying, 'choix_multiple'::character varying, 'texte_libre'::character varying, 'image'::character varying, 'numerique'::character varying])::text[])))
);


--
-- Name: devoir_questions_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

ALTER TABLE public.devoir_questions ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.devoir_questions_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: devoir_reponses; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.devoir_reponses (
    id bigint NOT NULL,
    devoir_id bigint NOT NULL,
    devoir_question_id bigint NOT NULL,
    user_id bigint NOT NULL,
    reponse text,
    reponses_multiple jsonb,
    soumis_le timestamp without time zone DEFAULT '2025-11-17 12:26:58'::timestamp without time zone NOT NULL,
    created_at timestamp without time zone,
    updated_at timestamp without time zone
);


--
-- Name: devoir_reponses_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

ALTER TABLE public.devoir_reponses ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.devoir_reponses_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: devoir_tentatives; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.devoir_tentatives (
    id bigint NOT NULL,
    devoir_id bigint NOT NULL,
    user_id bigint NOT NULL,
    heure_debut timestamp without time zone,
    heure_fin_prevue timestamp without time zone,
    soumis smallint DEFAULT 0 NOT NULL,
    soumis_le timestamp without time zone,
    created_at timestamp without time zone,
    updated_at timestamp without time zone
);


--
-- Name: devoir_tentatives_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

ALTER TABLE public.devoir_tentatives ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.devoir_tentatives_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: devoirs; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.devoirs (
    id bigint NOT NULL,
    formateur_id bigint NOT NULL,
    matiere_id bigint,
    titre character varying(255) NOT NULL,
    description text,
    image_couverture character varying(255) DEFAULT NULL::character varying,
    date_devoir date,
    heure_debut time without time zone,
    heure_fin time without time zone,
    points_total integer DEFAULT 20 NOT NULL,
    actif smallint DEFAULT 1 NOT NULL,
    code_securite character varying(6) DEFAULT NULL::character varying,
    created_at timestamp without time zone,
    updated_at timestamp without time zone
);


--
-- Name: devoirs_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

ALTER TABLE public.devoirs ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.devoirs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: emploi_du_temps; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.emploi_du_temps (
    id bigint NOT NULL,
    classe character varying(255) NOT NULL,
    fichier character varying(255) NOT NULL,
    type_fichier character varying(255) DEFAULT NULL::character varying,
    created_at timestamp without time zone,
    updated_at timestamp without time zone
);


--
-- Name: emploi_du_temps_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

ALTER TABLE public.emploi_du_temps ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.emploi_du_temps_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: evaluation_resultats; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.evaluation_resultats (
    id bigint NOT NULL,
    evaluation_id bigint NOT NULL,
    user_id bigint NOT NULL,
    note numeric(5,2) DEFAULT NULL::numeric,
    questions_reussies integer DEFAULT 0 NOT NULL,
    questions_total integer DEFAULT 0 NOT NULL,
    commentaires_formateur text,
    date_debut timestamp without time zone,
    date_fin timestamp without time zone,
    statut character varying(20) DEFAULT 'en_attente'::character varying NOT NULL,
    created_at timestamp without time zone,
    updated_at timestamp without time zone,
    CONSTRAINT evaluation_resultats_statut_check CHECK (((statut)::text = ANY ((ARRAY['en_attente'::character varying, 'en_cours'::character varying, 'termine'::character varying, 'corrige'::character varying])::text[])))
);


--
-- Name: evaluation_resultats_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

ALTER TABLE public.evaluation_resultats ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.evaluation_resultats_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: evaluations; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.evaluations (
    id bigint NOT NULL,
    titre character varying(255) NOT NULL,
    description text,
    type character varying(10) DEFAULT 'quiz'::character varying NOT NULL,
    cours_id bigint,
    classe_id bigint,
    duree_minutes integer,
    nombre_questions integer DEFAULT 0 NOT NULL,
    date_debut timestamp without time zone NOT NULL,
    date_limite timestamp without time zone NOT NULL,
    note_max integer DEFAULT 20 NOT NULL,
    actif smallint DEFAULT 1 NOT NULL,
    created_at timestamp without time zone,
    updated_at timestamp without time zone,
    CONSTRAINT evaluations_type_check CHECK (((type)::text = ANY ((ARRAY['quiz'::character varying, 'devoir'::character varying, 'examen'::character varying])::text[])))
);


--
-- Name: evaluations_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

ALTER TABLE public.evaluations ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.evaluations_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: evenements; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.evenements (
    id bigint NOT NULL,
    titre character varying(255) NOT NULL,
    description text,
    type character varying(20) DEFAULT 'autre'::character varying NOT NULL,
    cours_id bigint,
    classe_id bigint,
    date_debut timestamp without time zone NOT NULL,
    date_fin timestamp without time zone,
    date_limite timestamp without time zone,
    notification_envoyee smallint DEFAULT 0 NOT NULL,
    actif smallint DEFAULT 1 NOT NULL,
    created_at timestamp without time zone,
    updated_at timestamp without time zone,
    CONSTRAINT evenements_type_check CHECK (((type)::text = ANY ((ARRAY['examen'::character varying, 'devoir'::character varying, 'session'::character varying, 'alerte'::character varying, 'autre'::character varying])::text[])))
);


--
-- Name: evenements_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

ALTER TABLE public.evenements ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.evenements_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: events; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.events (
    id bigint NOT NULL,
    titre character varying(255) NOT NULL,
    type character varying(10) NOT NULL,
    scheduled_at timestamp without time zone NOT NULL,
    classe_id character varying(50) DEFAULT NULL::character varying,
    cours_id bigint,
    rappel_minutes integer,
    created_at timestamp without time zone,
    updated_at timestamp without time zone,
    CONSTRAINT events_type_check CHECK (((type)::text = ANY ((ARRAY['Examen'::character varying, 'Devoir'::character varying, 'Session'::character varying])::text[])))
);


--
-- Name: events_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

ALTER TABLE public.events ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.events_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: examen_questions; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.examen_questions (
    id bigint NOT NULL,
    examen_id bigint NOT NULL,
    type character varying(20) DEFAULT 'vrai_faux'::character varying NOT NULL,
    question text NOT NULL,
    options jsonb,
    image character varying(255) DEFAULT NULL::character varying,
    reponse_correcte text,
    ordre integer DEFAULT 0 NOT NULL,
    points integer DEFAULT 1 NOT NULL,
    explication text,
    created_at timestamp without time zone,
    updated_at timestamp without time zone,
    CONSTRAINT examen_questions_type_check CHECK (((type)::text = ANY ((ARRAY['vrai_faux'::character varying, 'choix_multiple'::character varying, 'texte_libre'::character varying, 'image'::character varying, 'numerique'::character varying])::text[])))
);


--
-- Name: examen_questions_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

ALTER TABLE public.examen_questions ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.examen_questions_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: examen_reponses; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.examen_reponses (
    id bigint NOT NULL,
    examen_id bigint NOT NULL,
    examen_question_id bigint NOT NULL,
    user_id bigint NOT NULL,
    reponse text,
    reponses_multiple jsonb,
    soumis_le timestamp without time zone DEFAULT '2025-11-17 12:39:47'::timestamp without time zone NOT NULL,
    created_at timestamp without time zone,
    updated_at timestamp without time zone
);


--
-- Name: examen_reponses_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

ALTER TABLE public.examen_reponses ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.examen_reponses_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: examen_tentatives; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.examen_tentatives (
    id bigint NOT NULL,
    examen_id bigint NOT NULL,
    user_id bigint NOT NULL,
    heure_debut timestamp without time zone,
    heure_fin_prevue timestamp without time zone,
    soumis smallint DEFAULT 0 NOT NULL,
    soumis_le timestamp without time zone,
    created_at timestamp without time zone,
    updated_at timestamp without time zone
);


--
-- Name: examen_tentatives_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

ALTER TABLE public.examen_tentatives ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.examen_tentatives_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: examens; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.examens (
    id bigint NOT NULL,
    formateur_id bigint NOT NULL,
    matiere_id bigint,
    titre character varying(255) NOT NULL,
    description text,
    date_examen date,
    heure_debut time without time zone,
    heure_fin time without time zone,
    duree_minutes integer,
    points_total integer DEFAULT 20 NOT NULL,
    actif smallint DEFAULT 1 NOT NULL,
    code_securite character varying(6) DEFAULT NULL::character varying,
    created_at timestamp without time zone,
    updated_at timestamp without time zone
);


--
-- Name: examens_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

ALTER TABLE public.examens ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.examens_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: failed_jobs; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.failed_jobs (
    id bigint NOT NULL,
    uuid character varying(255) NOT NULL,
    connection text NOT NULL,
    queue text NOT NULL,
    payload text NOT NULL,
    exception text NOT NULL,
    failed_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);


--
-- Name: failed_jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

ALTER TABLE public.failed_jobs ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.failed_jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: favoris; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.favoris (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    formateur_id bigint NOT NULL,
    matiere_nom character varying(255) NOT NULL,
    created_at timestamp without time zone,
    updated_at timestamp without time zone
);


--
-- Name: favoris_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

ALTER TABLE public.favoris ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.favoris_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: formateur_matiere; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.formateur_matiere (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    matiere_id bigint NOT NULL,
    created_at timestamp without time zone,
    updated_at timestamp without time zone
);


--
-- Name: formateur_matiere_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

ALTER TABLE public.formateur_matiere ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.formateur_matiere_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: forum_groups; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.forum_groups (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    description text,
    created_by bigint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


--
-- Name: forum_groups_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.forum_groups_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: forum_groups_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.forum_groups_id_seq OWNED BY public.forum_groups.id;


--
-- Name: forum_participants; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.forum_participants (
    id integer NOT NULL,
    forum_sujet_id bigint NOT NULL,
    user_id bigint NOT NULL,
    created_at timestamp without time zone,
    updated_at timestamp without time zone
);


--
-- Name: forum_participants_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.forum_participants_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: forum_participants_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.forum_participants_id_seq OWNED BY public.forum_participants.id;


--
-- Name: job_batches; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.job_batches (
    id character varying(255) NOT NULL,
    name character varying(255) NOT NULL,
    total_jobs integer NOT NULL,
    pending_jobs integer NOT NULL,
    failed_jobs integer NOT NULL,
    failed_job_ids text NOT NULL,
    options text,
    cancelled_at integer,
    created_at integer NOT NULL,
    finished_at integer
);


--
-- Name: jobs; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.jobs (
    id bigint NOT NULL,
    queue character varying(255) NOT NULL,
    payload text NOT NULL,
    attempts smallint NOT NULL,
    reserved_at integer,
    available_at integer NOT NULL,
    created_at integer NOT NULL
);


--
-- Name: jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

ALTER TABLE public.jobs ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: matieres; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.matieres (
    id bigint NOT NULL,
    filiere character varying(255) DEFAULT NULL::character varying,
    niveau_etude character varying(255) DEFAULT NULL::character varying,
    semestre character varying(255) DEFAULT NULL::character varying,
    nom_matiere character varying(255) NOT NULL,
    ordre integer,
    created_at timestamp without time zone,
    updated_at timestamp without time zone
);


--
-- Name: matieres_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

ALTER TABLE public.matieres ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.matieres_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: messages; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.messages (
    id bigint NOT NULL,
    sender_id bigint NOT NULL,
    receiver_id bigint NOT NULL,
    content text NOT NULL,
    label character varying(30) DEFAULT 'Normal'::character varying,
    read_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    created_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    updated_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    CONSTRAINT messages_id_check CHECK ((id > 0)),
    CONSTRAINT messages_label_check CHECK (((label)::text = ANY ((ARRAY['Normal'::character varying, 'Signalement'::character varying, 'Urgent'::character varying, 'System'::character varying])::text[]))),
    CONSTRAINT messages_receiver_id_check CHECK ((receiver_id > 0)),
    CONSTRAINT messages_sender_id_check CHECK ((sender_id > 0))
);


--
-- Name: messages_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

ALTER TABLE public.messages ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.messages_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: migrations; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL,
    CONSTRAINT migrations_id_check CHECK ((id > 0))
);


--
-- Name: migrations_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

ALTER TABLE public.migrations ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.migrations_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: modules; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.modules (
    id bigint NOT NULL,
    cours_id bigint NOT NULL,
    titre character varying(255) NOT NULL,
    description text,
    contenu text,
    ordre integer DEFAULT 0 NOT NULL,
    actif smallint DEFAULT 1 NOT NULL,
    created_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    updated_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    CONSTRAINT modules_cours_id_check CHECK ((cours_id > 0)),
    CONSTRAINT modules_id_check CHECK ((id > 0))
);


--
-- Name: modules_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

ALTER TABLE public.modules ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.modules_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: notes; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.notes (
    id bigint NOT NULL,
    matricule character varying(255) NOT NULL,
    nom character varying(255) NOT NULL,
    prenom character varying(255) NOT NULL,
    annee_naissance date,
    classe character varying(255) NOT NULL,
    niveau_etude character varying(255) DEFAULT NULL::character varying,
    semestre character varying(255) DEFAULT NULL::character varying,
    coefficient character varying(255) DEFAULT NULL::character varying,
    devoir numeric(5,2) DEFAULT 0.00 NOT NULL,
    examen numeric(5,2) DEFAULT 0.00 NOT NULL,
    quiz numeric(5,2) DEFAULT 0.00 NOT NULL,
    moyenne numeric(5,2) DEFAULT 0.00 NOT NULL,
    redoubler smallint DEFAULT 0 NOT NULL,
    created_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    updated_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    CONSTRAINT notes_id_check CHECK ((id > 0))
);


--
-- Name: notes_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

ALTER TABLE public.notes ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.notes_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: outbox_notifications; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.outbox_notifications (
    id bigint NOT NULL,
    title character varying(255) NOT NULL,
    body text NOT NULL,
    audience character varying(30) NOT NULL,
    user_id bigint,
    status character varying(255) DEFAULT 'enregistré'::character varying NOT NULL,
    read_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    created_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    updated_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    CONSTRAINT outbox_notifications_audience_check CHECK (((audience)::text = ANY ((ARRAY['tous'::character varying, 'apprenants'::character varying, 'formateurs'::character varying, 'utilisateur'::character varying])::text[]))),
    CONSTRAINT outbox_notifications_id_check CHECK ((id > 0)),
    CONSTRAINT outbox_notifications_user_id_check CHECK ((user_id > 0))
);


--
-- Name: outbox_notifications_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

ALTER TABLE public.outbox_notifications ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.outbox_notifications_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: password_reset_tokens; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.password_reset_tokens (
    email character varying(255) NOT NULL,
    token character varying(255) NOT NULL,
    created_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone
);


--
-- Name: questions; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.questions (
    id bigint NOT NULL,
    cours_id bigint NOT NULL,
    section_index integer DEFAULT 0 NOT NULL,
    type character varying(30) DEFAULT 'vrai_faux'::character varying NOT NULL,
    question text NOT NULL,
    options jsonb,
    image character varying(255) DEFAULT NULL::character varying,
    reponse_correcte text,
    ordre integer DEFAULT 0 NOT NULL,
    points integer DEFAULT 1 NOT NULL,
    explication text,
    created_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    updated_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    CONSTRAINT questions_cours_id_check CHECK ((cours_id > 0)),
    CONSTRAINT questions_id_check CHECK ((id > 0)),
    CONSTRAINT questions_type_check CHECK (((type)::text = ANY ((ARRAY['vrai_faux'::character varying, 'choix_multiple'::character varying, 'texte_libre'::character varying, 'image'::character varying, 'numerique'::character varying])::text[])))
);


--
-- Name: questions_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

ALTER TABLE public.questions ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.questions_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: quiz_attempts; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.quiz_attempts (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    cours_id bigint NOT NULL,
    section_index integer DEFAULT 0 NOT NULL,
    attempt_number integer DEFAULT 1 NOT NULL,
    score integer,
    total_questions integer,
    answers text,
    started_at timestamp without time zone,
    completed_at timestamp without time zone,
    created_at timestamp without time zone,
    updated_at timestamp without time zone
);


--
-- Name: quiz_attempts_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

ALTER TABLE public.quiz_attempts ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.quiz_attempts_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: sessions; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.sessions (
    id character varying(255) NOT NULL,
    user_id bigint,
    ip_address character varying(45) DEFAULT NULL::character varying,
    user_agent text,
    payload text NOT NULL,
    last_activity integer NOT NULL
);


--
-- Name: student_bulletins; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.student_bulletins (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    file_path character varying(255) NOT NULL,
    semestre integer NOT NULL,
    classe character varying(255) DEFAULT NULL::character varying,
    sent_by bigint,
    created_at timestamp without time zone,
    updated_at timestamp without time zone
);


--
-- Name: student_bulletins_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

ALTER TABLE public.student_bulletins ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.student_bulletins_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: student_results; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.student_results (
    id bigint NOT NULL,
    matricule character varying(255) NOT NULL,
    nom character varying(255) NOT NULL,
    prenom character varying(255) NOT NULL,
    annee_naissance date,
    classe character varying(255) DEFAULT NULL::character varying,
    semestre character varying(255) DEFAULT NULL::character varying,
    coefficient integer,
    devoir numeric(5,2) DEFAULT NULL::numeric,
    examen numeric(5,2) DEFAULT NULL::numeric,
    quiz numeric(5,2) DEFAULT NULL::numeric,
    moyenne numeric(5,2) DEFAULT NULL::numeric,
    redoubler smallint DEFAULT 0 NOT NULL,
    user_id bigint,
    created_at timestamp without time zone,
    updated_at timestamp without time zone
);


--
-- Name: student_results_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

ALTER TABLE public.student_results ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.student_results_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: users; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.users (
    id bigint NOT NULL,
    matricule character varying(255) DEFAULT NULL::character varying,
    name character varying(255) NOT NULL,
    nom character varying(255) DEFAULT NULL::character varying,
    prenom character varying(255) DEFAULT NULL::character varying,
    date_naissance date,
    photo character varying(255) DEFAULT NULL::character varying,
    diplome character varying(255) DEFAULT NULL::character varying,
    carte_identite character varying(255) DEFAULT NULL::character varying,
    role character varying(255) DEFAULT NULL::character varying,
    statut character varying(255) DEFAULT 'actif'::character varying NOT NULL,
    motif_blocage text,
    motivation text,
    canal_decouverte character varying(255) DEFAULT NULL::character varying,
    categorie_formation character varying(255) DEFAULT NULL::character varying,
    filiere character varying(255) DEFAULT NULL::character varying,
    classe_id character varying(50) DEFAULT NULL::character varying,
    paiement_method character varying(255) DEFAULT NULL::character varying,
    paiement_statut character varying(255) DEFAULT 'en attente'::character varying NOT NULL,
    paiement_confirme smallint DEFAULT 0 NOT NULL,
    date_confirmation_paiement timestamp without time zone,
    montant_paye numeric(10,2) DEFAULT NULL::numeric,
    date_paiement timestamp without time zone,
    orientation_complete smallint DEFAULT 0 NOT NULL,
    date_orientation timestamp without time zone,
    niveau_etude character varying(255) DEFAULT 'Licence 1'::character varying NOT NULL,
    est_promu smallint DEFAULT 0 NOT NULL,
    est_redoublant smallint DEFAULT 0 NOT NULL,
    annee_academique character varying(255) DEFAULT NULL::character varying,
    email character varying(255) NOT NULL,
    phone character varying(255) DEFAULT NULL::character varying,
    location character varying(255) DEFAULT NULL::character varying,
    nationalite character varying(2) DEFAULT NULL::character varying,
    is_admin smallint DEFAULT 0 NOT NULL,
    last_login timestamp without time zone,
    is_blocked smallint DEFAULT 0 NOT NULL,
    email_verified_at timestamp without time zone,
    password character varying(255) NOT NULL,
    remember_token character varying(100) DEFAULT NULL::character varying,
    created_at timestamp without time zone,
    updated_at timestamp without time zone,
    last_seen timestamp without time zone
);


--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

ALTER TABLE public.users ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: video_session_chat_messages; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.video_session_chat_messages (
    id bigint NOT NULL,
    video_session_id bigint NOT NULL,
    user_id bigint NOT NULL,
    message text NOT NULL,
    created_at timestamp without time zone,
    updated_at timestamp without time zone,
    CONSTRAINT video_session_chat_messages_id_check CHECK ((id > 0))
);


--
-- Name: video_session_chat_messages_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

ALTER TABLE public.video_session_chat_messages ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.video_session_chat_messages_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: video_session_participants; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.video_session_participants (
    id bigint NOT NULL,
    video_session_id bigint NOT NULL,
    user_id bigint NOT NULL,
    statut text DEFAULT 'en_attente'::text NOT NULL,
    micro_actif smallint DEFAULT 0 NOT NULL,
    camera_active smallint DEFAULT 0 NOT NULL,
    micro_controle_par_formateur smallint DEFAULT 0 NOT NULL,
    camera_controlee_par_formateur smallint DEFAULT 0 NOT NULL,
    main_levee smallint DEFAULT 0 NOT NULL,
    est_epingle smallint DEFAULT 0 NOT NULL,
    raison_refus text,
    date_entree timestamp without time zone,
    date_sortie timestamp without time zone,
    created_at timestamp without time zone,
    updated_at timestamp without time zone,
    CONSTRAINT video_session_participants_id_check CHECK ((id > 0))
);


--
-- Name: video_session_participants_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

ALTER TABLE public.video_session_participants ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.video_session_participants_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: video_sessions; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.video_sessions (
    id bigint NOT NULL,
    session_id character varying(255) NOT NULL,
    cours_id bigint,
    formateur_id bigint NOT NULL,
    pinned_participant_id bigint,
    titre character varying(255) DEFAULT NULL::character varying,
    description text,
    statut public.video_status DEFAULT 'en_attente'::public.video_status NOT NULL,
    vue_mode character varying(255) DEFAULT 'grille'::character varying NOT NULL,
    enregistrement_actif smallint DEFAULT 0 NOT NULL,
    date_debut timestamp without time zone,
    date_fin timestamp without time zone,
    created_at timestamp without time zone,
    updated_at timestamp without time zone,
    is_muted_globally boolean DEFAULT false NOT NULL
);


--
-- Name: video_sessions_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

ALTER TABLE public.video_sessions ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.video_sessions_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: forum_groups id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.forum_groups ALTER COLUMN id SET DEFAULT nextval('public.forum_groups_id_seq'::regclass);


--
-- Name: forum_participants id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.forum_participants ALTER COLUMN id SET DEFAULT nextval('public.forum_participants_id_seq'::regclass);


--
-- Name: apprenant_cours_statut apprenant_cours_statut_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.apprenant_cours_statut
    ADD CONSTRAINT apprenant_cours_statut_pkey PRIMARY KEY (id);


--
-- Name: apprenant_cours_statut apprenant_cours_statut_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.apprenant_cours_statut
    ADD CONSTRAINT apprenant_cours_statut_unique UNIQUE (user_id, formateur_id, matiere_nom);


--
-- Name: cache_locks cache_locks_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.cache_locks
    ADD CONSTRAINT cache_locks_pkey PRIMARY KEY (key);


--
-- Name: cache cache_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.cache
    ADD CONSTRAINT cache_pkey PRIMARY KEY (key);


--
-- Name: calls calls_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.calls
    ADD CONSTRAINT calls_pkey PRIMARY KEY (id);


--
-- Name: classe_semestre classe_semestre_classe_id_semestre_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.classe_semestre
    ADD CONSTRAINT classe_semestre_classe_id_semestre_unique UNIQUE (classe_id, semestre);


--
-- Name: classe_semestre classe_semestre_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.classe_semestre
    ADD CONSTRAINT classe_semestre_pkey PRIMARY KEY (id);


--
-- Name: classe_user classe_user_classe_id_user_id_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.classe_user
    ADD CONSTRAINT classe_user_classe_id_user_id_unique UNIQUE (classe_id, user_id);


--
-- Name: classe_user classe_user_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.classe_user
    ADD CONSTRAINT classe_user_pkey PRIMARY KEY (id);


--
-- Name: classes classes_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.classes
    ADD CONSTRAINT classes_pkey PRIMARY KEY (id);


--
-- Name: cours cours_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.cours
    ADD CONSTRAINT cours_pkey PRIMARY KEY (id);


--
-- Name: devoir_questions devoir_questions_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.devoir_questions
    ADD CONSTRAINT devoir_questions_pkey PRIMARY KEY (id);


--
-- Name: devoir_reponses devoir_reponses_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.devoir_reponses
    ADD CONSTRAINT devoir_reponses_pkey PRIMARY KEY (id);


--
-- Name: devoir_tentatives devoir_tentatives_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.devoir_tentatives
    ADD CONSTRAINT devoir_tentatives_pkey PRIMARY KEY (id);


--
-- Name: devoirs devoirs_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.devoirs
    ADD CONSTRAINT devoirs_pkey PRIMARY KEY (id);


--
-- Name: emploi_du_temps emploi_du_temps_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.emploi_du_temps
    ADD CONSTRAINT emploi_du_temps_pkey PRIMARY KEY (id);


--
-- Name: evaluation_resultats evaluation_resultats_evaluation_id_user_id_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.evaluation_resultats
    ADD CONSTRAINT evaluation_resultats_evaluation_id_user_id_unique UNIQUE (evaluation_id, user_id);


--
-- Name: evaluation_resultats evaluation_resultats_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.evaluation_resultats
    ADD CONSTRAINT evaluation_resultats_pkey PRIMARY KEY (id);


--
-- Name: evaluations evaluations_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.evaluations
    ADD CONSTRAINT evaluations_pkey PRIMARY KEY (id);


--
-- Name: evenements evenements_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.evenements
    ADD CONSTRAINT evenements_pkey PRIMARY KEY (id);


--
-- Name: events events_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.events
    ADD CONSTRAINT events_pkey PRIMARY KEY (id);


--
-- Name: examen_questions examen_questions_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.examen_questions
    ADD CONSTRAINT examen_questions_pkey PRIMARY KEY (id);


--
-- Name: examen_reponses examen_reponses_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.examen_reponses
    ADD CONSTRAINT examen_reponses_pkey PRIMARY KEY (id);


--
-- Name: examen_tentatives examen_tentatives_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.examen_tentatives
    ADD CONSTRAINT examen_tentatives_pkey PRIMARY KEY (id);


--
-- Name: examens examens_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.examens
    ADD CONSTRAINT examens_pkey PRIMARY KEY (id);


--
-- Name: failed_jobs failed_jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_pkey PRIMARY KEY (id);


--
-- Name: failed_jobs failed_jobs_uuid_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_uuid_unique UNIQUE (uuid);


--
-- Name: favoris favoris_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.favoris
    ADD CONSTRAINT favoris_pkey PRIMARY KEY (id);


--
-- Name: favoris favoris_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.favoris
    ADD CONSTRAINT favoris_unique UNIQUE (user_id, formateur_id, matiere_nom);


--
-- Name: formateur_matiere formateur_matiere_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.formateur_matiere
    ADD CONSTRAINT formateur_matiere_pkey PRIMARY KEY (id);


--
-- Name: formateur_matiere formateur_matiere_user_id_matiere_id_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.formateur_matiere
    ADD CONSTRAINT formateur_matiere_user_id_matiere_id_unique UNIQUE (user_id, matiere_id);


--
-- Name: forum_groups forum_groups_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.forum_groups
    ADD CONSTRAINT forum_groups_pkey PRIMARY KEY (id);


--
-- Name: forum_participants forum_participants_forum_sujet_id_user_id_key; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.forum_participants
    ADD CONSTRAINT forum_participants_forum_sujet_id_user_id_key UNIQUE (forum_sujet_id, user_id);


--
-- Name: forum_participants forum_participants_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.forum_participants
    ADD CONSTRAINT forum_participants_pkey PRIMARY KEY (id);


--
-- Name: job_batches job_batches_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.job_batches
    ADD CONSTRAINT job_batches_pkey PRIMARY KEY (id);


--
-- Name: jobs jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.jobs
    ADD CONSTRAINT jobs_pkey PRIMARY KEY (id);


--
-- Name: matieres matieres_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.matieres
    ADD CONSTRAINT matieres_pkey PRIMARY KEY (id);


--
-- Name: messages messages_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.messages
    ADD CONSTRAINT messages_pkey PRIMARY KEY (id);


--
-- Name: migrations migrations_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);


--
-- Name: modules modules_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.modules
    ADD CONSTRAINT modules_pkey PRIMARY KEY (id);


--
-- Name: notes notes_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.notes
    ADD CONSTRAINT notes_pkey PRIMARY KEY (id);


--
-- Name: outbox_notifications outbox_notifications_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.outbox_notifications
    ADD CONSTRAINT outbox_notifications_pkey PRIMARY KEY (id);


--
-- Name: password_reset_tokens password_reset_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.password_reset_tokens
    ADD CONSTRAINT password_reset_tokens_pkey PRIMARY KEY (email);


--
-- Name: questions questions_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.questions
    ADD CONSTRAINT questions_pkey PRIMARY KEY (id);


--
-- Name: quiz_attempts quiz_attempts_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.quiz_attempts
    ADD CONSTRAINT quiz_attempts_pkey PRIMARY KEY (id);


--
-- Name: sessions sessions_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.sessions
    ADD CONSTRAINT sessions_pkey PRIMARY KEY (id);


--
-- Name: student_bulletins student_bulletins_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.student_bulletins
    ADD CONSTRAINT student_bulletins_pkey PRIMARY KEY (id);


--
-- Name: student_results student_results_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.student_results
    ADD CONSTRAINT student_results_pkey PRIMARY KEY (id);


--
-- Name: quiz_attempts unique_quiz_attempt; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.quiz_attempts
    ADD CONSTRAINT unique_quiz_attempt UNIQUE (user_id, cours_id, section_index, attempt_number);


--
-- Name: devoir_tentatives unique_tentative_active; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.devoir_tentatives
    ADD CONSTRAINT unique_tentative_active UNIQUE (devoir_id, user_id, soumis);


--
-- Name: users users_email_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_unique UNIQUE (email);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- Name: video_session_chat_messages video_session_chat_messages_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.video_session_chat_messages
    ADD CONSTRAINT video_session_chat_messages_pkey PRIMARY KEY (id);


--
-- Name: video_session_participants video_session_participants_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.video_session_participants
    ADD CONSTRAINT video_session_participants_pkey PRIMARY KEY (id);


--
-- Name: video_session_participants video_session_participants_video_session_id_user_id_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.video_session_participants
    ADD CONSTRAINT video_session_participants_video_session_id_user_id_unique UNIQUE (video_session_id, user_id);


--
-- Name: video_sessions video_sessions_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.video_sessions
    ADD CONSTRAINT video_sessions_pkey PRIMARY KEY (id);


--
-- Name: video_sessions video_sessions_session_id_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.video_sessions
    ADD CONSTRAINT video_sessions_session_id_unique UNIQUE (session_id);


--
-- Name: apprenant_cours_statut_formateur_id_foreign; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX apprenant_cours_statut_formateur_id_foreign ON public.apprenant_cours_statut USING btree (formateur_id);


--
-- Name: calls_caller_id_receiver_id_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX calls_caller_id_receiver_id_index ON public.calls USING btree (caller_id, receiver_id);


--
-- Name: calls_receiver_id_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX calls_receiver_id_index ON public.calls USING btree (receiver_id);


--
-- Name: calls_started_at_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX calls_started_at_index ON public.calls USING btree (started_at);


--
-- Name: classe_semestre_classe_id_semestre_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX classe_semestre_classe_id_semestre_index ON public.classe_semestre USING btree (classe_id, semestre);


--
-- Name: classe_user_user_id_foreign; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX classe_user_user_id_foreign ON public.classe_user USING btree (user_id);


--
-- Name: cours_filiere_niveau_etude_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX cours_filiere_niveau_etude_index ON public.cours USING btree (filiere, niveau_etude);


--
-- Name: cours_formateur_id_foreign; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX cours_formateur_id_foreign ON public.cours USING btree (formateur_id);


--
-- Name: devoir_questions_devoir_id_ordre_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX devoir_questions_devoir_id_ordre_index ON public.devoir_questions USING btree (devoir_id, ordre);


--
-- Name: devoir_reponses_devoir_id_user_id_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX devoir_reponses_devoir_id_user_id_index ON public.devoir_reponses USING btree (devoir_id, user_id);


--
-- Name: devoir_reponses_devoir_question_id_user_id_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX devoir_reponses_devoir_question_id_user_id_index ON public.devoir_reponses USING btree (devoir_question_id, user_id);


--
-- Name: devoir_reponses_user_id_foreign; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX devoir_reponses_user_id_foreign ON public.devoir_reponses USING btree (user_id);


--
-- Name: devoir_tentatives_user_id_foreign; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX devoir_tentatives_user_id_foreign ON public.devoir_tentatives USING btree (user_id);


--
-- Name: devoirs_formateur_id_foreign; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX devoirs_formateur_id_foreign ON public.devoirs USING btree (formateur_id);


--
-- Name: devoirs_matiere_id_foreign; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX devoirs_matiere_id_foreign ON public.devoirs USING btree (matiere_id);


--
-- Name: evaluation_resultats_user_id_foreign; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX evaluation_resultats_user_id_foreign ON public.evaluation_resultats USING btree (user_id);


--
-- Name: evaluations_classe_id_foreign; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX evaluations_classe_id_foreign ON public.evaluations USING btree (classe_id);


--
-- Name: evaluations_cours_id_foreign; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX evaluations_cours_id_foreign ON public.evaluations USING btree (cours_id);


--
-- Name: evenements_classe_id_foreign; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX evenements_classe_id_foreign ON public.evenements USING btree (classe_id);


--
-- Name: evenements_cours_id_foreign; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX evenements_cours_id_foreign ON public.evenements USING btree (cours_id);


--
-- Name: evenements_date_debut_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX evenements_date_debut_index ON public.evenements USING btree (date_debut);


--
-- Name: examen_questions_examen_id_ordre_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX examen_questions_examen_id_ordre_index ON public.examen_questions USING btree (examen_id, ordre);


--
-- Name: examen_reponses_examen_id_user_id_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX examen_reponses_examen_id_user_id_index ON public.examen_reponses USING btree (examen_id, user_id);


--
-- Name: examen_reponses_examen_question_id_user_id_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX examen_reponses_examen_question_id_user_id_index ON public.examen_reponses USING btree (examen_question_id, user_id);


--
-- Name: examen_reponses_user_id_foreign; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX examen_reponses_user_id_foreign ON public.examen_reponses USING btree (user_id);


--
-- Name: examen_tentatives_examen_id_user_id_soumis_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX examen_tentatives_examen_id_user_id_soumis_index ON public.examen_tentatives USING btree (examen_id, user_id, soumis);


--
-- Name: examen_tentatives_user_id_foreign; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX examen_tentatives_user_id_foreign ON public.examen_tentatives USING btree (user_id);


--
-- Name: examens_formateur_id_foreign; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX examens_formateur_id_foreign ON public.examens USING btree (formateur_id);


--
-- Name: examens_matiere_id_foreign; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX examens_matiere_id_foreign ON public.examens USING btree (matiere_id);


--
-- Name: favoris_formateur_id_foreign; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX favoris_formateur_id_foreign ON public.favoris USING btree (formateur_id);


--
-- Name: formateur_matiere_matiere_id_foreign; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX formateur_matiere_matiere_id_foreign ON public.formateur_matiere USING btree (matiere_id);


--
-- Name: jobs_queue_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX jobs_queue_index ON public.jobs USING btree (queue);


--
-- Name: matieres_filiere_niveau_etude_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX matieres_filiere_niveau_etude_index ON public.matieres USING btree (filiere, niveau_etude);


--
-- Name: modules_cours_id_foreign; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX modules_cours_id_foreign ON public.modules USING btree (cours_id);


--
-- Name: notes_matricule_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX notes_matricule_index ON public.notes USING btree (matricule);


--
-- Name: notes_nom_prenom_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX notes_nom_prenom_index ON public.notes USING btree (nom, prenom);


--
-- Name: questions_cours_id_section_index_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX questions_cours_id_section_index_index ON public.questions USING btree (cours_id, section_index);


--
-- Name: questions_ordre_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX questions_ordre_index ON public.questions USING btree (ordre);


--
-- Name: quiz_attempts_cours_id_foreign; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX quiz_attempts_cours_id_foreign ON public.quiz_attempts USING btree (cours_id);


--
-- Name: quiz_attempts_user_id_cours_id_section_index_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX quiz_attempts_user_id_cours_id_section_index_index ON public.quiz_attempts USING btree (user_id, cours_id, section_index);


--
-- Name: sessions_last_activity_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX sessions_last_activity_index ON public.sessions USING btree (last_activity);


--
-- Name: sessions_user_id_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX sessions_user_id_index ON public.sessions USING btree (user_id);


--
-- Name: student_bulletins_semestre_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX student_bulletins_semestre_index ON public.student_bulletins USING btree (semestre);


--
-- Name: student_bulletins_sent_by_foreign; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX student_bulletins_sent_by_foreign ON public.student_bulletins USING btree (sent_by);


--
-- Name: student_bulletins_user_id_semestre_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX student_bulletins_user_id_semestre_index ON public.student_bulletins USING btree (user_id, semestre);


--
-- Name: student_results_matricule_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX student_results_matricule_index ON public.student_results USING btree (matricule);


--
-- Name: student_results_user_id_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX student_results_user_id_index ON public.student_results USING btree (user_id);


--
-- Name: video_session_chat_messages_user_id_foreign; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX video_session_chat_messages_user_id_foreign ON public.video_session_chat_messages USING btree (user_id);


--
-- Name: video_session_chat_messages_video_session_id_foreign; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX video_session_chat_messages_video_session_id_foreign ON public.video_session_chat_messages USING btree (video_session_id);


--
-- Name: video_session_participants_user_id_foreign; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX video_session_participants_user_id_foreign ON public.video_session_participants USING btree (user_id);


--
-- Name: video_sessions_cours_id_foreign; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX video_sessions_cours_id_foreign ON public.video_sessions USING btree (cours_id);


--
-- Name: video_sessions_formateur_id_foreign; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX video_sessions_formateur_id_foreign ON public.video_sessions USING btree (formateur_id);


--
-- Name: video_sessions_pinned_participant_id_foreign; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX video_sessions_pinned_participant_id_foreign ON public.video_sessions USING btree (pinned_participant_id);


--
-- Name: apprenant_cours_statut apprenant_cours_statut_formateur_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.apprenant_cours_statut
    ADD CONSTRAINT apprenant_cours_statut_formateur_id_foreign FOREIGN KEY (formateur_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: apprenant_cours_statut apprenant_cours_statut_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.apprenant_cours_statut
    ADD CONSTRAINT apprenant_cours_statut_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: calls calls_caller_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.calls
    ADD CONSTRAINT calls_caller_id_foreign FOREIGN KEY (caller_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: calls calls_receiver_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.calls
    ADD CONSTRAINT calls_receiver_id_foreign FOREIGN KEY (receiver_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: classe_semestre classe_semestre_classe_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.classe_semestre
    ADD CONSTRAINT classe_semestre_classe_id_foreign FOREIGN KEY (classe_id) REFERENCES public.classes(id) ON DELETE CASCADE;


--
-- Name: classe_user classe_user_classe_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.classe_user
    ADD CONSTRAINT classe_user_classe_id_foreign FOREIGN KEY (classe_id) REFERENCES public.classes(id) ON DELETE CASCADE;


--
-- Name: classe_user classe_user_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.classe_user
    ADD CONSTRAINT classe_user_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: cours cours_formateur_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.cours
    ADD CONSTRAINT cours_formateur_id_foreign FOREIGN KEY (formateur_id) REFERENCES public.users(id) ON DELETE SET NULL;


--
-- Name: devoir_questions devoir_questions_devoir_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.devoir_questions
    ADD CONSTRAINT devoir_questions_devoir_id_foreign FOREIGN KEY (devoir_id) REFERENCES public.devoirs(id) ON DELETE CASCADE;


--
-- Name: devoir_reponses devoir_reponses_devoir_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.devoir_reponses
    ADD CONSTRAINT devoir_reponses_devoir_id_foreign FOREIGN KEY (devoir_id) REFERENCES public.devoirs(id) ON DELETE CASCADE;


--
-- Name: devoir_reponses devoir_reponses_devoir_question_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.devoir_reponses
    ADD CONSTRAINT devoir_reponses_devoir_question_id_foreign FOREIGN KEY (devoir_question_id) REFERENCES public.devoir_questions(id) ON DELETE CASCADE;


--
-- Name: devoir_reponses devoir_reponses_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.devoir_reponses
    ADD CONSTRAINT devoir_reponses_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: devoir_tentatives devoir_tentatives_devoir_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.devoir_tentatives
    ADD CONSTRAINT devoir_tentatives_devoir_id_foreign FOREIGN KEY (devoir_id) REFERENCES public.devoirs(id) ON DELETE CASCADE;


--
-- Name: devoir_tentatives devoir_tentatives_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.devoir_tentatives
    ADD CONSTRAINT devoir_tentatives_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: devoirs devoirs_formateur_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.devoirs
    ADD CONSTRAINT devoirs_formateur_id_foreign FOREIGN KEY (formateur_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: devoirs devoirs_matiere_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.devoirs
    ADD CONSTRAINT devoirs_matiere_id_foreign FOREIGN KEY (matiere_id) REFERENCES public.matieres(id) ON DELETE SET NULL;


--
-- Name: evaluation_resultats evaluation_resultats_evaluation_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.evaluation_resultats
    ADD CONSTRAINT evaluation_resultats_evaluation_id_foreign FOREIGN KEY (evaluation_id) REFERENCES public.evaluations(id) ON DELETE CASCADE;


--
-- Name: evaluation_resultats evaluation_resultats_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.evaluation_resultats
    ADD CONSTRAINT evaluation_resultats_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: evaluations evaluations_classe_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.evaluations
    ADD CONSTRAINT evaluations_classe_id_foreign FOREIGN KEY (classe_id) REFERENCES public.classes(id) ON DELETE SET NULL;


--
-- Name: evaluations evaluations_cours_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.evaluations
    ADD CONSTRAINT evaluations_cours_id_foreign FOREIGN KEY (cours_id) REFERENCES public.cours(id) ON DELETE SET NULL;


--
-- Name: evenements evenements_classe_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.evenements
    ADD CONSTRAINT evenements_classe_id_foreign FOREIGN KEY (classe_id) REFERENCES public.classes(id) ON DELETE SET NULL;


--
-- Name: evenements evenements_cours_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.evenements
    ADD CONSTRAINT evenements_cours_id_foreign FOREIGN KEY (cours_id) REFERENCES public.cours(id) ON DELETE SET NULL;


--
-- Name: examen_questions examen_questions_examen_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.examen_questions
    ADD CONSTRAINT examen_questions_examen_id_foreign FOREIGN KEY (examen_id) REFERENCES public.examens(id) ON DELETE CASCADE;


--
-- Name: examen_reponses examen_reponses_examen_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.examen_reponses
    ADD CONSTRAINT examen_reponses_examen_id_foreign FOREIGN KEY (examen_id) REFERENCES public.examens(id) ON DELETE CASCADE;


--
-- Name: examen_reponses examen_reponses_examen_question_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.examen_reponses
    ADD CONSTRAINT examen_reponses_examen_question_id_foreign FOREIGN KEY (examen_question_id) REFERENCES public.examen_questions(id) ON DELETE CASCADE;


--
-- Name: examen_reponses examen_reponses_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.examen_reponses
    ADD CONSTRAINT examen_reponses_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: examen_tentatives examen_tentatives_examen_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.examen_tentatives
    ADD CONSTRAINT examen_tentatives_examen_id_foreign FOREIGN KEY (examen_id) REFERENCES public.examens(id) ON DELETE CASCADE;


--
-- Name: examen_tentatives examen_tentatives_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.examen_tentatives
    ADD CONSTRAINT examen_tentatives_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: examens examens_formateur_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.examens
    ADD CONSTRAINT examens_formateur_id_foreign FOREIGN KEY (formateur_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: examens examens_matiere_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.examens
    ADD CONSTRAINT examens_matiere_id_foreign FOREIGN KEY (matiere_id) REFERENCES public.matieres(id) ON DELETE SET NULL;


--
-- Name: favoris favoris_formateur_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.favoris
    ADD CONSTRAINT favoris_formateur_id_foreign FOREIGN KEY (formateur_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: favoris favoris_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.favoris
    ADD CONSTRAINT favoris_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: formateur_matiere formateur_matiere_matiere_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.formateur_matiere
    ADD CONSTRAINT formateur_matiere_matiere_id_foreign FOREIGN KEY (matiere_id) REFERENCES public.matieres(id) ON DELETE CASCADE;


--
-- Name: formateur_matiere formateur_matiere_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.formateur_matiere
    ADD CONSTRAINT formateur_matiere_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: forum_groups forum_groups_created_by_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.forum_groups
    ADD CONSTRAINT forum_groups_created_by_foreign FOREIGN KEY (created_by) REFERENCES public.users(id);


--
-- Name: forum_participants forum_participants_user_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.forum_participants
    ADD CONSTRAINT forum_participants_user_id_fkey FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: modules modules_cours_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.modules
    ADD CONSTRAINT modules_cours_id_foreign FOREIGN KEY (cours_id) REFERENCES public.cours(id) ON DELETE CASCADE;


--
-- Name: questions questions_cours_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.questions
    ADD CONSTRAINT questions_cours_id_foreign FOREIGN KEY (cours_id) REFERENCES public.cours(id) ON DELETE CASCADE;


--
-- Name: quiz_attempts quiz_attempts_cours_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.quiz_attempts
    ADD CONSTRAINT quiz_attempts_cours_id_foreign FOREIGN KEY (cours_id) REFERENCES public.cours(id) ON DELETE CASCADE;


--
-- Name: quiz_attempts quiz_attempts_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.quiz_attempts
    ADD CONSTRAINT quiz_attempts_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: student_bulletins student_bulletins_sent_by_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.student_bulletins
    ADD CONSTRAINT student_bulletins_sent_by_foreign FOREIGN KEY (sent_by) REFERENCES public.users(id) ON DELETE SET NULL;


--
-- Name: student_bulletins student_bulletins_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.student_bulletins
    ADD CONSTRAINT student_bulletins_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: video_session_chat_messages video_session_chat_messages_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.video_session_chat_messages
    ADD CONSTRAINT video_session_chat_messages_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: video_session_chat_messages video_session_chat_messages_video_session_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.video_session_chat_messages
    ADD CONSTRAINT video_session_chat_messages_video_session_id_foreign FOREIGN KEY (video_session_id) REFERENCES public.video_sessions(id) ON DELETE CASCADE;


--
-- Name: video_session_participants video_session_participants_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.video_session_participants
    ADD CONSTRAINT video_session_participants_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: video_session_participants video_session_participants_video_session_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.video_session_participants
    ADD CONSTRAINT video_session_participants_video_session_id_foreign FOREIGN KEY (video_session_id) REFERENCES public.video_sessions(id) ON DELETE CASCADE;


--
-- Name: video_sessions video_sessions_cours_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.video_sessions
    ADD CONSTRAINT video_sessions_cours_id_foreign FOREIGN KEY (cours_id) REFERENCES public.cours(id) ON DELETE CASCADE;


--
-- Name: video_sessions video_sessions_formateur_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.video_sessions
    ADD CONSTRAINT video_sessions_formateur_id_foreign FOREIGN KEY (formateur_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: video_sessions video_sessions_pinned_participant_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.video_sessions
    ADD CONSTRAINT video_sessions_pinned_participant_id_foreign FOREIGN KEY (pinned_participant_id) REFERENCES public.video_session_participants(id) ON DELETE SET NULL;


--
-- PostgreSQL database dump complete
--

--
-- PostgreSQL database dump
--

-- Dumped from database version 14.18 (Homebrew)
-- Dumped by pg_dump version 14.18 (Homebrew)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Data for Name: migrations; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.migrations (id, migration, batch) FROM stdin;
1	0001_01_01_000000_create_users_table	1
2	0001_01_01_000001_create_cache_table	1
3	0001_01_01_000002_create_jobs_table	1
4	2025_11_01_171923_add_fields_to_users_table	2
5	2025_11_02_021708_add_orientation_fields_to_users_table	3
6	2025_11_02_024232_add_paiement_method_to_users_table	4
7	2025_11_02_045347_add_paiement_confirme_to_users_table	5
8	2025_11_02_153549_create_matieres_table	6
9	2025_11_02_183937_add_role_and_admin_to_users_table	7
10	2025_11_02_193129_create_cours_table	8
11	2025_11_02_193138_create_modules_table	8
12	2025_11_02_193140_create_classes_table	8
13	2025_11_02_193141_create_evenements_table	8
14	2025_11_02_193143_create_forum_sujets_table	8
15	2025_11_02_193144_create_evaluations_table	8
16	2025_11_03_003141_remove_duplicate_matieres	9
17	2025_11_03_003825_create_classe_user_table	10
18	2025_11_03_014553_create_formateur_matiere_table	11
19	2025_11_03_044146_add_phone_location_to_users_table	12
20	2025_11_03_000001_create_events_table	13
21	2025_11_03_000002_create_outbox_notifications_table	13
22	2025_11_03_000003_create_messages_table	14
23	2025_11_03_100000_create_student_results_table	15
24	2025_11_03_220426_add_last_seen_to_users_table	16
26	2025_01_15_000000_add_semestre_to_matieres_table	17
27	2025_11_08_115128_update_role_column_position_and_values	17
28	2025_11_08_130818_add_image_and_content_to_cours_table	18
29	2025_11_08_140340_create_questions_table	19
30	2025_11_08_153508_create_devoirs_table	20
31	2025_11_08_153509_create_examens_table	20
32	2025_11_08_171110_add_heure_fields_to_devoirs_table	21
33	2025_11_10_020606_add_nationalite_to_users_table	22
34	2025_11_10_031204_add_classe_id_to_users_table	23
35	2025_11_10_171115_make_nom_nullable_in_classes_table	24
36	2025_11_10_171259_remove_nom_from_classes_table	25
37	2025_11_10_173457_remove_capacite_max_from_classes_table	26
38	2025_11_10_175124_add_statut_to_users_table	27
39	2025_11_10_185851_make_niveau_etude_nullable_in_matieres_table	28
40	2025_11_10_185949_make_filiere_nullable_in_matieres_table	29
41	2025_11_10_195351_add_semestre_to_student_results_table	30
42	2025_11_10_200800_add_coefficient_to_student_results_table	31
43	2025_11_10_210754_change_classe_id_to_string_in_events_table	32
44	2025_11_13_023031_create_favoris_table	33
45	2025_11_13_030219_create_apprenant_cours_statut_table	34
46	2025_11_13_055525_create_emploi_du_temps_table	35
47	2025_01_15_000000_add_duree_quiz_to_cours_table	36
48	2025_01_15_100000_create_quiz_attempts_table	37
49	2025_11_16_124819_create_notes_table	38
50	2025_11_16_133223_change_semestre_to_string_in_matieres_table	39
51	2025_11_16_161717_add_motif_blocage_to_users_table	40
52	2025_11_17_020504_add_image_couverture_to_devoirs_table	41
53	2025_11_17_022219_add_image_couverture_to_examens_table	42
54	2025_11_17_121020_create_devoir_reponses_table	43
55	2025_11_17_123648_create_examen_reponses_table	44
56	2025_11_17_133046_add_code_securite_to_devoirs_table	45
57	2025_11_17_162007_create_devoir_tentatives_table	46
58	2025_11_17_163330_create_examen_tentatives_table	47
59	2025_11_17_163458_add_code_securite_to_examens_table	48
60	2025_11_19_001243_add_read_at_to_messages_table	49
61	2025_11_24_172547_add_diplome_and_carte_identite_to_users_table	50
62	2025_11_26_005802_add_matricule_to_users_table	51
63	2025_11_26_012910_add_niveau_etude_to_notes_table	52
64	2025_11_26_152517_create_student_bulletins_table	53
65	2025_11_26_182333_add_code_to_classes_table_and_create_classe_semestre_table	54
66	2025_11_26_233557_add_read_at_to_outbox_notifications_table	55
68	2025_11_28_033820_add_system_to_messages_label_enum	56
69	2025_11_28_034118_create_calls_table	57
70	2025_11_28_194138_add_promotion_fields_to_users_table	58
71	2025_11_28_225432_create_video_sessions_table	59
72	2025_11_28_234025_create_video_session_chat_messages_table	60
73	2025_11_29_000917_add_advanced_features_to_video_sessions_table	61
74	2025_11_29_113041_add_hand_raised_to_video_session_participants_table	62
\.


--
-- Name: migrations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.migrations_id_seq', 7, true);


--
-- PostgreSQL database dump complete
--

